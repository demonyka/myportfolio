<template>
    <Head :title=userData.fullname />
    <Layout>
        <div class="index">
            <div class="left-side">
                <UserCard/>
                <SecurityCard style="margin-top: 20px" v-if="isMyProfile"/>
            </div>
            <div class="content">
                <PostPublish/>
            </div>
            <div class="right-side">
                <MostPopularAuthors :authors="popularAuthors"/>
            </div>
        </div>

    </Layout>
</template>

<style scoped>
    .index {
        display: flex;
        align-items: flex-start;
        width: 100%;
        gap: 20px;
    }
    .left-side, .right-side {
        width: 25%;
        min-width: 25%;
    }
    .content {
        width: 100%;
    }
    @media screen and (max-width: 1200px) {
        .index {
            flex-direction: column;
        }
        .left-side {
            width: 100%;
            min-width: 100%;
        }
        .right-side {
            width: 100%;
            min-width: 100%;
        }
    }
</style>

<script>
import {Head, Link} from "@inertiajs/vue3";
import Layout from "@/Layouts/Layout.vue";
import UserCard from "@/Pages/Profile/LeftSide/UserCard.vue";
import SecurityCard from "@/Pages/Profile/LeftSide/SecurityCard.vue";
import PostPublish from "@/Pages/Profile/Content/PostPublish.vue";
import MostPopularAuthors from "@/Pages/Profile/RightSide/MostPopularAuthors.vue";

export default {
    name: "Index",
    components: {
        PostPublish,
        UserCard, SecurityCard,
        MostPopularAuthors,
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
        'popularAuthors'
    ],
    mounted() {

    },
    methods: {

    },
}
</script>
