<script>
export default {
    name: "FlashMessage",
    data() {
        return {

        };
    }
}
</script>

<template>
    <transition name="fade">
        <div class="flash" :class="`${$page.props.flash.message.type}`">
            {{ $t($page.props.flash.message.text) }}
        </div>
    </transition>
</template>

<style scoped>
.flash {
    position: fixed;
    padding: 20px 30px;
    right: 50%;
    transform: translateX(50%);
    bottom: 40px;
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
