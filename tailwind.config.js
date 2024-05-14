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
        },
        colors: {
            'darkBlue': 'rgb(10,56,87)',
            'projetosDesenvolvimentoBanner' : 'rgb(10,56,87)',
            'projetosPendentesBanner' : 'rgb(249,109,35)',
            'projetosOutrosColabBanner' : 'rgb(100,24,133)',
            'greenStatus' : 'rgb(122,166,77)',
            'blueStatus' : 'rgb(10,57,86)',
            'redStatus' : 'rgb(231,81,91)'
        }
    },

    plugins: [forms],
};
