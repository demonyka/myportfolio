import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { VitePWA } from 'vite-plugin-pwa'

export default defineConfig({
    plugins: [
        VitePWA({
            registerType: 'autoUpdate',
            injectRegister: 'script',
            manifestFilename: '../build/manifest.webmanifest',
            outDir: 'public/build',
            manifest: {
                "name": "MyPortfolio",
                "short_name": "MyPortfolio",
                "start_url": "/",
                "display": "standalone",
                "background_color": "#ffffff",
                "lang": "en",
                "scope": "/",
                "description": "MyPortfolio",
                "theme_color": "#2F80ED",
                "id": "/",
                "workbox": {
                    "navigateFallback": null,
                    "navigateFallbackDenylist": [
                        {}
                    ],
                    "maximumFileSizeToCacheInBytes": 41943040,
                    "globPatterns": [
                        "**/*.{css,js,html,svg,png,ico,txt,woff2}"
                    ],
                    "cleanupOutdatedCaches": true,
                    "directoryIndex": null
                },
                "screenshots": [
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
                "icons": [
                    {
                        "src": "/assets/icons/small_logo_192.svg",
                        "sizes": "192x192",
                        "type": "image/svg"
                    },
                    {
                        "src": "/assets/icons/small_logo_512.svg",
                        "sizes": "512x512",
                        "type": "image/svg"
                    },
                    {
                        "src": "/assets/icons/small_logo_128.png",
                        "sizes": "128x128",
                        "type": "image/png"
                    },
                    {
                        "src": "/assets/icons/small_logo_144.png",
                        "sizes": "144x144",
                        "type": "image/png"
                    },
                    {
                        "src": "/assets/icons/small_logo_512.png",
                        "sizes": "1600x1600",
                        "type": "image/png"
                    }
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
