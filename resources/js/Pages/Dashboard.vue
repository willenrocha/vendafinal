<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BottomNav from '@/Components/BottomNav.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

interface Props {
    instagram_profiles: Array<{
        id: number;
        username: string;
        full_name: string;
        follower_count: string;
        media_count: string;
    }>;
    instagram_profile?: {
        id: number;
        username: string | null;
        full_name: string | null;
        biography: string | null;
        profile_pic: string | null;
        follower_count: string;
        following_count: string;
        media_count: string;
        is_verified: boolean;
    } | null;
    recent_posts: Array<{
        id: number;
        shortcode: string;
        image: string | null;
        like_count: string;
        comment_count: string;
        instagram_url: string;
    }>;
    credits: {
        likes: number;
        views: number;
        comments: number;
    };
    recent_orders: Array<any>;
    stats: {
        total_orders: number;
        pending_orders: number;
        completed_orders: number;
        total_spent: string;
    };
}

const props = defineProps<Props>();

const showPurchaseModal = ref(false);
const showPostModal = ref(false);
const selectedPost = ref<Props['recent_posts'][0] | null>(null);
const creditType = ref<'likes' | 'views' | 'comments'>('likes');
const creditAmount = ref(1);
const isRedeeming = ref(false);
const redeemError = ref('');
const redeemSuccess = ref('');
const localCredits = ref({ ...props.credits });

const openPurchaseModal = () => {
    showPurchaseModal.value = true;
};

const closePurchaseModal = () => {
    showPurchaseModal.value = false;
};

const openPostModal = (post: Props['recent_posts'][0]) => {
    selectedPost.value = post;
    creditType.value = 'likes';
    creditAmount.value = 1;
    redeemError.value = '';
    redeemSuccess.value = '';
    showPostModal.value = true;
};

const closePostModal = () => {
    showPostModal.value = false;
    selectedPost.value = null;
};

const maxCreditAmount = computed(() => {
    return localCredits.value[creditType.value] || 0;
});

const redeemCredits = async () => {
    if (!selectedPost.value || creditAmount.value <= 0) return;
    if (creditAmount.value > maxCreditAmount.value) {
        redeemError.value = 'Saldo insuficiente para essa quantidade.';
        return;
    }

    isRedeeming.value = true;
    redeemError.value = '';
    redeemSuccess.value = '';

    try {
        const response = await fetch('/dashboard/redeem-credits', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                post_id: selectedPost.value.id,
                credit_type: creditType.value,
                amount: creditAmount.value,
            }),
        });

        const data = await response.json();

        if (response.ok) {
            redeemSuccess.value = 'Créditos aplicados com sucesso!';
            localCredits.value = data.credits;
            // Limpa o form
            creditAmount.value = 1;
        } else {
            redeemError.value = data.message || 'Erro ao aplicar créditos.';
        }
    } catch {
        redeemError.value = 'Erro de conexão. Tente novamente.';
    } finally {
        isRedeeming.value = false;
    }
};

const profilePic = computed(() => {
    if (props.instagram_profile?.profile_pic) {
        const pic = props.instagram_profile.profile_pic;

        // Se já for data:image, http, https ou /proxy-image, usa direto
        if (pic.startsWith('data:image') || pic.startsWith('http') || pic.startsWith('/proxy-image')) {
            return pic;
        }

        // Senão, assume que é base64 puro e adiciona o prefixo
        return `data:image/jpeg;base64,${pic}`;
    }
    return `https://ui-avatars.com/api/?name=${encodeURIComponent(props.instagram_profile?.username || 'Cliente')}&background=6108EF&color=fff&size=200&bold=true`;
});

