<template>
    <CookieAccept/>
    <slot />
</template>

<style scoped>

</style>

<script>
import CookieAccept from "@/Components/CookieAccept.vue";

export default {
    name: "Layout",
    components: {CookieAccept}
}
</script>
