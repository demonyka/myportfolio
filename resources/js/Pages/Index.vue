<template>
    <Head :title='$t("homepage")' />
    <Navbar/>
</template>

<style scoped>

</style>

<script>
import { Head, Link } from "@inertiajs/vue3";
import Navbar from "@/Components/Navbar.vue";

export default {
    name: "Index",
    components: {
        Navbar,
        Head,
        Link
    }
}
</script>
