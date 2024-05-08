<template>
    <Head :title='$t("homepage")' />
    <Layout>
        <div class="index">
            <div class="top">
                <div class="left-side">
                    <div class="left-content">
                        <h2>
                            {{ $t('welcome-title') }}
                        </h2>
                        <p>
                            {{ $t('welcome-text') }}
                        </p>

                        <button @click="this.$inertia.visit(route('auth.login.view'))"
                                class="primary">{{ $t('welcome-join') }}
                        </button>
                    </div>
                </div>
                <div class="right-side">
                    <div class="right-content">

                    </div>
                </div>
            </div>

        </div>
    </Layout>
</template>

<style scoped>
    .index {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        width: 100%;
        gap: 20px;
    }
    .top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        width: 100%;
        gap: 20px;
    }
    .full-side {
        background-color: white;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        border-radius: 20px;
        width: 100%;
    }
    .full-content {
        padding: 20px 30px;
    }
    .left-side, .right-side {
        background-color: white;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        border-radius: 20px;
        width: 40%;
    }
    .right-side {
        width: 60%;
    }
    .left-content, .right-content {
        padding: 20px 30px;
    }
    .left-content h2, .right-side h2 {
        font-weight: 600;
        margin: 0;
    }
    @media screen and (max-width: 1000px) {
        .left-side, .right-side {
            width: 100%;
        }
        .left-side button, .right-side button {
            width: 100%;
        }
        .top {
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
    }
</style>

<script>
import { Head, Link } from "@inertiajs/vue3";
import Layout from "@/Layouts/Layout.vue";

export default {
    name: "Index",
    components: {
        Layout,
        Head,
        Link
    }
}
</script>
