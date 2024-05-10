<template>
    <Head :title=userData.fullname />
    <Layout>
        <div class="index">
            <div class="left-side">
                <UserCard :user="user" :user-data="userData" @edit-clicked="isEdit = true" :is-edit="isEdit"/>
                <SecurityCard style="margin-top: 20px" v-if="isMyProfile"/>
            </div>
            <div class="content">
                <PostPublish :posts="posts" v-if="!isEdit"/>
                <ProfileEdit @update-user="updateUser" @cancel-clicked="isEdit = false" v-else-if="isMyProfile"/>
            </div>
            <div class="right-side">
                <FindUsers/>
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
import FindUsers from "@/Pages/Profile/RightSide/FindUsers.vue";
import ProfileEdit from "@/Pages/Profile/Content/ProfileEdit.vue";

export default {
    name: "Profile",
    components: {
        PostPublish, ProfileEdit,
        UserCard, SecurityCard,
        FindUsers,
        Layout,
        Head,
        Link
    },
    data() {
        return {
            user: this.$page.props.user,
            isMyProfile: this.$page.props.auth.user?.id === this.$page.props.user.id,
            userData: JSON.parse(this.$page.props.user.external_data),
            isEdit: false,
        };
    },
    props: [
        'posts'
    ],
    mounted() {

    },
    methods: {
        updateUser() {
            this.user = this.$page.props.user;
            this.userData = JSON.parse(this.$page.props.user.external_data)
        }
    },
}
</script>
