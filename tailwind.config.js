import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    safelist: ['halpha-w-sidebar-expanded'],
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    prefix: 'halpha-',

    theme: {
        extend: {
            colors: {
                'bg': 'var(--halpha-bg)',
                'surface': 'var(--halpha-surface)',
                'muted': 'var(--halpha-muted)',
                'accent': 'var(--halpha-accent)',
                'accent-2': 'var(--halpha-accent-2)',
                'success': 'var(--halpha-success)',
                'danger': 'var(--halpha-danger)'
            },
            spacing: {
                'sidebar-collapsed': '5rem', // 80px
                'sidebar-expanded': '14rem'
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
