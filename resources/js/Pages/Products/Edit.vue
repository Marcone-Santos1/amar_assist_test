<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProductForm from '@/Components/Products/ProductForm.vue';
import { useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const props = defineProps({
    user: Object,
    product: {
        type: Object,
        required: true
    },
});

const existingImages = ref(props.product.images);
const form = useForm({
    title: props.product.title,
    description: props.product.description,
    price: props.product.price,
    cost: props.product.cost,
    images: [],
    _method: 'PUT'
});

const handleFiles = (files) => {
    form.images = files;
};

const handleImageDeleted = async ({ imageId, index }) => {
    try {
        await form.delete(route('products.images.destroy', imageId));
        existingImages.value.splice(index, 1);
    } catch (error) {
        console.error('Erro ao deletar imagem:', error);
    }
};

const submit = () => {
    form.post(route('products.update', props.product.id), {
        preserveScroll: true,
        onSuccess: () => {
            if (form.images.length > 0) {
                existingImages.value = [...existingImages.value, ...form.images];
                form.images = [];
            }
        },
        onError: (errors) => console.error('Erros:', errors)
    });
};
</script>

<template>
    <AuthenticatedLayout :user="user">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Produto: {{ product.title }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div v-if="flash?.success" class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ flash.success }}
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <ProductForm
                            :form="form"
                            :existing-images="existingImages"
                            @file-change="handleFiles"
                            @image-deleted="handleImageDeleted"
                            @submit="submit"
                            submit-text="Atualizar Produto"
                            :processing="form.processing"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
