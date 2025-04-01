<script setup>
import { ref, computed } from 'vue';
import ProductInput from '@/Components/Products/ProductInput.vue';
import RichTextEditor from '@/Components/Products/RichTextEditor.vue';
import ProductImages from '@/Components/Products/ProductImages.vue';
import { useProductForm } from '@/Compositions/useProductForm';

const props = defineProps({
    form: {
        type: Object,
        required: true
    },
    isEditing: {
        type: Boolean,
        required: false,
        default: true
    },
    existingImages: {
        type: Array,
        default: () => []
    },
    submitText: {
        type: String,
        default: 'Salvar'
    },
    processing: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['submit', 'file-change', 'image-deleted']);

const { isPriceValid, priceError, validateImages } = useProductForm(props.form);

const fileInput = ref(null);

const handleFiles = (event) => {
    const validFiles = validateImages(event.target.files);

    if (validFiles.length !== event.target.files.length) {
        alert('Apenas arquivos JPG e PNG são permitidos');
        fileInput.value.value = '';
        return;
    }

    emit('file-change', validFiles);
};

const handleImageDeleted = ({imageId, index}) => {
    emit('image-deleted', {imageId, index});
};

const handleSubmit = () => {
    if (!isPriceValid.value) {
        alert(priceError.value);
        return;
    }
    emit('submit');
};
</script>

<template>
    <form @submit.prevent="handleSubmit" class="space-y-6">
        <ProductInput
            v-model="form.title"
            label="Título"
            type="text"
            required
        />

        <RichTextEditor
            v-model="form.description"
        />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <ProductInput
                v-model="form.cost"
                label="Custo (R$)"
                type="number"
                step="0.01"
                min="0"
                required
            />

            <ProductInput
                v-model="form.price"
                label="Preço de Venda (R$)"
                type="number"
                step="0.01"
                :min="form.cost ? form.cost * 1.1 : 0"
                required
            />
        </div>

        <div v-if="priceError" class="text-sm text-red-600">
            {{ priceError }}
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Imagens:</label>
            <input
                ref="fileInput"
                type="file"
                multiple
                accept="image/jpeg, image/png"
                @change="handleFiles"
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                :disabled="processing"
            >
            <p class="mt-1 text-xs text-gray-500">
                Formatos suportados: JPG, PNG (Máx. 5MB cada)
            </p>

            <ProductImages
                v-show="isEditing"
                :existing-images="existingImages"
                @image-deleted="handleImageDeleted"
                class="mt-4"
            />
        </div>

        <div class="flex justify-end">
            <button
                type="submit"
                :disabled="processing"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
            >
                <span v-if="processing" class="inline-block mr-2 animate-spin">↻</span>
                {{ submitText }}
            </button>
        </div>
    </form>
</template>
