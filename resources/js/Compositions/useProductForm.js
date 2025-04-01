import { computed } from 'vue';

export function useProductForm(form) {
    const isPriceValid = computed(() => {
        if (!form.price || !form.cost) return true;
        const minPrice = Number(form.cost) * 1.1;
        return Number(form.price) >= minPrice;
    });

    const priceError = computed(() => {
        if (isPriceValid.value) return null;
        const minPrice = (form.cost * 1.1).toFixed(2);
        return `O preço deve ser pelo menos 10% maior que o custo (mínimo: R$ ${minPrice})`;
    });

    const validateImages = (files) => {
        const allowedTypes = ['image/jpeg', 'image/png'];
        return Array.from(files).filter(file => allowedTypes.includes(file.type));
    };

    return {
        isPriceValid,
        priceError,
        validateImages
    };
}
