import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                mono: ['ui-monospace', 'SFMono-Regular', 'Menlo', 'Monaco', 'Consolas', '"Liberation Mono"', '"Courier New"', 'monospace'],
            },
            boxShadow: {
                glow: "0 0 0 1px rgba(34,211,238,.25), 0 0 30px rgba(34,211,238,.10)",
                glowGreen: "0 0 0 1px rgba(34,197,94,.25), 0 0 30px rgba(34,197,94,.10)",
            },
            keyframes: {
                glitch: {
                    "0%, 100%": { transform: "translate(0)" },
                    "10%": { transform: "translate(-1px, 0)" },
                    "20%": { transform: "translate(1px, 0)" },
                    "30%": { transform: "translate(-2px, 0)" },
                    "40%": { transform: "translate(2px, 0)" },
                    "50%": { transform: "translate(-1px, 0)" },
                    "60%": { transform: "translate(1px, 0)" },
                    "70%": { transform: "translate(-1px, 0)" },
                    "80%": { transform: "translate(1px, 0)" },
                    "90%": { transform: "translate(-1px, 0)" },
                },
                scan: {
                    "0%": { transform: "translateY(-20%)" },
                    "100%": { transform: "translateY(120%)" },
                },
                blink: {
                    "0%, 49%": { opacity: "1" },
                    "50%, 100%": { opacity: "0" },
                },
            },
            animation: {
                glitch: "glitch 900ms steps(2, end) infinite",
                scan: "scan 6s linear infinite",
                blink: "blink 1s step-end infinite",
            },
        },
    },

    plugins: [forms],
};
