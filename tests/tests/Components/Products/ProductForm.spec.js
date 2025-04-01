import { mount } from '@vue/test-utils';
import ProductForm from '@/Components/Products/ProductForm.vue';
import ProductInput from '@/Components/Products/ProductInput.vue';
import RichTextEditor from '@/Components/Products/RichTextEditor.vue';
import ProductImages from '@/Components/Products/ProductImages.vue';

describe('ProductForm.vue', () => {
    it('renders all form fields', () => {
        const wrapper = mount(ProductForm, {
            props: {
                form: {
                    title: '',
                    description: '',
                    price: '',
                    cost: '',
                    images: []
                },
                submitText: 'Salvar'
            }
        });

        expect(wrapper.findComponent(ProductInput).exists()).toBe(true);
        expect(wrapper.findComponent(RichTextEditor).exists()).toBe(true);
        expect(wrapper.findComponent(ProductImages).exists()).toBe(true);
        expect(wrapper.find('input[type="file"]').exists()).toBe(true);
        expect(wrapper.find('button[type="submit"]').text()).toBe('Salvar');
    });

    it('emits submit event when form is submitted', async () => {
        const wrapper = mount(ProductForm, {
            props: {
                form: {
                    title: 'Test Product',
                    description: '<p>Test</p>',
                    price: '100',
                    cost: '50',
                    images: []
                },
                submitText: 'Salvar'
            }
        });

        await wrapper.find('form').trigger('submit.prevent');
        expect(wrapper.emitted()).toHaveProperty('submit');
    });

    // Mais testes podem ser adicionados aqui
});
