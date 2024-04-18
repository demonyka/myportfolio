<template>
    <Head :title='$t("homepage")' />
    <Layout>

    </Layout>
</template>

<style scoped>

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
    }
}
</script>
