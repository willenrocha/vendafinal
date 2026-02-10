<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

interface Props {
    activePage?: 'dashboard' | 'help' | 'shop' | 'orders' | 'profile';
}

const props = withDefaults(defineProps<Props>(), {
    activePage: 'dashboard',
});

const emit = defineEmits<{
    openShop: [];
}>();
</script>

<template>
    <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg z-50">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="flex items-center justify-around relative h-20">
                <!-- Home / Dashboard -->
                <Link :href="route('dashboard')" class="flex flex-col items-center justify-center flex-1 group">
                    <svg class="w-7 h-7 group-hover:scale-110 transition-transform" :class="activePage === 'dashboard' ? 'text-primary' : 'text-gray-600 group-hover:text-gray-900'" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13zm7 7v-5h4v5h-4zm2-15.586 6 6V15l.001 5H16v-5c0-1.103-.897-2-2-2h-4c-1.103 0-2 .897-2 2v5H6v-9.586l6-6z"/>
                    </svg>
                </Link>

                <!-- Help -->
                <Link :href="route('help')" class="flex flex-col items-center justify-center flex-1 group">
                    <svg class="w-7 h-7 group-hover:scale-110 transition-all" :class="activePage === 'help' ? 'text-primary' : 'text-gray-600 group-hover:text-gray-900'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </Link>

                <!-- Shop (center button) -->
                <div class="flex flex-col items-center justify-center flex-1 -mt-10">
                    <button @click="emit('openShop')" class="cart-pulse bg-green-500 hover:bg-green-600 rounded-full p-4 shadow-2xl transition-all hover:scale-110 active:scale-95">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </button>
                </div>

                <!-- Orders -->
                <Link :href="route('orders')" class="flex flex-col items-center justify-center flex-1 group">
                    <svg class="w-7 h-7 group-hover:scale-110 transition-all" :class="activePage === 'orders' ? 'text-primary' : 'text-gray-600 group-hover:text-gray-900'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </Link>

                <!-- Profile / Settings -->
                <Link :href="route('profile.edit')" class="flex flex-col items-center justify-center flex-1 group">
                    <svg class="w-7 h-7 group-hover:scale-110 transition-all" :class="activePage === 'profile' ? 'text-primary' : 'text-gray-600 group-hover:text-gray-900'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </Link>
            </div>
        </div>
    </nav>
</template>

<style scoped>
@keyframes pulse-scale {
  0%, 100% { transform: scale(1); }
  50% { transform: scale(1.1); }
}

@keyframes pulse-ring {
  0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
  50% { box-shadow: 0 0 0 20px rgba(34, 197, 94, 0); }
  100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
}

.cart-pulse {
  animation: pulse-scale 2s ease-in-out infinite, pulse-ring 2s ease-in-out infinite;
}

.text-primary {
  color: #6108EF;
}
</style>
