<template>
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
        <div class="labels" style="margin-right: 60px">
            <input v-for="i in 4" :key="i"
                class="input-section"
                v-model="formSectionEdit[i - 1]['name']"
                :class="{ disabled: !(i === 1 || formSectionEdit[i - 2]['name']) }"
                :readonly="!(i === 1 || formSectionEdit[i - 2]['name'])"
                :placeholder="$t('profile.edit.sections.placeholder')"
            >
        </div>
        <span @click="formSectionEditSubmit" v-if="isMyProfile" class="menu-edit">
            {{ $t('profile.edit.sections.save') }}
        </span>
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
                <img alt="avatar" :src="JSON.parse(post.author.external_data).avatar_path" @error="$event.target.src = 'http://[::1]:5173/public/assets/images/default_avatar.png'">
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
    </div>
</template>

<style scoped>
.input-section {
    border: none;
    border-bottom: 1px solid black;
    padding: 25px 0 15px;
    outline: none;
    font-size: 16px;
    text-align: center;
    width: 100%;
}
.input-section.disabled {
    opacity: 0;
    pointer-events: none;
    cursor: default;
}
.input-section:focus {
    border-color: var(--blue1);
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
.menu-desktop {
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
.menu-desktop .labels {
    display: flex;
    align-items: center;
    gap: 5%;
    width: 100%;
    position: relative;
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
@media screen and (max-width: 1400px) {
    .menu-desktop {
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
    .menu-desktop {
        display: none;
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
        },
        async getPosts(sectionId, page) {
            try {
                const cacheKey = `${sectionId}_${page}`;
                if (!this.postsCache[cacheKey]) {
                    const response = await axios.get(route('api.user.post.get', { section_id: sectionId, page: page }));
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
