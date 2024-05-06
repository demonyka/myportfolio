<template>
    <div>
        <div class="menu-desktop" v-if="!isSectionEdit">
            <div class="labels" v-if="sections.length !== 0">
                <label @click="selectSection(section)" :class="{ 'active': currentSection === section }" v-for="section in sections" :key="section.id">
                    {{ section['name'] }}
                </label>
            </div>
            <span @click="isSectionEdit = true" v-if="isMyProfile" class="menu-edit">
                {{ $t('profile.edit.edit') }}
            </span>
        </div>
        <div class="menu-desktop" v-else>
            <div class="labels edit">
                <input v-for="i in 4" :key="i"
                       class="input-section"
                       v-model="formSectionEdit[i - 1]['name']"
                       :placeholder="$t('profile.edit.sections.placeholder')"
                >
            </div>
            <span @click="formSectionEditSubmit" v-if="isMyProfile" class="menu-edit">
            {{ $t('profile.edit.sections.save') }}
        </span>
        </div>
        <div v-if="postLoading" class="loader"></div>
    </div>


    <div>
        <div class="menu-mobile">
            <div :class="{ 'active': isSectionMobileOpened }" @click="isSectionEdit ? false : isSectionMobileOpened = !isSectionMobileOpened" class="menu-mobile-title">
                <span>{{ currentSection.name }}</span>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.70711 9.71069C5.31658 10.1012 5.31658 10.7344 5.70711 11.1249L10.5993 16.0123C11.3805 16.7927 12.6463 16.7924 13.4271 16.0117L18.3174 11.1213C18.708 10.7308 18.708 10.0976 18.3174 9.70708C17.9269 9.31655 17.2937 9.31655 16.9032 9.70708L12.7176 13.8927C12.3271 14.2833 11.6939 14.2832 11.3034 13.8927L7.12132 9.71069C6.7308 9.32016 6.09763 9.32016 5.70711 9.71069Z" fill="#0F0F0F"/>
                </svg>
            </div>
            <transition name="height">
                <div v-if="isSectionMobileOpened">
                    <div v-if="!isSectionEdit" class="menu-mobile-content">
                        <label @click="selectSection(section)" v-for="section in sections" :key="section.id" :style="{ display: currentSection !== section ? 'block' : 'none' }">
                            {{ section.name }}
                        </label>
                        <span @click="isSectionEdit = true" v-if="isMyProfile" class="menu-edit">
                            {{ $t('profile.edit.edit') }}
                        </span>
                    </div>
                    <div v-else class="menu-mobile-content">
                        <input v-for="i in 4" :key="i"
                            class="input-section mobile"
                            v-model="formSectionEdit[i - 1]['name']"
                            :placeholder="$t('profile.edit.sections.placeholder')"
                        >
                        <span @click="formSectionEditSubmit" v-if="isMyProfile" class="menu-edit" style="text-align: center; margin-top: 10px; font-size: 14px">
                            {{ $t('profile.edit.sections.save') }}
                        </span>
                    </div>
                </div>
            </transition>
        </div>
    </div>





    <form v-if="currentSection && isMyProfile" class="section-content" @submit.prevent="newPostPublish">
        <h2>{{ $t('profile.post.new_post.title') }} "{{ currentSection.name }}"</h2>
        <div style="width: 100%">
            <QuillEditor
                theme="snow"
                toolbar="essential"
                v-model:content="formNewPost.content"
                content-type="html"
            />
            <p v-if="formNewPost.error && formNewPost.error.post" style="margin-top: 10px; text-align: left" v-for="error in formNewPost.error.post" class="error-message">{{ $t(error) }}</p>
        </div>

        <div>
            <input ref="fileInput" @change="postFileChange" multiple type="file">
            <p v-if="formNewPost.error && formNewPost.error.files" style="margin-top: 10px; text-align: left" v-for="error in formNewPost.error.files" class="error-message">{{ $t(error) }}</p>
        </div>
        <button class="primary" type="submit">{{ $t('profile.post.new_post.submit') }}</button>
    </form>
    <div class="section-content" v-for="post in posts.data">
        <div class="post-header">
            <div class="user-info">
                <img alt="avatar" :src="JSON.parse(post.author.external_data).avatar_path || 'http://[::1]:5173/public/assets/images/default_avatar.png'" @onerror="$event.target.src = 'http://[::1]:5173/public/assets/images/default_avatar.png'">
                <h4>{{ JSON.parse(post.author.external_data).fullname }}</h4>
            </div>
            <span class="post-date">{{ formatDate(post.created_at) }}</span>
        </div>
        <div class="post-content" v-html="postFull[post.id] ? post.content : post.content.substr(0, 1024)"></div>
        <div class="post-content full-content" v-if="post.content.length > 1024 && !postFull[post.id]" @click="postFull[post.id] = true">Читать полностью</div>
        <div v-if="JSON.parse(post.files)" class="post-files">
            <div class="non-image-files">
                <div v-for="(file, index) in JSON.parse(post.files)" :key="index">
                    <a :href="file" target="_blank">{{ getFileName(file) }}</a>
                </div>
            </div>
        </div>
        <div class="post-likes">
            <div class="like">
                <svg :class="{ active: post.is_liked, disabled: !$page.props.auth.user || isMyProfile }" @click="$page.props.auth.user && !isMyProfile ? postLike(post.id) : false" class="like" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke="#828282" fill="transparent" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <small>{{ post.like_count }}</small>
            </div>
        </div>
    </div>
