<template>
    <CookieAccept/>
    <Navbar/>
    <slot />
</template>

<style scoped>

</style>

<script>
import CookieAccept from "@/Components/CookieAccept.vue";
import Navbar from "@/Components/Navbar.vue";

export default {
    name: "Layout",
    components: {Navbar, CookieAccept}
}
</script>
