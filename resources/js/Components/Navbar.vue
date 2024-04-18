<template>
    <div class="navbar">
        <div class="nav-content">
            <Logo/>
            <div class="right-side">
                <div class="language">
                    <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_1_30)">
                            <path d="M0.876648 8.7046H25.0946C23.332 3.71997 18.5823 0.147164 12.9952 0.142883H12.9758C7.38869 0.147164 2.63865 3.71997 0.876648 8.7046Z" fill="#F3F4F5"/>
                            <path d="M25.0943 17.2663H0.876648C2.64008 22.2538 7.39411 25.828 12.9855 25.828C18.5769 25.828 23.3309 22.2538 25.0943 17.2663Z" fill="#D52B1E"/>
                            <path d="M25.0943 17.2663C25.5678 15.927 25.828 14.4869 25.828 12.9854C25.828 11.484 25.568 10.0439 25.0943 8.70459H0.876623C0.402874 10.0439 0.142883 11.484 0.142883 12.9854C0.142883 14.4869 0.40316 15.9273 0.876623 17.2663H25.0943Z" fill="#0039A6"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_1_30">
                                <rect width="26" height="26" fill="white"/>
                            </clipPath>
                        </defs>
                    </svg>
                    Рус
                </div>
            </div>
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
.language {
    border: 1px solid var(--gray4);
    border-radius: 40px;
    padding: 10px 15px;
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
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
