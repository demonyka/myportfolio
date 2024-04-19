<template>
    <Head :title='$t("sign_in")' />
    <Layout>
        <div class="login" @submit.prevent="formSubmit">
            <div class="login-content">
                <h3>{{ $t('sign_in') }}</h3>
                <form class="login-form">
                    <input
                        :placeholder="$t('email')"
                        name="email"
                        type="email"
                        :class="{ 'error': form.errors.email }"
                        @focus="form.errors = {}"
                        v-model="form.email"
                    >
                    <input
                        :placeholder="$t('password')"
                        name="password"
                        type="password"
                        :class="{ 'error': form.errors.password }"
                        @focus="form.errors = {}"
                        v-model="form.password"
                    >
                    <button class="primary" :disabled="form.processing" type="submit">{{ $t('sign_in_button') }}</button>
                    <transition name="fade">
                        <p v-if="form.errors.email" class="error-message">{{ $t(form.errors.email) }}</p>
                        <p v-else-if="form.errors.password" class="error-message">{{ $t(form.errors.password) }}</p>
                    </transition>
                </form>
                <div class="social-login">
                    <Link :href="route('auth.google.redirect')" class="google"/>
                    <Link :href="route('auth.github.redirect')" class="github"/>
                </div>
            </div>
        </div>
        <div class="login-links">
            <Link :href="route('auth.register.view')">{{ $t('not_registered') }}</Link>
            <a>{{ $t('forgot_password') }}</a>
        </div>
    </Layout>
</template>

<style scoped>
.login {
    background-color: white;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    border-radius: 20px;
    width: 30%;
}
.login-content {
    padding: 20px 30px;
    display: flex;
    align-items: center;
    flex-direction: column;
    gap: 10px;
}
.login-content h3 {
    font-weight: 500;
    margin: 0 0 10px 0;
}
form.login-form {
    width: 80%;
    display: flex;
    align-items: center;
    flex-direction: column;
    gap: 10px;
}
form.login-form input {
    border: 1px solid var(--gray4);
    border-radius: 20px;
    padding: 10px 20px;
    outline: none;
    width: 100%;
}
form.login-form input:focus {
    border: 1px solid var(--blue1);
}
.login-links {
    margin-top: 20px;
    display: flex;
    align-items: center;
    flex-direction: column;
    gap: 10px;
}
p.error-message {
    color: var(--red);
    margin: 0;
    text-align: center;
}
form.login-form input.error {
    border-color: var(--red);
}
@media screen and (max-width: 1200px) {
    .login {
        width: 100%;
    }
    button {
        font-size: 14px;
    }
}
.social-login {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
    margin-top: 10px;
}
.social-login a {
    background-size: cover;
    background-repeat: no-repeat;
    width: 36px;
    height: 36px;
}
.social-login a.google {
    background-image: url("/icons/social/google.svg");
}
.social-login a.github {
    background-image: url("/icons/social/github.svg");
}
</style>

<script>
import { Head, Link, useForm } from "@inertiajs/vue3";
import Layout from "@/Layouts/Layout.vue";

export default {
    name: "Login",
    components: {
        Layout,
        Head,
        Link
    },
    data() {
        return {
            form: useForm({
                _token: this.$page.props.csrf_token,
                email: '',
                password: ''
            }),
        }
    },
    methods: {
        formSubmit() {
            this.form.post(route('auth.login.store'), {
                onFinish: () => this.form.reset('password'),
            });
        },
    }
}
</script>
