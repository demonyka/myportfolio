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

const i18n = createI18n({
    locale: localStorage.getItem('lang') || 'ru',
    fallbackLocale: localStorage.getItem('lang') || 'ru',
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
