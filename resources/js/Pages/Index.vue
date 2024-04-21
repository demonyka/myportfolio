<template>
    <Head :title='$t("homepage")' />
    <Layout>
        <div class="index">
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
        </div>
    </Layout>
</template>

<style scoped>
    .index {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        width: 100%;
    }
    .left-side {
        background-color: white;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        border-radius: 20px;
        width: 40%;
    }
    .left-content {
        padding: 20px 30px;
    }
    .left-content h2 {
        font-weight: 600;
        margin: 0;
    }
    @media screen and (max-width: 1000px) {
        .left-side {
            width: 100%;
        }
        .left-side button {
            width: 100%;
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
