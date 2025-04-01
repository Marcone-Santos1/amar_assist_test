<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProductForm from '@/Components/Products/ProductForm.vue';
import {useForm} from '@inertiajs/vue3';

const props = defineProps({
    user: Object,
});

const form = useForm({
    title: '',
    description: '',
    price: '',
    cost: '',
    images: []
});

const handleFiles = (files) => {
    form.images = files;
};

const submit = () => {
    form.post(route('products.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: (errors) => console.error('Erros:', errors)
    });
};
</script>

<template>
    <AuthenticatedLayout :user="user">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Cadastrar Produto</h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <ProductForm
                            :form="form"
                            @file-change="handleFiles"
                            @submit="submit"
                            submit-text="Cadastrar Produto"
                            :processing="form.processing"
                            :is-editing="false"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
