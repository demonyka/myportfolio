<script>
export default {
    name: "FlashMessage",
    data() {
        return {
            isVisible: false
        };
    },
    mounted() {
        setTimeout(() => {
            this.isVisible = true;
        }, 100);
        setTimeout(() => {
            this.isVisible = false;
        }, 5000);
    }
}
</script>

<template>
    <transition name="fade">
        <div v-if="isVisible" class="flash" :class="`${$page.props.flash.message.type}`">
            {{ $page.props.flash.message.text }}
        </div>
    </transition>
</template>

<style scoped>
.flash {
    position: fixed;
    padding: 30px;
    right: 50%;
    transform: translateX(50%);
    bottom: 80px;
    background-color: var(--gray3);
    border-radius: 20px;
    color: var(--white);
    max-width: 40vw;
    text-align: center;
    z-index: 1000;
}
.flash.success {
    background-color: var(--green1);
}
.flash.error {
    background-color: var(--red);
}
</style>
