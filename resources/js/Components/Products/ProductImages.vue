<script setup>
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
    existingImages: {
        type: Array,
        required: true,
        default: () => [],
        validator: (images) => images.every(img => img && 'id' in img && 'path' in img)
    }
});

const emit = defineEmits(['image-deleted']);

function getImageUrl(path) {
    // Verifica se o path existe e é uma string
    if (!path || typeof path !== 'string') return '';

    // Se já for uma URL completa (ex: S3)
    if (path.startsWith('http')) return path;

    // Para imagens locais
    return `/storage/${path}`;
}

function deleteImage(imageId, index) {
    if (confirm('Tem certeza que deseja excluir esta imagem?')) {
        emit('image-deleted', { imageId, index });
    }
}
</script>

<template>
    <div class="mt-6">
        <h3 class="text-lg font-medium mb-2">Imagens do Produto</h3>
        <div v-if="existingImages.length" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            <div v-for="(image, index) in existingImages" :key="image.id" class="relative group">
                <!-- Mostra a imagem existente -->
                <img :src="getImageUrl(image.path)"
                     class="w-full h-32 object-cover rounded-lg shadow"
                     :alt="`Imagem do produto ${index + 1}`"/>

                <!-- Botão para remover -->
                <button @click="deleteImage(image.id, index)"
                        class="absolute top-2 right-2 p-1 bg-red-500 text-white rounded-full shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                        aria-label="Remover imagem">
                    &times;
                </button>
            </div>
        </div>
        <div v-else class="text-gray-500">Nenhuma imagem cadastrada.</div>
    </div>
</template>
