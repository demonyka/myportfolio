<template>
    <Head :title='$t("homepage")' />
    <Layout>
        <div class="email-verify">
            <div class="email-content">
                <h2>
                    {{ $t('email_confirm_title') }}
                </h2>
                <p>{{ $t('email_confirm_text', {email: $page.props.auth.user.email}) }}</p>
                <button class="primary">{{ $t('email_confirm_button') }}</button>
            </div>
        </div>
    </Layout>
</template>

<style scoped>
.email-verify {
    background-color: white;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    border-radius: 20px;
    width: 40%;
}
.email-content {
    padding: 20px 30px;
    text-align: center;
}
.email-content h2 {
    font-weight: 600;
    margin: 0;
}
@media screen and (max-width: 1000px) {
    .email-verify {
        width: 100%;
    }
    .email-verify button {
        font-size: 14px;
    }
}
</style>

<script>
import { Head, Link } from "@inertiajs/vue3";
import Layout from "@/Layouts/Layout.vue";

export default {
    name: "EmailVerify",
    components: {
        Layout,
        Head,
        Link
    }
}
</script>
