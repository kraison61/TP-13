import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    build: {
        rollupOptions: {
            output: {
                manualChunks(id) {
                    if (id.includes('node_modules')) {
                        return 'vendor';
                    }

                    if (id.includes('/resources/js/lib/')) {
                        return 'carousel';
                    }

                    if (id.includes('/resources/js/gallery.js')) {
                        return 'gallery';
                    }

                    if (id.includes('/resources/js/contact-form.js')) {
                        return 'contact-form';
                    }

                    if (id.includes('/resources/js/testimonials.js')) {
                        return 'testimonials';
                    }

                    if (id.includes('/resources/js/finance.js')) {
                        return 'finance';
                    }

                    if (id.includes('/resources/js/soil-calc.js')) {
                        return 'soil-calc';
                    }

                    if (id.includes('/resources/js/faq.js')) {
                        return 'faq';
                    }
                },
            },
        },
    },
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
