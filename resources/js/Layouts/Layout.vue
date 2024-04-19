<template>
    <CookieAccept/>
    <Navbar/>
    <div class="container">
        <slot />
    </div>
    <Footbar/>
    <FlashMessage v-if="$page.props.flash.message" :message="$page.props.flash.message"/>
</template>

<style scoped>

</style>

<script>
import CookieAccept from "@/Components/CookieAccept.vue";
import Navbar from "@/Components/Navbar.vue";
import Footbar from "@/Components/Footbar.vue";
import FlashMessage from "@/Components/FlashMessage.vue";

export default {
    name: "Layout",
    components: {
        FlashMessage,
        Footbar,
        Navbar,
        CookieAccept,
    }
}
</script>
