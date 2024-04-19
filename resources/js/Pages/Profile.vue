<template>
    <Head :title=user.name />
    <Layout>
        <div class="index">
            <p v-if="$page.props.auth.user && (user.id === $page.props.auth.user.id)">Ваш профиль</p>
            <p v-for="(key, index) in user">{{ index }}: {{ key }}</p>
        </div>
    </Layout>
</template>

<style scoped>
    .index {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        width: 100%;
    }
    .left-content h2 {
        font-weight: 600;
        margin: 0;
    }
    @media screen and (max-width: 1000px) {
        .left-side button {
            width: 100%;
        }
    }
</style>

<script>
import { Head, Link } from "@inertiajs/vue3";
import Layout from "@/Layouts/Layout.vue";

export default {
    name: "Index",
    components: {
        Layout,
        Head,
        Link
    },
    props: [
        'user'
    ]
}
</script>
