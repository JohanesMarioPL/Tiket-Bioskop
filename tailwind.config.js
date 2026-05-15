import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                sky: {
                    cream:  '#FAF3E0',   // page background
                    blue:   '#CBDFEA',   // card background
                    gray:   '#C8C2BC',   // muted / borders
                    slate:  '#708090',   // secondary text
                    brown:  '#4B3935',   // headings / dark accents
                },
            },
        },
    },

    plugins: [forms],
};
