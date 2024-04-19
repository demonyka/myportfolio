<template>
    <div class="footbar">
        <div class="foot-content">
            <div class="copyright">
                <div class="logo small"/>
                <small>{{ $t('copyright') }}</small>
            </div>
            <div class="links">
                <a>{{ $t('about_us') }}</a>
                <a>{{ $t('privacy_policy') }}</a>
            </div>
        </div>
    </div>
</template>

<style scoped>
.logo.small {
    min-width: 35px;
    min-height: 35px;
}
.footbar {
    border-radius: 20px 20px 0 0;
    width: 100%;
    position: absolute;
    background-color: var(--white);
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    bottom: 0;
}
.foot-content {
    padding: 20px 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.foot-content img {
    width: 35px;
    height: 35px;
}
.foot-content .copyright {
    display: flex;
    align-items: center;
    gap: 10px;
    max-width: 50%;
}
.foot-content .links {
    display: flex;
    align-items: center;
    gap: 20px;
    max-width: 50%;
}
@media screen and (max-width: 1000px) {
    .footbar {
        width: 100vw;
        border-radius: 0;
    }
    .foot-content {
        padding: 15px 20px;
    }
    .foot-content .links {
        flex-direction: column;
        align-items: flex-end;
        text-align: end;
        gap: 5px;
    }
    .foot-content .links a {
        font-size: 10px;
    }
    small {
        font-size: 10px;
    }
}
a {
    color: black;
    font-size: 14px;
}
a:hover {
    scale: 1;
}
</style>

<script>
export default {
    name: "Footbar"
}
</script>