const changeProfile = (event: Event) => {
    const target = event.target as HTMLSelectElement;
    const profileId = parseInt(target.value);
    // Usar POST para trocar perfil (mantém URL limpa)
    router.post('/dashboard/switch-profile', { profile_id: profileId });
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="pb-24 bg-white min-h-screen">
            <!-- Top Header -->
            <div class="bg-white border-b border-gray-200">
                <div class="max-w-screen-xl mx-auto px-4 py-3">
                    <!-- Profile Selector (se tiver mais de 1 perfil) -->
                    <div v-if="instagram_profiles && instagram_profiles.length > 1" class="mb-3">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Seus Perfis</label>
                        <select
                            @change="changeProfile"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                        >
                            <option
                                v-for="profile in instagram_profiles"
                                :key="profile.id"
                                :value="profile.id"
                                :selected="instagram_profile?.id === profile.id"
                            >
                                @{{ profile.username }} ({{ profile.follower_count }} seguidores)
                            </option>
                        </select>
                    </div>

                    <!-- Username atual -->
                    <div class="flex items-center gap-2">
                        <h1 class="text-xl font-semibold">{{ instagram_profile?.username || 'Seu Perfil' }}</h1>
                        <svg v-if="instagram_profile?.is_verified" class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23 12l-2.44-2.79.34-3.69-3.61-.82-1.89-3.2L12 2.96 8.6 1.5 6.71 4.69 3.1 5.5l.34 3.7L1 12l2.44 2.79-.34 3.69 3.61.82 1.89 3.2L12 21.04l3.4 1.46 1.89-3.2 3.61-.82-.34-3.69L23 12zm-12.91 4.72l-3.8-3.81 1.48-1.48 2.32 2.33 5.85-5.87 1.48 1.48-7.33 7.35z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Profile Section -->
            <div class="bg-white">
                <div class="max-w-screen-xl mx-auto px-4 py-4">

                    <!-- Profile Picture and Stats -->
                    <div class="flex items-center gap-6 mb-4">
                        <div class="relative flex-shrink-0">
                            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-purple-500 via-pink-500 to-orange-500 p-0.5">
                                <div class="w-full h-full rounded-full bg-white p-0.5">
                                    <img
                                        :src="profilePic"
                                        :alt="instagram_profile?.username || 'Profile'"
                                        class="w-full h-full rounded-full object-cover"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="flex-1 flex justify-around text-center">
                            <div>
                                <div class="text-lg font-bold">{{ instagram_profile?.media_count || '0' }}</div>
                                <div class="text-sm text-gray-600">posts</div>
                            </div>
                            <div>
                                <div class="text-lg font-bold">{{ instagram_profile?.follower_count || '0' }}</div>
                                <div class="text-sm text-gray-600">followers</div>
                            </div>
                            <div>
                                <div class="text-lg font-bold">{{ instagram_profile?.following_count || '0' }}</div>
                                <div class="text-sm text-gray-600">following</div>
                            </div>
                        </div>
                    </div>

                    <!-- Bio -->
                    <div class="mb-4" v-if="instagram_profile">
                        <h2 class="font-semibold text-sm mb-1">{{ instagram_profile.full_name || instagram_profile.username }}</h2>
                        <p class="text-sm" v-if="instagram_profile.biography">{{ instagram_profile.biography }}</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-2 mb-4">
                        <button class="flex-1 bg-gray-200 hover:bg-gray-300 font-semibold py-1.5 px-4 rounded-lg text-sm transition-colors">
                            Atualizar Perfil
                        </button>
                        <button @click="openPurchaseModal" class="flex-1 btn-primary text-white font-semibold py-1.5 px-4 rounded-lg text-sm transition-all shadow-md hover:shadow-lg">
                            Impulsionar Perfil
                        </button>
                    </div>

                    <!-- Credits Section -->
                    <div class="bg-gradient-to-r from-purple-50 to-blue-50 rounded-xl p-3 mb-4 border border-purple-100">
                        <h3 class="text-xs font-semibold text-gray-700 mb-2 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                            </svg>
                            Seus Créditos Disponíveis
                        </h3>

                        <div class="grid grid-cols-3 gap-2">
                            <!-- Curtidas -->
                            <div class="bg-white rounded-lg p-2 shadow-sm hover:shadow-md transition-shadow border border-pink-100">
                                <div class="flex flex-col items-center text-center">
                                    <div class="bg-gradient-to-br from-pink-500 to-rose-500 rounded-full p-1.5 mb-1">
                                        <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                        </svg>
                                    </div>
                                    <div class="text-base font-bold text-gray-900">{{ localCredits.likes.toLocaleString('pt-BR') }}</div>
                                    <div class="text-[10px] text-gray-600 font-medium">Curtidas</div>
                                </div>
                            </div>

                            <!-- Visualizações -->
                            <div class="bg-white rounded-lg p-2 shadow-sm hover:shadow-md transition-shadow border border-blue-100">
                                <div class="flex flex-col items-center text-center">
                                    <div class="bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full p-1.5 mb-1">
                                        <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                        </svg>
                                    </div>
                                    <div class="text-base font-bold text-gray-900">{{ localCredits.views.toLocaleString('pt-BR') }}</div>
                                    <div class="text-[10px] text-gray-600 font-medium">Visualizações</div>
                                </div>
                            </div>

                            <!-- Comentários -->
                            <div class="bg-white rounded-lg p-2 shadow-sm hover:shadow-md transition-shadow border border-green-100">
                                <div class="flex flex-col items-center text-center">
                                    <div class="bg-gradient-to-br from-green-500 to-emerald-500 rounded-full p-1.5 mb-1">
                                        <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z"/>
                                        </svg>
                                    </div>
                                    <div class="text-base font-bold text-gray-900">{{ localCredits.comments.toLocaleString('pt-BR') }}</div>
                                    <div class="text-[10px] text-gray-600 font-medium">Comentários</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Posts Grid -->
            <div class="bg-white">
                <div class="max-w-screen-xl mx-auto px-4">
                    <div v-if="recent_posts && recent_posts.length > 0" class="grid grid-cols-3 gap-1">
                        <div
                            v-for="post in recent_posts"
                            :key="post.id"
                            @click="openPostModal(post)"
                            class="aspect-square bg-gradient-to-br from-gray-200 to-gray-300 relative group cursor-pointer overflow-hidden"
                        >
                            <img
                                v-if="post.image"
                                :src="post.image"
                                :alt="`Post ${post.shortcode}`"
                                class="w-full h-full object-cover"
                            />
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center">
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity flex gap-4 text-white">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                        </svg>
                                        <span class="font-semibold">{{ post.like_count }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z"/>
                                        </svg>
                                        <span class="font-semibold">{{ post.comment_count }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-center py-12">
                        <p class="text-gray-500 mb-4">Nenhum post encontrado</p>
                        <button @click="openPurchaseModal" class="btn-primary text-white py-2 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all">
                            Começar Agora
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Navigation Bar -->
        <BottomNav active-page="dashboard" @open-shop="openPurchaseModal" />

        <!-- Post Modal (Credit Usage) -->
        <div v-if="showPostModal && selectedPost" @click="closePostModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div @click.stop class="bg-white rounded-3xl shadow-2xl w-full max-w-md transform transition-all overflow-hidden">

                <!-- Post Image -->
                <div class="relative aspect-square bg-gray-100">
                    <img
                        v-if="selectedPost.image"
                        :src="selectedPost.image"
                        :alt="`Post ${selectedPost.shortcode}`"
                        class="w-full h-full object-cover"
                    />
                    <!-- Close button -->
                    <button @click="closePostModal" class="absolute top-3 right-3 bg-black/50 text-white rounded-full p-2 hover:bg-black/70 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Post Stats -->
                <div class="flex gap-6 px-6 py-3 border-b border-gray-100">
                    <div class="flex items-center gap-1.5 text-gray-700">
                        <svg class="w-5 h-5 text-pink-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                        <span class="font-semibold text-sm">{{ selectedPost.like_count }}</span>
                    </div>
                    <div class="flex items-center gap-1.5 text-gray-700">
                        <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z"/>
                        </svg>
                        <span class="font-semibold text-sm">{{ selectedPost.comment_count }}</span>
                    </div>
                </div>

                <!-- Credit Usage Section -->
                <div class="p-6">
                    <h3 class="text-sm font-bold text-gray-800 mb-3">Usar Créditos neste Post</h3>

                    <!-- Credit Type Select -->
                    <div class="mb-3">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Tipo de Crédito</label>
                        <select v-model="creditType" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="likes">Curtidas (saldo: {{ localCredits.likes.toLocaleString('pt-BR') }})</option>
                            <option value="views">Visualizações (saldo: {{ localCredits.views.toLocaleString('pt-BR') }})</option>
                            <option value="comments">Comentários (saldo: {{ localCredits.comments.toLocaleString('pt-BR') }})</option>
                        </select>
                    </div>

                    <!-- Amount Input -->
                    <div class="mb-4">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Quantidade</label>
                        <input
                            v-model.number="creditAmount"
                            type="number"
                            min="1"
                            :max="maxCreditAmount"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            placeholder="Quantidade desejada"
                        />
                        <p class="text-xs text-gray-500 mt-1">Disponível: {{ maxCreditAmount.toLocaleString('pt-BR') }}</p>
                    </div>

                    <!-- Error / Success Messages -->
                    <div v-if="redeemError" class="mb-3 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
                        {{ redeemError }}
                    </div>
                    <div v-if="redeemSuccess" class="mb-3 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">
                        {{ redeemSuccess }}
                    </div>

                    <!-- Submit Button -->
                    <button
                        @click="redeemCredits"
                        :disabled="isRedeeming || creditAmount <= 0 || creditAmount > maxCreditAmount"
                        class="w-full btn-primary text-white font-semibold py-3 px-6 rounded-xl transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span v-if="isRedeeming">Aplicando...</span>
                        <span v-else>Aplicar Créditos</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Purchase Modal -->
        <div v-if="showPurchaseModal" @click="closePurchaseModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div @click.stop class="bg-white rounded-3xl shadow-2xl w-full max-w-md transform transition-all" :class="showPurchaseModal ? 'scale-100' : 'scale-95'">

                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-primary via-secondary to-accent text-white px-6 py-4 rounded-t-3xl">
                    <h2 class="text-xl font-bold text-center">Nova Compra</h2>
                </div>

                <!-- Modal Content -->
                <div class="p-6 space-y-3">
                    <!-- Instagram Section -->
                    <div class="pb-3 border-b border-gray-200">
                        <div class="flex items-center gap-3 text-gray-700">
                            <div class="bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl p-2">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </div>
                            <span class="font-semibold">Instagram</span>
                        </div>
                    </div>

                    <!-- Purchase Options -->
                    <button class="w-full flex items-center gap-4 p-4 hover:bg-gray-50 rounded-xl transition-colors group">
                        <div class="btn-primary rounded-xl p-3 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                        <span class="font-semibold text-gray-800">Comprar Seguidores</span>
                    </button>

                    <button class="w-full flex items-center gap-4 p-4 hover:bg-gray-50 rounded-xl transition-colors group">
                        <div class="btn-primary rounded-xl p-3 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </div>
                        <span class="font-semibold text-gray-800">Comprar Curtidas</span>
                    </button>

                    <button class="w-full flex items-center gap-4 p-4 hover:bg-gray-50 rounded-xl transition-colors group">
                        <div class="btn-primary rounded-xl p-3 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z"/>
                            </svg>
                        </div>
                        <span class="font-semibold text-gray-800">Comprar Comentários</span>
                    </button>

                    <button class="w-full flex items-center gap-4 p-4 hover:bg-gray-50 rounded-xl transition-colors group">
                        <div class="btn-primary rounded-xl p-3 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                            </svg>
                        </div>
                        <span class="font-semibold text-gray-800">Comprar Visualizações</span>
                    </button>
                </div>

                <!-- Close Button -->
                <div class="px-6 pb-6">
                    <button @click="closePurchaseModal" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 px-6 rounded-xl transition-colors">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.text-primary {
  color: #6108EF;
}

.btn-primary {
  background-color: #6108EF;
}

.btn-primary:hover {
  background-color: #5C00EE;
}

.from-primary {
  --tw-gradient-from: #6108EF;
}

.via-secondary {
  --tw-gradient-via: #5C00EE;
}

.to-accent {
  --tw-gradient-to: #4C85EF;
}
</style>
