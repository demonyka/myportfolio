<template>
    <Head :title='$t("sign_in_short")' />
    <Layout>
        <div class="login" @submit.prevent="formSubmit">
            <div class="login-content">
                <h3>{{ $t('reset_password') }}</h3>
                <form class="login-form">
                    <div style="width: 100%; display: flex; flex-direction: column; align-items: center; gap: 5px">
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
                    <button class="primary" :disabled="form.processing" type="submit">{{ $t('send_button') }}</button>
                </form>
            </div>
        </div>
        <div class="login-links">
            <Link :href="route('auth.login.view')">{{ $t('remembered_password') }}</Link>
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
                email: '',
            }),
        }
    },
    methods: {
        formSubmit() {
            this.form.post(route('auth.forgot-password.send'), {
                onFinish: (response) => console.log(response),
            });
        },
    }
}
</script>
