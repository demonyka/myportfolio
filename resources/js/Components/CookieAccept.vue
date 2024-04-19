<template>
    <div v-if="!isCookieAccept" class="cookie-bg">
        <div class="cookie-accept">
            <img class="img-logo" alt="logo" src="/icons/logo.svg">
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
        width: 100%;
        height: 100%;
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
        max-width: 40vw;
        text-align: center;
    }
    @media screen and (max-width: 1000px) {
        .cookie-accept {
            padding: 20px;
            max-width: 80vw;
        }

    }
</style>

<script>
export default {
    name: "CookieAccept",
    components: {

    },
    data() {
        return {
            isCookieAccept: localStorage.getItem('cookie_accept'),
        };
    },
    mounted() {
        if (!this.isCookieAccept) {
            document.querySelectorAll('*').forEach(function(element) {
                element.style.overflowY = 'hidden';
            });
        }
    },
    methods: {
        cookieAccept() {
            this.isCookieAccept = true;
            localStorage.setItem('cookie_accept', this.isCookieAccept);
            document.querySelectorAll('*').forEach(function(element) {
                element.style.overflowY = 'auto';
            });
        }
    },
}
</script>

