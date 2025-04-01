<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Link, useForm} from '@inertiajs/vue3';
import {ref} from 'vue';

const props = defineProps({
    products: Array,
    user: Object,
});

const form = useForm({});
const showDeleteConfirm = ref(null);

const destroyProduct = (productId) => {
    showDeleteConfirm.value = productId;
};

const confirmDestroy = (productId) => {
    form.delete(route('products.destroy', productId), {
        preserveScroll: true,
        onSuccess: () => {
            showDeleteConfirm.value = null;
        }
    });
};

const cancelDestroy = () => {
    showDeleteConfirm.value = null;
};
</script>

<template>
    <AuthenticatedLayout :user="user">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Produtos</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-medium">Lista de Produtos</h3>
                            <Link
                                :href="route('products.create')"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-200 transition ease-in-out duration-150"
                            >
                                Cadastrar Produto
                            </Link>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Título
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Preço
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Custo
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ações
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="product in products" :key="product.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ product.title }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        R$ {{ Number(product.price).toFixed(2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        R$ {{ Number(product.cost).toFixed(2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <Link
                                            :href="route('products.edit', product.id)"
                                            class="text-blue-600 hover:text-blue-900 mr-3"
                                        >
                                            Editar
                                        </Link>

                                        <template v-if="showDeleteConfirm === product.id">
                                            <span class="text-sm text-gray-500 mr-2">Confirmar?</span>
                                            <button
                                                @click="confirmDestroy(product.id)"
                                                class="text-red-600 hover:text-red-900 mr-2"
                                                :disabled="form.processing"
                                            >
                                                Sim
                                            </button>
                                            <button
                                                @click="cancelDestroy()"
                                                class="text-gray-600 hover:text-gray-900"
                                            >
                                                Não
                                            </button>
                                        </template>
                                        <button
                                            v-else
                                            @click="destroyProduct(product.id)"
                                            class="text-red-600 hover:text-red-900"
                                        >
                                            Deletar
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="products.length === 0">
                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Nenhum produto cadastrado
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
