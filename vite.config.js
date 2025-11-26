import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js', 
                'resources/css/landing-styles.css',
                'resources/css/crypto-icons/styles.css',
                'resources/css/crypto-icons/font.css'
            ],
            refresh: true,
        }),
    ],
});