</template>

<style scoped>
.loader {
    height: 1px;
    //width: 130px;
    --c:no-repeat linear-gradient(var(--blue1) 0 0);
    background: var(--c),var(--c),transparent;
    background-size: 60% 100%;
    animation: l16 5s infinite;
    width: calc(100% - 40px);
    position: relative;
    left: 50%;
    transform: translate(-50%, -1px);
}
@keyframes l16 {
    0%   {background-position:-150% 0,-150% 0}
    66%  {background-position: 250% 0,-150% 0}
    100% {background-position: 250% 0, 250% 0}
}
.input-section {
    border: none;
    border-bottom: 1px solid black;
    padding: 20px 0;
    outline: none;
    font-size: 16px;
    text-align: center;
    width: 100%;
}
.input-section:focus {
    border-color: var(--blue1);
}
.input-section.mobile {
    padding-bottom: 10px;
    padding-top: 10px;
    font-size: 14px;
    text-align: left;
    border-color: var(--gray4)
}
.post-files {
    position: relative;
    width: 100%;
}
.non-image-files {
    margin-top: 10px;
}
.non-image-files a {
    word-break: break-word;
    color: black;
}
.post-content {
    width: 100%;
}
.post-content * {
    margin: 0;
    max-width: 100%;
    word-break: break-word;
}
.post-content.full-content {
    cursor: pointer;
}
.post-content.full-content:hover {
    opacity: .8;
}
.menu-desktop, .menu-mobile {
    background-color: white;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    border-radius: 20px;
    position: relative;
    padding: 0 40px;
    overflow: hidden;
    display: flex;
    gap: 20px;
}
.menu-mobile {
    display: none;
    flex-direction: column;
    padding: 20px 20px 20px 30px;
}
.menu-mobile .menu-mobile-title {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
}
.menu-mobile .menu-mobile-title.active {
    color: var(--blue1);
}
.menu-mobile .menu-mobile-title.active svg path {
    fill: var(--blue1);
}
.menu-mobile .menu-mobile-title.active svg {
    transform: rotate(180deg);
}
.menu-mobile .menu-mobile-content {
    overflow: hidden;
    display: flex;
    flex-direction: column;
    gap: 20px;
}
.menu-desktop .labels {
    display: flex;
    align-items: center;
    gap: 5%;
    width: 100%;
    position: relative;
}
.labels.edit {
    margin-right: 60px;
}
.menu-desktop label {
    padding: 20px 0;
    cursor: pointer;
    border-bottom: 1px solid transparent;
}
.menu-desktop label:hover, .menu-desktop label.active, .menu-desktop span.menu-edit:hover {
    color: var(--blue1);
    border-color: var(--blue1);
}
.menu-desktop span.menu-edit {
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
.section-content .post-likes {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
    justify-content: flex-end;
}
.section-content .post-likes div.like {
    display: flex;
    align-items: center;
    gap: 5px;
}
.section-content .post-likes div.like small {
    color: var(--gray3);
    cursor: default;
}
svg.like {
    cursor: pointer;
}
svg.like.disabled {
    cursor: default !important;
    pointer-events: none;
}
svg.like:hover path {
    stroke: var(--red);
    fill: var(--red);
}
svg.like.active path {
    stroke: var(--red);
    fill: var(--red);
}
@media screen and (max-width: 1400px) {
    .menu-desktop {
        font-size: .75rem;
    }
    .section-content {
        padding: 20px;
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
    .input-section {
        font-size: 12px;
    }
}
@media screen and (max-width: 1200px) {
    .menu-desktop {
        display: none;
    }
    .menu-mobile {
        display: flex;
    }
    .labels.edit {
        margin-right: 20px;
    }
}
</style>

<script>
import {Head, Link, useForm} from "@inertiajs/vue3";
import { QuillEditor } from '@vueup/vue-quill'
import '@/../css/vue-quill.css';

export default {
    name: "PostsPublish",
    components: {
        Head,
        Link,
        QuillEditor
    },
    data() {
        return {
            posts: [],
            user: this.$page.props.user,
            sections: this.$page.props.sections || [],
            isSectionEdit: false,
            currentSection: (this.$page.props.sections && this.$page.props.sections.length > 0) ? this.$page.props.sections[0] : null,
            isMyProfile: this.$page.props.auth.user?.id === this.$page.props.user.id,
            userData: JSON.parse(this.$page.props.user.external_data),
            postsCache: {},
            formNewPost: {
                content: '',
                files: [],
                error: false
            },
            postFull: {},
            formSectionEdit: useForm({
                0: this.$page.props.sections[0] || {id: null, name: ''},
                1: this.$page.props.sections[1] || {id: null, name: ''},
                2: this.$page.props.sections[2] || {id: null, name: ''},
                3: this.$page.props.sections[3] || {id: null, name: ''},
            }),
            postLoading: false,
            isSectionMobileOpened: false
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
        getFileName(file) {
            return file.split('/').pop();
        },
        selectSection(section) {
            this.currentSection = section;
            if (!this.postsCache[section.id]) {
                this.getPosts(section.id, 1);
            } else {
                this.posts = this.postsCache[section.id];
            }
            this.isSectionMobileOpened = false;
        },
        async getPosts(sectionId, page) {
            const timeoutId = setTimeout(() => {
                this.postLoading = true;
            }, 1000);
            try {
                const cacheKey = `${sectionId}_${page}`;
                if (!this.postsCache[cacheKey]) {
                    const response = await axios.get(route('api.user.post.get', { section_id: sectionId, page: page }));
                    this.posts = response.data;
                    this.postsCache[cacheKey] = this.posts;
                } else {
                    this.posts = this.postsCache[cacheKey];
                }
                clearTimeout(timeoutId);
            } catch (error) {
                console.error('Ошибка при загрузке постов:', error);
            }
            this.postLoading = false;
        },
        newPostPublish() {
            let formData = new FormData();
            formData.append('_token', this.$page.props.csrf_token);
            formData.append('post', this.formNewPost.content);
            formData.append('section_id', this.currentSection.id);

            for(let i = 0; i < this.formNewPost.files.length; i++) {
                formData.append('files[]', this.formNewPost.files[i]);
            }

            axios
                .post(route('api.user.post.store'), formData)
                .then(() => {
                    this.postsCache = {};
                    this.getPosts(this.currentSection, 1);
                    this.formNewPost.error = false;
                })
                .catch((error) => {
                    this.formNewPost.error = error.response.data.errors;
                });
        },
        postLike(id) {
            axios.post(route('api.user.post.like', {post_id: id}), {})
                .then((response) => {
                    const post = this.posts.data.find((post) => post.id === id);
                    post.is_liked = response.data.is_liked;
                    post.like_count = response.data.like_count;
                });
        },
        formatDate(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diffInSeconds = Math.floor((now - date) / 1000);

            if (diffInSeconds < 60) {
                return this.$tc('seconds_ago', diffInSeconds);
            }

            const diffInMinutes = Math.floor(diffInSeconds / 60);
            if (diffInMinutes < 60) {
                return this.$tc('minutes_ago', diffInMinutes);
            }

            const diffInHours = Math.floor(diffInMinutes / 60);
            if (diffInHours < 24) {
                return `${this.$tc('hours_ago', diffInHours)}`;
            }

            const hours = date.getHours().toString().padStart(2, '0');
            const minutes = date.getMinutes().toString().padStart(2, '0');
            return `${this.$d(date, 'long')} ${hours}:${minutes}`;
        },
        postFileChange(event) {
            let files = event.target.files;
            let fileSizeLimit = 10 * 1024 * 1024;

            for (let i = 0; i < files.length; i++) {
                if (files[i].size > fileSizeLimit) {
                    this.$refs.fileInput.value = '';
                    return alert(this.$t('profile.post.new_post.max_file'));
                }
            }
            this.formNewPost.files = files;
        },
        formSectionEditSubmit() {
            this.formSectionEdit.post(route('api.user.edit.section.store'), {
                onFinish: () => {
                    this.formSectionEdit.reset();
                    this.isSectionEdit = false;
                    this.sections = this.$page.props.sections || [];
                    if (this.sections) {
                        this.selectSection(this.sections[0]);
                    }
                },
            });
        }
    },
}
</script>
