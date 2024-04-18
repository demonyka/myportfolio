<template>
    <Head :title='$t("homepage")' />
    <Layout>
        <Navbar/>
    </Layout>
</template>

<style scoped>

</style>

<script>
import { Head, Link } from "@inertiajs/vue3";
import Navbar from "@/Components/Navbar.vue";
import Layout from "@/Layouts/Layout.vue";

export default {
    name: "Index",
    components: {
        Layout,
        Navbar,
        Head,
        Link
    }
}
</script>
