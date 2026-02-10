<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BottomNav from '@/Components/BottomNav.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

interface Order {
    id: number;
    public_code: string;
    package_name: string;
    instagram_username: string | null;
    amount: string;
    status: string;
    status_label: string;
    created_at: string;
    created_at_human: string;
    paid_at: string | null;
}

interface Props {
    orders: {
        data: Order[];
        current_page: number;
        last_page: number;
        total: number;
    };
    instagram_profiles: Array<{
        id: number;
        username: string;
    }>;
    filters: {
        profile_id: number | null;
    };
}

const props = defineProps<Props>();

const selectedProfile = ref<string>(props.filters.profile_id ? String(props.filters.profile_id) : '');

const filterByProfile = () => {
    router.get(route('orders'), {
        profile_id: selectedProfile.value || undefined,
    }, {
        preserveState: true,
        preserveScroll: true,
    });
};

const statusColor = (status: string) => {
    switch (status) {
        case 'awaiting_payment':
            return 'bg-yellow-100 text-yellow-800 border-yellow-200';
        case 'paid':
            return 'bg-green-100 text-green-800 border-green-200';
        case 'cancelled':
            return 'bg-red-100 text-red-800 border-red-200';
        case 'expired':
            return 'bg-gray-100 text-gray-600 border-gray-200';
        default:
            return 'bg-gray-100 text-gray-600 border-gray-200';
    }
};

const goToPage = (page: number) => {
    router.get(route('orders'), {
        page,
        profile_id: selectedProfile.value || undefined,
    }, {
        preserveState: true,
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Meus Pedidos" />

    <AuthenticatedLayout>
        <div class="pb-24 bg-white min-h-screen">
            <!-- Header -->
            <div class="bg-white border-b border-gray-200">
                <div class="max-w-screen-xl mx-auto px-4 py-4">
                    <h1 class="text-xl font-bold text-gray-900">Meus Pedidos</h1>
                    <p class="text-sm text-gray-500 mt-1">{{ orders.total }} pedido(s) encontrado(s)</p>
                </div>
            </div>

            <!-- Filters -->
            <div class="max-w-screen-xl mx-auto px-4 py-3">
                <div v-if="instagram_profiles.length > 1" class="flex gap-2">
                    <select
                        v-model="selectedProfile"
                        @change="filterByProfile"
                        class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    >
                        <option value="">Todos os perfis</option>
                        <option v-for="profile in instagram_profiles" :key="profile.id" :value="String(profile.id)">
                            @{{ profile.username }}
                        </option>
                    </select>
                </div>
            </div>

            <!-- Orders List -->
            <div class="max-w-screen-xl mx-auto px-4">
                <div v-if="orders.data.length > 0" class="space-y-3">
                    <div
                        v-for="order in orders.data"
                        :key="order.id"
                        class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow"
                    >
                        <!-- Order Header -->
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-mono text-gray-500">{{ order.public_code }}</span>
                            <span
                                class="text-xs font-semibold px-2.5 py-1 rounded-full border"
                                :class="statusColor(order.status)"
                            >
                                {{ order.status_label }}
                            </span>
                        </div>

                        <!-- Order Details -->
                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between">
                                <span class="font-semibold text-sm text-gray-800">{{ order.package_name }}</span>
                                <span class="font-bold text-sm text-gray-900">R$ {{ order.amount }}</span>
                            </div>

                            <div v-if="order.instagram_username" class="flex items-center gap-1.5 text-xs text-gray-500">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069z"/>
                                </svg>
                                <span>@{{ order.instagram_username }}</span>
                            </div>

                            <div class="flex items-center justify-between text-xs text-gray-400 pt-1">
                                <span>{{ order.created_at }}</span>
                                <span>{{ order.created_at_human }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-else class="text-center py-16">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-gray-500 font-medium">Nenhum pedido encontrado</p>
                    <p class="text-sm text-gray-400 mt-1">Seus pedidos aparecerão aqui</p>
                </div>

                <!-- Pagination -->
                <div v-if="orders.last_page > 1" class="flex justify-center gap-2 mt-6 pb-4">
                    <button
                        v-for="page in orders.last_page"
                        :key="page"
                        @click="goToPage(page)"
                        class="w-10 h-10 rounded-lg text-sm font-medium transition-colors"
                        :class="page === orders.current_page
                            ? 'bg-purple-600 text-white'
                            : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                    >
                        {{ page }}
                    </button>
                </div>
            </div>
        </div>

        <BottomNav active-page="orders" />
    </AuthenticatedLayout>
</template>
