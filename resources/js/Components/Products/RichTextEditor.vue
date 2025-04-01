<script setup>
import { watch, defineProps, defineEmits } from 'vue'
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Paragraph from '@tiptap/extension-paragraph'
import Text from '@tiptap/extension-text'
import Bold from '@tiptap/extension-bold'
import HardBreak from '@tiptap/extension-hard-break'

const props = defineProps({
    modelValue: {
        type: String,
        default: '',
    },
})

const emit = defineEmits(['update:modelValue'])

const sanitizeHTML = (html) => {
    return html
        .replace(/<\/?(?!p|br|b|strong)\w+.*?>/g, '') // Remove tags não permitidas
        .replace(/&lt;.*?&gt;/g, '') // Remove conteúdo HTML escapado
        .replace(/<p>\s*<\/p>/g, ''); // Remove parágrafos vazios desnecessários
};


const editor = useEditor({
    content: props.modelValue,
    extensions: [
        StarterKit.configure({
            heading: false,
            blockquote: false,
            codeBlock: false,
            bulletList: false,
            orderedList: false,
            listItem: false,
            italic: false,
            strike: false,
            code: false,
        }),
        Paragraph,
        Text,
        Bold,
        HardBreak,
    ],
    editorProps: {
        attributes: {
            class: 'prose focus:outline-none min-h-[150px] p-4',
        },
        handlePaste: (view, event) => {
            event.preventDefault();

            const clipboardData = event.clipboardData || window.clipboardData;
            let pastedHTML = clipboardData.getData('text/html') || clipboardData.getData('text/plain');

            if (pastedHTML) {
                // Limpa o HTML antes de inserir
                let sanitizedHtml = sanitizeHTML(pastedHTML);

                // Converte para um nó do ProseMirror e insere no editor
                const { state, dispatch } = view;
                const slice = state.schema.nodes.paragraph.create({}, state.schema.text(sanitizedHtml));

                dispatch(state.tr.replaceSelectionWith(slice));
            }
        }
    },
    onUpdate: () => {
        let html = editor.value.getHTML();
        let sanitizedHtml = sanitizeHTML(html);
        emit('update:modelValue', sanitizedHtml);
    },
})

// Sincroniza o conteúdo externo com o editor
watch(() => props.modelValue, (newValue) => {
    const isSame = editor.value.getHTML() === newValue;
    if (isSame) return;
    editor.value.commands.setContent(newValue, false);
});
</script>

<template>
    <div class="rich-text-editor border border-gray-200 rounded-lg bg-white shadow-sm overflow-hidden">
        <div v-if="editor" class="flex items-center gap-1 p-2 border-b bg-gray-50">
            <button
                type="button"
                @click="editor.chain().focus().setParagraph().run()"
                :class="{ 'bg-blue-50 text-blue-600': editor.isActive('paragraph') }"
                class="p-2 rounded hover:bg-gray-100 transition-colors"
                title="Parágrafo"
            >
                <span class="text-sm font-medium">P</span>
            </button>

            <button
                type="button"
                @click="editor.chain().focus().toggleBold().run()"
                :class="{ 'bg-blue-50 text-blue-600': editor.isActive('bold') }"
                class="p-2 rounded hover:bg-gray-100 transition-colors"
                title="Negrito"
            >
                <span class="text-sm font-bold">B</span>
            </button>

            <button
                type="button"
                @click="editor.chain().focus().setHardBreak().run()"
                class="p-2 rounded hover:bg-gray-100 transition-colors"
                title="Quebra de linha"
            >
                <span class="text-sm font-medium">BR</span>
            </button>
        </div>

        <editor-content :editor="editor" class="p-4 min-h-[150px]"/>

        <div class="border-t p-3 bg-gray-50 text-xs text-gray-500">
            <p>Tags permitidas: &lt;p&gt;, &lt;br&gt;, &lt;b&gt;, &lt;strong&gt;</p>
        </div>
    </div>
</template>

<style>
.rich-text-editor {
    font-family: 'Inter', sans-serif;
}

.ProseMirror {
    min-height: 150px;
    line-height: 1.5;
}

.ProseMirror:focus {
    outline: none;
}

.ProseMirror p {
    margin-bottom: 1rem;
}

.ProseMirror strong {
    font-weight: 600;
}
</style>
