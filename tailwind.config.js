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
            colors: {
                teal: { 50: '#eef7f6', 100: '#d6ece9', 200: '#aed9d3', 300: '#7cbfb6', 400: '#469b90', 500: '#2c7e74', 600: '#0f6e7a', 700: '#0b5560', 800: '#0a4249', 900: '#0a343a', 950: '#062024' },
                sand: { 50: '#fdfbf5', 100: '#f7f2e4', 200: '#efe6cc', 300: '#e3d3a5', 400: '#d3ba78', 500: '#c4a256' },
                gold: { 400: '#f0b23f', 500: '#e8a33d', 600: '#c9852a' },
                konawe: { 500: '#c1432e', 600: '#a3341f' },
                mekongga: { 500: '#3f7d52', 600: '#2f6140' },
                ink: '#132224',
            },
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
                display: ['Fredoka', ...defaultTheme.fontFamily.sans],
                body: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                pin: '0 10px 20px -8px rgba(19,34,36,0.35)',
            },
        },
    },

    plugins: [forms],
};
