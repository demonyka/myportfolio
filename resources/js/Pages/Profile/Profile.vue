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
                        <label @click="selectSection(section)" :class="{ 'active': currentSection === section }" v-for="section in sections" :key="section.id">
                            {{ section['name'] }}
                        </label>
                    </div>
                    <span v-if="isMyProfile" class="menu-edit">
                        Редактировать
                    </span>
                </div>
                <form v-if="currentSection && isMyProfile" class="section-content" @submit.prevent="newPostPublish">
                    <h2>Новая публикация в раздел "{{ currentSection.name }}"</h2>
                    <div style="width: 100%">
                        <QuillEditor
                            theme="snow"
                            :toolbar="'essential'"
                            v-model:content="formNewPost.content"
                            content-type="html"
                        />
                    </div>
                    <input multiple accept="image/*, video/*, application/pdf" type="file">
                    <button class="primary" type="submit">Опубликовать</button>
                    <p v-if="formNewPost.error" class="error-message">Произошла ошибка, попробуйте позже</p>
                </form>
                <div class="section-content" v-for="post in posts.data">
                    <div class="post-header">
                        <div class="user-info">
                            <img alt="avatar" :src="JSON.parse(post.author.external_data).avatar_path" @error="$event.target.src = 'http://[::1]:5173/public/assets/images/default_avatar.png'">
                            <h4>{{ JSON.parse(post.author.external_data).fullname }}</h4>
                        </div>
                        <span class="post-date">{{ formatDate(post.created_at) }} {{ formatTime(post.created_at) }}</span>
                    </div>
                    <div class="post-content" v-html="post.content"/>
                </div>
            </div>
            <div class="right-side">

            </div>
        </div>

    </Layout>
</template>

<style scoped>
    .post-content * {
        margin: 0;
    }
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
    .section-content {
        background-color: white;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        border-radius: 20px;
        position: relative;
        padding: 20px 40px;
        margin-top: 20px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
    }
    .section-content h2 {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
    }
    .section-content textarea {
        width: calc(100% - 40px) !important;
        min-height: 150px;
        padding: 10px 20px;
        resize: none;
        border-radius: 10px;
        outline: none;
        border: 1px solid var(--gray4);
    }
    .section-content textarea:focus {
        border-color: var(--blue1);
    }
    .section-content .user-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .section-content .post-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }
    .section-content .post-header span.post-date {
        color: var(--gray3);
    }
    .section-content .user-info img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 100%;
    }
    .section-content .user-info h4 {
        font-size: 18px;
        margin: 0;
        font-weight: 600;
    }
    @media screen and (max-width: 1400px) {
        .content .menu-desktop {
            font-size: .75rem;
        }
        .section-content .user-info {
            gap: 10px;
        }
        .section-content .post-header span.post-date {
            font-size: 10px;
        }
        .section-content .user-info img {
            width: 30px;
            height: 30px;
        }
        .section-content .user-info h4 {
            font-size: 12px;
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
import {Head, Link, useForm} from "@inertiajs/vue3";
import Layout from "@/Layouts/Layout.vue";
import UserCard from "@/Pages/Profile/LeftSide/UserCard.vue";
import { QuillEditor } from '@vueup/vue-quill'
import '@/../css/vue-quill.css';

export default {
    name: "Index",
    components: {
        UserCard,
        Layout,
        Head,
        Link,
        QuillEditor
    },
    data() {
        return {
            posts: [],
            user: this.$page.props.user,
            sections: this.$page.props.sections || [],
            currentSection: (this.$page.props.sections && this.$page.props.sections.length > 0) ? this.$page.props.sections[0] : null,
            isMyProfile: this.$page.props.auth.user?.id === this.$page.props.user.id,
            userData: JSON.parse(this.$page.props.user.external_data),
            postsCache: {},
            formNewPost: {
                content: '',
                error: false
            },
        };
    },
    props: [

    ],
    mounted() {
        if(this.currentSection) {
            this.selectSection(this.sections[0])
        }
    },
    methods: {
        selectSection(section) {
            this.currentSection = section;
            if (!this.postsCache[section.id]) {
                this.getPosts(section.id, 1);
            } else {
                this.posts = this.postsCache[section.id];
            }
        },
        async getPosts(sectionId, page) {
            try {
                const cacheKey = `${sectionId}_${page}`;
                if (!this.postsCache[cacheKey]) {
                    const response = await axios.get(route('api.user.posts.get', { section_id: sectionId, page: page }));
                    this.posts = response.data;
                    this.postsCache[cacheKey] = this.posts;
                } else {
                    this.posts = this.postsCache[cacheKey];
                }
            } catch (error) {
                console.error('Ошибка при загрузке постов:', error);
            }
        },
        newPostPublish() {
            axios
                .post(route('profile.post.store'), {
                    _token: this.$page.props.csrf_token,
                    post: {
                        content: this.formNewPost.content,
                        section: this.currentSection,
                    },
                })
                .then((response) => {
                    this.postsCache[`${this.currentSection}_1`] = '';
                    this.getPosts(this.currentSection, 1);
                    this.formNewPost.error = false;
                })
                .catch((error) => {
                    this.formNewPost.error = true;
                });
        },
        formatDate(dateString) {
            const date = new Date(dateString);
            return this.$d(date, 'long');
        },
        formatTime(dateString) {
            const date = new Date(dateString);
            const day = date.getDate().toString().padStart(2, '0');
            const month = (date.getMonth() + 1).toString().padStart(2, '0');
            const year = date.getFullYear();
            const hours = date.getHours().toString().padStart(2, '0');
            const minutes = date.getMinutes().toString().padStart(2, '0');
            return `${hours}:${minutes}`;
        }
    },
}
</script>
