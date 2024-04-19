<template>
    <CookieAccept/>
    <Navbar/>
    <div class="container">
        <slot />
    </div>
    <Footbar/>

</template>

<style scoped>

</style>

<script>
import CookieAccept from "@/Components/CookieAccept.vue";
import Navbar from "@/Components/Navbar.vue";
import Footbar from "@/Components/Footbar.vue";

export default {
    name: "Layout",
    components: {Footbar, Navbar, CookieAccept}
}
</script>
