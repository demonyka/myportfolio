import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { VitePWA } from 'vite-plugin-pwa'

export default defineConfig({
    plugins: [
        VitePWA({
            registerType: 'autoUpdate',
            injectRegister: 'script',
            manifestFilename: '../manifest.webmanifest', // this ugly workaround to get in public root
            outDir: 'public',
            base: 'public',
            scope: '/',
            buildBase: '/',
            workbox: {
                navigateFallback: '/',
            },
            manifest: {
                name: 'App',
                short_name: 'App',
                description: 'App',
                theme_color: '#39336c',
                background_color: '#ffffff',
                orientation: 'portrait-primary',
                id: '/',
                scope: '/',
                start_url: '/',
                screenshots: [
                    {
                        "src": "/assets/screenshots/screenshot.png",
                        "sizes": "1895x911",
                        "type": "image/png",
                        "form_factor": "wide",
                        "label": "MyPortfolio"
                    },
                    {
                        "src": "/assets/screenshots/screenshot_mobile.png",
                        "sizes": "371x665",
                        "type": "image/png",
                        "label": "MyPortfolio"
                    }
                ],
                icons: [
                    {
                        src: '/assets/icons/small_logo_144.svg',
                        sizes: '144x144',
                        type: 'image/svg',
                        purpose: "any"
                    },
                    {
                        src: '/assets/icons/small_logo_192.svg',
                        sizes: '192x192',
                        type: 'image/svg',
                    },
                    {
                        src: '/assets/icons/small_logo_512.svg',
                        sizes: '512x512',
                        type: 'image/svg',
                    },
                ]
            },
        }),
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
