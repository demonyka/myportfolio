<template>
    <Head :title='$t("sign_up")' />
    <Layout>
        <div class="login" @submit.prevent="formSubmit">
            <div class="login-content">
                <h3>{{ $t('sign_up') }}</h3>
                <form class="login-form">
                    <div style="display: flex; flex-direction: column; align-items: center; width: 100%; gap: 5px">
                        <input
                            :placeholder="$t('profile.fullname')"
                            name="fullname"
                            type="text"
                            :class="{ 'error': form.errors.fullname }"
                            @focus="form.errors.fullname = null"
                            v-model="form.fullname"
                            minlength=""
                        >
                        <transition name="fade">
                            <p v-if="form.errors.fullname" class="error-message">{{ $t(form.errors.fullname) }}</p>
                        </transition>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: center; width: 100%; gap: 5px">
                        <input
                            :placeholder="$t('profile.email')"
                            name="email"
                            type="email"
                            :class="{ 'error': form.errors.email }"
                            @focus="form.errors.email = null"
                            v-model="form.email"
                        >
                        <transition name="fade">
                            <p v-if="form.errors.email" class="error-message">{{ $t(form.errors.email) }}</p>
                        </transition>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: center; width: 100%; gap: 5px">
                        <input
                            :placeholder="$t('password')"
                            name="password"
                            type="password"
                            :class="{ 'error': form.errors.password }"
                            @focus="form.errors.password = null"
                            v-model="form.password"
                        >
                        <transition name="fade">
                            <p v-if="form.errors.password" class="error-message">{{ $t(form.errors.password) }}</p>
                        </transition>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: center; width: 100%; gap: 5px">
                        <input
                            :placeholder="$t('password_confirmation')"
                            name="password"
                            type="password"
                            :class="{ 'error': form.errors.password_confirmation }"
                            @focus="form.errors.password_confirmation = null"
                            v-model="form.password_confirmation"
                        >
                        <transition name="fade">
                            <p v-if="form.errors.password_confirmation" class="error-message">{{ $t(form.errors.password_confirmation) }}</p>
                        </transition>
                    </div>
                    <button class="primary" :disabled="form.processing" type="submit">{{ $t('sign_up_button') }}</button>
                </form>
                <div class="social-login">
                    <a :href="route('auth.google.redirect')" class="google"/>
                    <a :href="route('auth.github.redirect')" class="github"/>
                </div>
            </div>
        </div>
        <div class="login-links">
            <Link :href="route('auth.login.view')">{{ $t('already_registered') }}</Link>
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
.login-links a {
    color: black;
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
@media screen and (max-width: 1200px) {
    .login {
        width: 100%;
    }
    button {
        font-size: 14px;
    }
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
                fullname: '',
                email: '',
                password: '',
                password_confirmation: ''
            }),
        }
    },
    methods: {
        formSubmit() {
            this.form.post(route('auth.register.store'), {
                onFinish: () => this.form.reset('password', 'password_confirmation'),
            });
        },
    }
}
</script>
