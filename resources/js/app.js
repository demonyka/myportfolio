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
    datetimeFormats: {
        en: {
            long: {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            }
        },
        ru: {
            long: {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            }
        }
    },
    pluralizationRules: {
        'ru': function(choice, choicesLength) {
            if (choice === 0) {
                return 0;
            }

            const teen = choice > 10 && choice < 20;
            const endsWithOne = choice % 10 === 1;

            if (choicesLength < 4) {
                return (!teen && endsWithOne) ? 1 : 2;
            }
            if (!teen && endsWithOne) {
                return 1;
            }
            if (!teen && choice % 10 >= 2 && choice % 10 <= 4) {
                return 2;
            }

            return (choicesLength < 4) ? 2 : 3;
        }
    }
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
