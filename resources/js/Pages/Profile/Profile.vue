<template>
    <Head :title=userData.fullname />
    <Layout>
        <div class="index">
            <div class="left-side">
                <UserCard/>
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
        width: 25%;
    }
    @media screen and (max-width: 1000px) {
        .left-side {
            width: 100%;
        }
    }
</style>

<script>
import {Head, Link} from "@inertiajs/vue3";
import Layout from "@/Layouts/Layout.vue";
import UserCard from "@/Pages/Profile/LeftSide/UserCard.vue";

export default {
    name: "Index",
    components: {
        UserCard,
        Layout,
        Head,
        Link
    },
    data() {
        return {
            user: this.$page.props.user,
            isMyProfile: this.$page.props.auth.user?.id === this.$page.props.user.id,
            userData: JSON.parse(this.$page.props.user.external_data),
        };
    },
    props: [

    ],
    mounted() {

    },
}
</script>
