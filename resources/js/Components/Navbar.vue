<template>
    <div class="navbar">
        <div class="nav-content">
            <Logo/>
        </div>
    </div>
</template>

<style scoped>
.navbar {
    border-radius: 20px;
    width: 100%;
    position: relative;
    background-color: var(--white);
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);

}
.nav-content {
    padding: 15px 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
</style>

<script>
import { Link } from '@inertiajs/vue3';
import Logo from "@/Elements/Logo.vue";
export default {
    name: "Navbar",
    components: {
        Logo,
        Link,
    },
    methods: {

    }
}
</script>
