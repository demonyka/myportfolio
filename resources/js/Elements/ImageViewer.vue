<script>
export default {
    name: "ImageViewer",
    mounted() {
        document.body.style.overflow = 'hidden';
        this.checkSides();
    },
    beforeUnmount() {
        document.body.style.overflow = 'auto';
    },
    props: [
        'files',
        'src'
    ],
    data() {
        return {
            canLeft: false,
            canRight: false,
        }
    },
    methods: {
        checkSides() {
            if (this.files) {
                this.canLeft = this.files[0] !== this.src;
                this.canRight = this.files[this.files.length - 1] !== this.src;
            }
        }
    }
}
</script>

<template>
    <span @click="src = files[files.indexOf(src)-1]; checkSides()" v-if="canLeft" class="left">
        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M14.2893 5.70708C13.8988 5.31655 13.2657 5.31655 12.8751 5.70708L7.98768 10.5993C7.20729 11.3805 7.2076 12.6463 7.98837 13.427L12.8787 18.3174C13.2693 18.7079 13.9024 18.7079 14.293 18.3174C14.6835 17.9269 14.6835 17.2937 14.293 16.9032L10.1073 12.7175C9.71678 12.327 9.71678 11.6939 10.1073 11.3033L14.2893 7.12129C14.6799 6.73077 14.6799 6.0976 14.2893 5.70708Z" fill="var(--gray2)"/>
        </svg>
    </span>
    <div @click="$emit('close-image')" class="image-viewer">
        <img alt="image" @click.stop :src="src">
    </div>
    <span @click="src = files[files.indexOf(src)+1]; checkSides()" v-if="canRight" class="right">
        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M14.2893 5.70708C13.8988 5.31655 13.2657 5.31655 12.8751 5.70708L7.98768 10.5993C7.20729 11.3805 7.2076 12.6463 7.98837 13.427L12.8787 18.3174C13.2693 18.7079 13.9024 18.7079 14.293 18.3174C14.6835 17.9269 14.6835 17.2937 14.293 16.9032L10.1073 12.7175C9.71678 12.327 9.71678 11.6939 10.1073 11.3033L14.2893 7.12129C14.6799 6.73077 14.6799 6.0976 14.2893 5.70708Z" fill="var(--gray2)"/>
        </svg>
    </span>
</template>

<style scoped>
    .image-viewer {
        position: fixed;
        left: 0;
        top: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, .5);
        z-index: 10000;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .image-viewer img {
        max-width: 80vw;
        max-height: 80vh;
        cursor: default;
    }
    span {
        z-index: 11000;
        height: 100vh;
        position: fixed;
        display: flex;
        align-items: center;
        justify-content: center;
        bottom: 0;
        padding: 0 10px;
        cursor: pointer;
    }
    span:hover svg path {
        fill: var(--gray1);
    }
    span:hover {
        background-color: rgba(255, 255, 255, .1);
    }
    span.left {
        left: 0;
    }
    span.right {
        right: 0;
        transform: rotate(180deg);
    }
    @media screen and (max-width: 1200px) {
        .image-viewer img {
            max-width: 60vw;
        }
        span:hover {
            background-color: transparent;
        }
    }
</style>
