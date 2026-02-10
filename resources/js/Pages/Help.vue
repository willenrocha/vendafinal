<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BottomNav from '@/Components/BottomNav.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const openFaq = ref<number | null>(null);

const toggleFaq = (index: number) => {
    openFaq.value = openFaq.value === index ? null : index;
};

const faqs = [
    {
        question: 'Como funciona o serviço?',
        answer: 'Nosso serviço impulsiona seu perfil no Instagram de forma segura e gradual. Após a confirmação do pagamento via PIX, seu pedido é processado automaticamente e os resultados começam a aparecer em poucas horas.',
    },
    {
        question: 'Qual o prazo de entrega?',
        answer: 'O prazo varia de acordo com o pacote escolhido. Em geral, os primeiros resultados aparecem em até 1 hora após a confirmação do pagamento, e a entrega completa pode levar de 24 a 72 horas.',
    },
    {
        question: 'O que são créditos e como usar?',
        answer: 'Créditos são bônus que você recebe ao comprar pacotes. Eles podem ser usados para aplicar curtidas, visualizações ou comentários em posts específicos do seu perfil. Basta acessar o Dashboard, clicar em um post e escolher o tipo e quantidade de créditos.',
    },
    {
        question: 'É seguro para minha conta?',
        answer: 'Sim! Utilizamos métodos seguros e graduais que respeitam as políticas das plataformas. Seu perfil não corre risco de penalização.',
    },
    {
        question: 'Como faço para acompanhar meus pedidos?',
        answer: 'Acesse a página "Meus Pedidos" pela barra de navegação inferior. Lá você verá o status de todos os seus pedidos, incluindo código de acompanhamento, pacote, valor e data.',
    },
    {
        question: 'Posso comprar para mais de um perfil?',
        answer: 'Sim! No checkout, você pode informar qualquer perfil público do Instagram. Se você já tem mais de um perfil vinculado, pode alternar entre eles no Dashboard.',
    },
    {
        question: 'Como entro em contato com o suporte?',
        answer: 'Você pode entrar em contato conosco pelo email suporte@followturbo.com ou pelo WhatsApp disponível no site. Respondemos em até 24 horas úteis.',
    },
];
</script>

<template>
    <Head title="Ajuda" />

    <AuthenticatedLayout>
        <div class="pb-24 bg-white min-h-screen">
            <!-- Header -->
            <div class="bg-white border-b border-gray-200">
                <div class="max-w-screen-xl mx-auto px-4 py-4">
                    <h1 class="text-xl font-bold text-gray-900">Central de Ajuda</h1>
                    <p class="text-sm text-gray-500 mt-1">Perguntas frequentes sobre nossos serviços</p>
                </div>
            </div>

            <!-- FAQ List -->
            <div class="max-w-screen-xl mx-auto px-4 py-4">
                <div class="space-y-3">
                    <div
                        v-for="(faq, index) in faqs"
                        :key="index"
                        class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm"
                    >
                        <button
                            @click="toggleFaq(index)"
                            class="w-full flex items-center justify-between p-4 text-left hover:bg-gray-50 transition-colors"
                        >
                            <span class="font-semibold text-sm text-gray-800 pr-4">{{ faq.question }}</span>
                            <svg
                                class="w-5 h-5 text-gray-400 flex-shrink-0 transition-transform"
                                :class="{ 'rotate-180': openFaq === index }"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div
                            v-if="openFaq === index"
                            class="px-4 pb-4 text-sm text-gray-600 leading-relaxed border-t border-gray-100 pt-3"
                        >
                            {{ faq.answer }}
                        </div>
                    </div>
                </div>

                <!-- Support Section -->
                <div class="mt-8 bg-gradient-to-r from-purple-50 to-blue-50 rounded-xl p-5 border border-purple-100 text-center">
                    <h3 class="font-bold text-gray-800 mb-2">Ainda tem dúvidas?</h3>
                    <p class="text-sm text-gray-600 mb-4">Nossa equipe está pronta para ajudar!</p>
                    <a
                        href="mailto:suporte@followturbo.com"
                        class="inline-block bg-purple-600 text-white font-semibold py-2.5 px-6 rounded-xl text-sm hover:bg-purple-700 transition-colors"
                    >
                        Falar com Suporte
                    </a>
                </div>
            </div>
        </div>

        <BottomNav active-page="help" />
    </AuthenticatedLayout>
</template>
