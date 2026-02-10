<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-50">
            <!-- Simple Top Navbar -->
            <nav class="bg-white border-b border-gray-200 fixed top-0 left-0 right-0 z-40">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <!-- Logo -->
                        <Link :href="route('dashboard')" class="flex items-center">
                            <img src="/images/logo.svg" alt="FollowTurbo" class="h-8 w-auto">
                        </Link>

                        <!-- Right Side - User Menu -->
                        <div class="flex items-center space-x-4">
                            <!-- User Name (Hidden on Mobile) -->
                            <span class="hidden md:block text-sm font-medium text-gray-700">
                                {{ $page.props.auth.user.name }}
                            </span>

                            <!-- Logout Button -->
                            <Link
                                :href="route('logout')"
                                method="post"
                                as="button"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span class="hidden sm:inline">Sair</span>
                            </Link>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content with Top Padding -->
            <main class="pt-16">
                <slot />
            </main>
        </div>
    </div>
</template>
