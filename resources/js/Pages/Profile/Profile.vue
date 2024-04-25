<template>
    <Head :title=userData.fullname />
    <Layout>
        <div class="index">
            <div class="left-side">
                <UserCard/>
            </div>
            <div class="content">
                <div class="menu-desktop">
                    <div class="labels" v-if="sections.length !== 0">
                        <label @click="currentSection = section.id" :class="{ 'active': currentSection === section.id }" v-for="section in sections" :key="section.id">
                            {{ section['name'] }}
                        </label>
                    </div>
                    <span v-if="isMyProfile" class="menu-edit">
                        Редактировать
                    </span>
                </div>
            </div>
            <div class="right-side">

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
    .left-side {
        width: 25%;
        min-width: 25%;
    }
    .right-side {
        width: 25%;
        min-width: 25%;
    }
    .content {
        width: 100%;
    }
    .content .menu-desktop {
        background-color: white;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        border-radius: 20px;
        position: relative;
        padding: 0 40px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .content .menu-desktop .labels {
        display: flex;
        align-items: center;
        gap: 5%;
        width: 100%;
        position: relative;
    }
    .content .menu-desktop label {
        padding: 20px 0;
        cursor: pointer;
        border-bottom: 1px solid transparent;
    }
    .content .menu-desktop label:hover, .content .menu-desktop label.active, .content .menu-desktop span.menu-edit:hover {
        color: var(--blue1);
        border-color: var(--blue1);
    }
    .content .menu-desktop span.menu-edit {
        justify-content: flex-end;
        display: flex;
        padding: 20px 0;
        cursor: pointer;
        border-bottom: 1px solid transparent;
    }
    @media screen and (max-width: 1400px) {
        .content .menu-desktop {
            font-size: .75rem;
        }
    }
    @media screen and (max-width: 1200px) {
        .content .menu-desktop {
            display: none;
        }
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
            sections: this.$page.props.sections || [],
            currentSection: (this.$page.props.sections && this.$page.props.sections.length > 0) ? this.$page.props.sections[0].id : null,
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
