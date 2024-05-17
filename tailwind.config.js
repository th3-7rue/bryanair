import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'selector',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/views/components/*.blade.php',
    ],

    theme: {
        extend: {
            screens: {
                'tall': { raw: '(min-height: 724px)' },
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'midnight-blue': '#011C40',
                'royal-blue': '#08428C',
                'petrol-blue': '#023E73',
                'amber': '#F2BB16',
                'cloud-white': '#F2F2F2',
                primary: '#011C40',
                secondary: '#F2BB16',
            },
        },
    },

    plugins: [forms, typography],
};
