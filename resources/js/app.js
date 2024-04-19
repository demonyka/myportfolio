import './bootstrap';
import '../css/app.css';
import '../css/fonts.css';

import { createApp, h } from 'vue';
import { createI18n } from 'vue-i18n';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import enMessages from '../lang/en.json';
import ruMessages from '../lang/ru.json';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const messages = {
    en: enMessages,
    ru: ruMessages,
};

let defaultLocale = 'en';
const userLanguage = navigator.language || navigator.userLanguage;
if (userLanguage.startsWith('ru')) {
    defaultLocale = 'ru';
}

const i18n = createI18n({
    locale: localStorage.getItem('lang') || defaultLocale,
    fallbackLocale: localStorage.getItem('lang') || defaultLocale,
    messages,
});

createInertiaApp({
    title: (title) => `${appName} | ${title}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(i18n)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
