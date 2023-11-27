import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue2 from '@vitejs/plugin-vue2';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/mave-fieldtype.js',
                'resources/css/mave-fieldtype.css',
            ],
            hotFile: 'dist/vite.hot',
            publicDirectory: 'dist',
        }),
        vue2({
            template: {
                compilerOptions: {
                    // treat all tags with a dash as custom elements
                    isCustomElement: (tag) => tag.includes('-')
                }
            }
        }),
    ],
});