<template>
    <Head :title='head' />
    <Layout>
        <div class="index">
            <div class="index-content">
                <h2>{{ title }}</h2>
                <div class="content" v-for="(part, index) in content">
                    <h4 style="margin-bottom: 0">{{ index }}</h4>
                    <ul style="display: flex; flex-direction: column; gap: 10px">
                        <li v-for="text in part" v-html="text"/>
                    </ul>
                </div>
            </div>
        </div>
    </Layout>
</template>

<style scoped>
.index {
    background-color: white;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    border-radius: 20px;
    width: 100%;
}
.index-content {
    padding: 20px 30px;
}
.index-content h2 {
    margin: 0;
    font-size: 20px;
}
li {
    word-break: break-word;
    text-wrap: balance;
}
</style>

<script>
import { Head, Link } from "@inertiajs/vue3";
import Layout from "@/Layouts/Layout.vue";

export default {
    name: "Misc",
    components: {
        Layout,
        Head,
        Link
    },
    props: [
        'head',
        'title',
        'content'
    ]
}
</script>
