/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './app/**/*.php',
    ],
    theme: {
        extend: {
            keyframes: {
                float: {
                    '0%': { transform: 'translate(0, 0) scale(1)' },
                    '50%': { transform: 'translate(28px, -20px) scale(1.06)' },
                    '100%': { transform: 'translate(-24px, 22px) scale(0.96)' },
                },
                floatReverse: {
                    '0%': { transform: 'translate(0, 0) scale(1)' },
                    '50%': { transform: 'translate(-28px, 24px) scale(1.07)' },
                    '100%': { transform: 'translate(22px, -18px) scale(0.94)' },
                },
                fadeUp: {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                pulseSoft: {
                    '0%, 100%': { opacity: '1', transform: 'scale(1)' },
                    '50%': { opacity: '0.35', transform: 'scale(1.4)' },
                },
            },
            animation: {
                'float': 'float 22s ease-in-out infinite alternate',
                'float-slow': 'float 28s ease-in-out infinite alternate',
                'float-reverse': 'floatReverse 26s ease-in-out infinite alternate',
                'fade-up': 'fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                'pulse-soft': 'pulseSoft 2.2s ease-in-out infinite',
            },
        },
    },
    plugins: [],
};
