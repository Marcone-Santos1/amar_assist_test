<script setup>
defineProps({
    modelValue: [String, Number],
    label: {
        type: String,
        required: true
    },
    type: {
        type: String,
        default: 'text'
    },
    required: {
        type: Boolean,
        default: false
    },
    step: {
        type: String,
        default: null
    },
    min: {
        type: Number,
        default: null
    }
});

defineEmits(['update:modelValue']);
</script>

<template>
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">
            {{ label }}
            <span v-if="required" class="text-red-500">*</span>
        </label>
        <input
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            :type="type"
            :required="required"
            :step="step"
            :min="min"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
        >
    </div>
</template>
