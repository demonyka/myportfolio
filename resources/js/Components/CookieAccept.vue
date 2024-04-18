<template>
    <div v-if="!isCookieAccept" class="cookie-bg">
        <div class="cookie-accept">
            <Logo/>
            <h2 style="margin-bottom: 5px">{{ $t('we_use_cookies') }}</h2>
            <p>{{ $t('cookies_terms') }}</p>
            <button @click="cookieAccept" style="width: 50%; margin-top: 10px" class="primary">{{ $t('ok') }}</button>
        </div>
    </div>
</template>

<style scoped>
    .cookie-bg {
        overflow: hidden;
        position: fixed;
        width: 100vw;
        height: 100vh;
        background-color: #00000090;
        z-index: 1000;
        top: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .cookie-accept {
        display: flex;
        flex-direction: column;
        align-items: center;
        background-color: white;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        padding: 20px 80px;
        border-radius: 20px;
        max-width: 20vw;
        text-align: center;
    }
</style>

<script>
import Logo from "@/Elements/Logo.vue";
export default {
    name: "CookieAccept",
    components: {
        Logo,
    },
    data() {
        return {
            isCookieAccept: localStorage.getItem('cookie_accept'),
        };
    },
    mounted() {
        if (!this.isCookieAccept) {
            document.body.style.overflowY = 'hidden !important';
        }
    },
    methods: {
        cookieAccept() {
            this.isCookieAccept = true;
            localStorage.setItem('cookie_accept', this.isCookieAccept);
            document.body.style.overflowY = 'auto';
        }
    },
}
</script>

