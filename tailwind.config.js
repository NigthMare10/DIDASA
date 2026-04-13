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
                sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            },
            colors: {
                didasa: {
                    rojo: '#d90416',
                    rojoOscuro: '#af0312',
                    tinta: '#141b26',
                    fondo: '#f5f6f8',
                    borde: '#d9dee7',
                    textoSuave: '#5e6878',
                },
            },
            boxShadow: {
                tarjeta: '0 10px 30px rgba(20, 27, 38, 0.08)',
            },
            borderRadius: {
                portal: '1.5rem',
            },
        },
    },

    plugins: [forms],
};
