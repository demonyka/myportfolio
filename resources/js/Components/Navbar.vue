<template>
    <div class="navbar">
        <div class="nav-content">
            <div class="logo"/>
            <div class="logo small"/>
            <div class="right-side">
                <a class="btn-secondary">
                    <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="13" cy="13" r="13" fill="#D9D9D9"/>
                        <path d="M7.75 19.75C7.75 16.8505 10.1005 14.5 13 14.5C15.8995 14.5 18.25 16.8505 18.25 19.75M16 9.25C16 10.9069 14.6568 12.25 13 12.25C11.3431 12.25 10 10.9069 10 9.25C10 7.59314 11.3431 6.25 13 6.25C14.6568 6.25 16 7.59314 16 9.25Z" stroke="#828282" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    {{ $t('sign_in') }}
                </a>

                <a @click="isLanguageSwitcherOpen = !isLanguageSwitcherOpen" class="btn-secondary desktop-lang-switcher">
                    <img alt="lang" :src="`/icons/lang/${this.$i18n.locale}.svg`">
                    {{ $t('lang') }}
                </a>

                <a @click="this.$i18n.locale === 'ru' ? switchLanguage('en') : switchLanguage('ru')" class="btn-secondary mobile-lang-switcher">
                    <img :class="{'right': $i18n.locale === 'en', 'left': $i18n.locale !== 'en'}" alt="lang" :src="`/icons/lang/${this.$i18n.locale}.svg`">
                </a>
            </div>
            <transition name="fade">
                <div v-if="isLanguageSwitcherOpen" class="language-switcher">
                    <a @click="switchLanguage('ru')" class="lang">
                        <img alt="ru" :src="`/icons/lang/ru.svg`">
                        Русский
                    </a>
                    <a @click="switchLanguage('en')" class="lang">
                        <img alt="en" :src="`/icons/lang/en.svg`">
                        English
                    </a>
                </div>
            </transition>
        </div>
    </div>
    <img alt="ru" :src="`/icons/lang/ru.svg`" style="display: none;">
    <img alt="en" :src="`/icons/lang/en.svg`" style="display: none;">
</template>

<style scoped>
.navbar {
    border-radius: 20px;
    width: 100%;
    position: relative;
    background-color: var(--white);
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    z-index: 100;
}
.nav-content {
    padding: 15px 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.logo.small {
    display: none;
}
.right-side {
    display: flex;
    align-items: center;
    gap: 10px;
}
.btn-secondary {
    border: 1px solid var(--gray4);
    border-radius: 40px;
    padding: 10px 15px;
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    color: black;
}
.language-switcher {
    background-color: white;
    position: absolute;
    padding: 10px 20px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    border-radius: 20px;
    transform: translateY(calc(100% + 5px));
    display: flex;
    flex-direction: column;
    gap: 15px;
    right: 0;
}
.language-switcher .lang {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    text-align: center;
    color: black;
}
.mobile-lang-switcher {
    display: none;
    width: 45px;
}
.mobile-lang-switcher img.right {
    transform: translateX(28px);
}
@media screen and (max-width: 1000px) {
    .logo {
        display: none;
    }
    .logo.small {
        display: block;
    }
    .btn-secondary {
        font-size: 14px;
        padding: 10px;
    }
    .btn-secondary img, .btn-secondary svg {
        width: 18px;
        height: 18px;
    }
    .nav-content {
        padding: 15px 20px;
    }
    .navbar {
        border-radius: 0;
        position: fixed;
        width: 100%;
    }
    .desktop-lang-switcher {
        display: none;
    }
    .mobile-lang-switcher {
        display: flex;
    }
}
</style>

<script>
import { Link } from '@inertiajs/vue3';
export default {
    name: "Navbar",
    components: {
        Link,
    },
    data() {
        return {
            isLanguageSwitcherOpen: false,
        };
    },
    methods: {
        switchLanguage(locale) {
            localStorage.setItem('lang', locale);
            this.$i18n.locale = locale;
            this.isLanguageSwitcherOpen = false;
        },
        handleEventLanguageSwitcher(event) {
            if (event.key === 'Escape') {
                this.isLanguageSwitcherOpen = false;
            }
        },
    },
    mounted() {
        document.addEventListener('keydown', this.handleEventLanguageSwitcher);
    },
    beforeUnmount() {
        document.removeEventListener('keydown', this.handleEventLanguageSwitcher);
    }
}
</script>
