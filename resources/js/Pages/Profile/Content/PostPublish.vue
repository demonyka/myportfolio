<template>
    <div class="content">
        <form @submit.prevent="postPublish" v-if="isMyProfile" class="posts new-post">
            <h3 class="title">{{ $t('profile.post.new_post.title') }}</h3>
            <div>
                <input
                    placeholder="Заголовок"
                    type="text"
                    class="new-post-title"
                    style="width: calc(100% - 22px);"
                    :class="{ 'error': form.errors.title }"
                    v-model="form.title"
                    @focus="form.errors.title = null"
                >
                <transition name="fade">
                    <p class="error-message" style="text-align: left; margin-top: 4px" v-if="form.errors && form.errors.title">
                        {{ $t(form.errors.title) }}
                    </p>
                </transition>
            </div>
            <div>
                <textarea class="new-post-text"
                    placeholder="Содержимое"
                    style="width: calc(100% - 22px);"
                    :class="{ 'error': form.errors.text }"
                    v-model="form.text"
                    @focus="form.errors.text = null"
                />
                <transition name="fade">
                    <p class="error-message" style="text-align: left;" v-if="form.errors && form.errors.text">
                    {{ $t(form.errors.text) }}
                    </p>
                </transition>
            </div>
            <div>
                <input
                    type="file"
                    ref="fileInput"
                    multiple
                    :class="{ 'error': form.errors.files }"
                    @change="handleFilesChange"
                    @focus="form.errors.files = null"
                >
                <transition name="fade">
                    <p class="error-message" style="text-align: left; margin-top: 4px" v-if="form.errors && form.errors.files">
                        {{ $t(form.errors.files) }}
                    </p>
                </transition>
            </div>
            <div class="new-post-links">
                <div class="new-post-link" v-for="(link, index) in form.links" :key="index">
                    <input
                        placeholder="Ссылка"
                        type="text"
                        class="new-post-link"
                        v-model="form.links[index]"
                        :class="{ 'error': form.errors['links.' + index] }"
                        @focus="form.errors['links.' + index] = null"
                    >
                    <svg v-if="index === 0 && form.links.length < 3" @click="link_add()" class="delete" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 12H20M12 4V20" stroke="#828282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <svg v-else-if="index !== 0" @click="delete_link(index)" class="delete" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M18 6V16.2C18 17.8802 18 18.7202 17.673 19.362C17.3854 19.9265 16.9265 20.3854 16.362 20.673C15.7202 21 14.8802 21 13.2 21H10.8C9.11984 21 8.27976 21 7.63803 20.673C7.07354 20.3854 6.6146 19.9265 6.32698 19.362C6 18.7202 6 17.8802 6 16.2V6M14 10V17M10 10V17" stroke="#828282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <transition name="fade">
                    <p class="error-message" style="text-align: left;" v-if="form.errors && form.errors['links.0']">
                        {{ $t(form.errors['links.0']) }}
                    </p>
                    <p class="error-message" style="text-align: left;" v-else-if="form.errors && form.errors['links.1']">
                        {{ $t(form.errors['links.1']) }}
                    </p>
                    <p class="error-message" style="text-align: left;" v-else-if="form.errors && form.errors['links.2']">
                        {{ $t(form.errors['links.2']) }}
                    </p>
                </transition>
            </div>
            <button :disabled="form.processing" type="submit" class="primary">{{ $t('profile.post.new_post.submit') }}</button>
        </form>
        <div class="posts" v-for="post in posts.data">
            <div class="title">
                <div class="author">
                    <img alt="avatar" :src="JSON.parse(post.user.external_data).avatar_path || '/assets/images/default_avatar.png'" @onerror="$event.target.src = '/assets/images/default_avatar.png'">
                    <h4>
                        {{ JSON.parse(post.user.external_data).fullname }}
                        <svg v-if="post.user.verified" style="transform: translateY(4px);" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.5 12.5L10.0089 14.0089C10.3526 14.3526 10.5245 14.5245 10.7198 14.5822C10.8914 14.6328 11.0749 14.6245 11.2412 14.5585C11.4305 14.4834 11.5861 14.2967 11.8973 13.9232L16 9M16.3287 4.75855C17.0676 4.77963 17.8001 5.07212 18.364 5.636C18.9278 6.19989 19.2203 6.9324 19.2414 7.67121C19.2623 8.40232 19.2727 8.76787 19.2942 8.85296C19.3401 9.0351 19.2867 8.90625 19.383 9.06752C19.428 9.14286 19.6792 9.40876 20.1814 9.94045C20.6889 10.4778 21 11.2026 21 12C21 12.7974 20.6889 13.5222 20.1814 14.0595C19.6792 14.5912 19.428 14.8571 19.383 14.9325C19.2867 15.0937 19.3401 14.9649 19.2942 15.147C19.2727 15.2321 19.2623 15.5977 19.2414 16.3288C19.2203 17.0676 18.9278 17.8001 18.364 18.364C17.8001 18.9279 17.0676 19.2204 16.3287 19.2414C15.5976 19.2623 15.2321 19.2727 15.147 19.2942C14.9649 19.3401 15.0937 19.2868 14.9325 19.3831C14.8571 19.4281 14.5912 19.6792 14.0595 20.1814C13.5222 20.6889 12.7974 21 12 21C11.2026 21 10.4778 20.6889 9.94047 20.1814C9.40874 19.6792 9.14287 19.4281 9.06753 19.3831C8.90626 19.2868 9.0351 19.3401 8.85296 19.2942C8.76788 19.2727 8.40225 19.2623 7.67121 19.2414C6.93238 19.2204 6.19986 18.9279 5.63597 18.364C5.07207 17.8001 4.77959 17.0676 4.75852 16.3287C4.73766 15.5976 4.72724 15.2321 4.70578 15.147C4.65985 14.9649 4.71322 15.0937 4.61691 14.9324C4.57192 14.8571 4.32082 14.5912 3.81862 14.0595C3.31113 13.5222 3 12.7974 3 12C3 11.2026 3.31113 10.4778 3.81862 9.94048C4.32082 9.40876 4.57192 9.14289 4.61691 9.06755C4.71322 8.90628 4.65985 9.03512 4.70578 8.85299C4.72724 8.7679 4.73766 8.40235 4.75852 7.67126C4.77959 6.93243 5.07207 6.1999 5.63597 5.636C6.19986 5.07211 6.93238 4.77963 7.67121 4.75855C8.40232 4.73769 8.76788 4.72727 8.85296 4.70581C9.0351 4.65988 8.90626 4.71325 9.06753 4.61694C9.14287 4.57195 9.40876 4.32082 9.94047 3.81863C10.4778 3.31113 11.2026 3 12 3C12.7974 3 13.5222 3.31114 14.0595 3.81864C14.5913 4.32084 14.8571 4.57194 14.9325 4.61693C15.0937 4.71324 14.9649 4.65988 15.147 4.70581C15.2321 4.72726 15.5976 4.73769 16.3287 4.75855Z" stroke="var(--blue1)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </h4>
                </div>
                <p class="date">{{ formatDate(post.created_at) }}</p>
            </div>
            <h4 style="margin: 0">{{ formatPost(post).title }}</h4>
            <div class="text" v-html="postFull[post.id] ? formatPost(post).text : formatPost(post).text.substr(0, 1024)"/>
            <span class="text-full" v-if="formatPost(post).text.length > 1024 && !postFull[post.id]"  @click="postFull[post.id] = true">Читать полностью</span>
            <div v-if="post.files" class="files image">
                <div v-for="file in JSON.parse(post.files)" :key="file">
                    <img v-if="isImageFile(file)" :src="file" :alt="getFileName(file)">
                </div>
            </div>
            <div v-if="post.files || formatPost(post).links" class="files">
                <div style="display: flex" v-for="file in JSON.parse(post.files)" :key="file">
                    <a v-if="!isImageFile(file)" :href="file" target="_blank">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 9V17.8C19 18.9201 19 19.4802 18.782 19.908C18.5903 20.2843 18.2843 20.5903 17.908 20.782C17.4802 21 16.9201 21 15.8 21H8.2C7.07989 21 6.51984 21 6.09202 20.782C5.71569 20.5903 5.40973 20.2843 5.21799 19.908C5 19.4802 5 18.9201 5 17.8V6.2C5 5.07989 5 4.51984 5.21799 4.09202C5.40973 3.71569 5.71569 3.40973 6.09202 3.21799C6.51984 3 7.0799 3 8.2 3H13M19 9L13 3M19 9H14C13.4477 9 13 8.55228 13 8V3" stroke="#828282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        {{ getFileName(file) }}
                    </a>
                </div>
                <div v-if="formatPost(post).links[0] || formatPost(post).links[1] || formatPost(post).links[2]" style="display: flex" v-for="link in formatPost(post).links">
                    <a class="profile-link" target="_blank" :href="link">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.1718 14.8288L14.8287 9.17192M7.05086 11.293L5.63664 12.7072C4.07455 14.2693 4.07409 16.8022 5.63619 18.3643C7.19829 19.9264 9.7317 19.9259 11.2938 18.3638L12.7065 16.9498M11.2929 7.05L12.7071 5.63579C14.2692 4.07369 16.8016 4.07397 18.3637 5.63607C19.9258 7.19816 19.9257 9.73085 18.3636 11.2929L16.9501 12.7071" stroke="#828282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        {{ link }}
                    </a>
                </div>
            </div>
            <div class="bottom">
                <svg v-if="isMyProfile" @click="deletePost(post.id)" class="delete" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M18 6V16.2C18 17.8802 18 18.7202 17.673 19.362C17.3854 19.9265 16.9265 20.3854 16.362 20.673C15.7202 21 14.8802 21 13.2 21H10.8C9.11984 21 8.27976 21 7.63803 20.673C7.07354 20.3854 6.6146 19.9265 6.32698 19.362C6 18.7202 6 17.8802 6 16.2V6M14 10V17M10 10V17" stroke="#828282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span/>
                <div style="display: flex; align-items: center; gap: 5px">
<!--                    <svg class="share" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">-->
<!--                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1 18.5088C1 13.1679 4.90169 8.77098 9.99995 7.84598V5.51119C9.99995 3.63887 12.1534 2.58563 13.6313 3.73514L21.9742 10.224C23.1323 11.1248 23.1324 12.8752 21.9742 13.7761L13.6314 20.2649C12.1534 21.4144 10 20.3612 10 18.4888V16.5189C7.74106 16.9525 5.9625 18.1157 4.92778 19.6838C4.33222 20.5863 3.30568 20.7735 2.55965 20.5635C1.80473 20.3511 1.00011 19.6306 1 18.5088ZM12.4034 5.31385C12.2392 5.18613 11.9999 5.30315 11.9999 5.51119V9.41672C11.9999 9.55479 11.8873 9.66637 11.7493 9.67008C8.09094 9.76836 4.97774 12.0115 3.66558 15.1656C3.46812 15.6402 3.31145 16.1354 3.19984 16.6471C3.07554 17.217 3.00713 17.8072 3.00053 18.412C3.00018 18.4442 3 18.4765 3 18.5088C3.00001 18.6437 3.18418 18.6948 3.25846 18.5822C3.27467 18.5577 3.29101 18.5332 3.30747 18.5088C3.30748 18.5088 3.30746 18.5088 3.30747 18.5088C3.63446 18.0244 4.01059 17.5765 4.42994 17.168C4.71487 16.8905 5.01975 16.6313 5.34276 16.3912C7.05882 15.1158 9.28642 14.3823 11.7496 14.3357C11.8877 14.3331 12 14.4453 12 14.5834V18.4888C12 18.6969 12.2393 18.8139 12.4035 18.6862L20.7463 12.1973C20.875 12.0973 20.875 11.9028 20.7463 11.8027L12.4034 5.31385Z" fill="#828282"/>-->
<!--                    </svg>-->
                    <div class="like">
                        <svg @click="like(post.id)" :class="{ active: post.is_liked, disabled: !$page.props.auth.user }" class="like" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke="#828282" fill="transparent" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <small>{{ post.likes_count }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div v-if="posts && posts.total > posts.per_page" class="pagination">
        <div>
            <Link v-if="posts.current_page > 2" :href="getProfileURL(user)">
                ❮
            </Link>
            <a class="disactive" v-else>
                ❮
            </a>
        </div>

        <div v-for="page in generatePageArray(posts.current_page, posts.last_page)" :key="page">
            <Link :href="getProfileURL($page.props.user, page)" :style="{ 'background-color': posts.current_page === page ? 'var(--blue1)' : 'white', 'color': posts.current_page === page ? 'white' : 'black'}">
                {{ page }}
            </Link>
        </div>

        <div>
            <Link v-if="posts.last_page-posts.current_page >= 2" :href="getProfileURL($page.props.user, posts.last_page)">
                ❯
            </Link>
            <a class="disactive" v-else>
                ❯
            </a>
        </div>
    </div>
</template>

<style scoped>
    .posts.new-post {
        input[type="text"], textarea {
            padding: 5px 10px;
            outline: none;
            border: 1px solid var(--gray3);
            resize: vertical;
            max-height: 200px;
            transition: height 0s;
            border-radius: 10px;
        }
        textarea {
            padding: 10px;
            min-height: 100px;
        }
        input[type="text"]:focus, textarea:focus {
            border-color: var(--blue1);
        }
        div {
            width: 100%;
        }
        input.error, textarea.error {
            color: var(--red);
            border-color: var(--red);
        }
        button {
            scale: 1;
        }
        div.new-post-links {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        div.new-post-link {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        svg.delete {
            cursor: pointer;
        }
        svg.delete:hover path {
            stroke: var(--blue1);
        }
    }
    .files {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .files svg {
        min-width: 24px;
        min-height: 24px;
    }
    .files div a {
        color: var(--gray3);
        display: flex;
        align-items: center;
        gap: 5px;
        word-break: break-word;
    }
    .files div a span {
        word-break: break-word;
    }
    .files div a:hover {
        scale: 1;
        color: var(--blue1);
        path {
            stroke: var(--blue1);
        }
    }
    .files.image {
        display: flex;
        flex-wrap: wrap;
        flex-direction: row !important;
        gap: 10px;
    }

    .files.image img {
        max-width: 100%;
        max-height: 200px;
        object-fit: cover;
        border-radius: 10px;
    }
    .content {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    .posts {
        padding: 20px 30px;
        display: flex;
        flex-direction: column;
        gap: 15px;
        background-color: white;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        border-radius: 20px;
    }
    .posts .date {
        margin: 0;
        color: var(--gray3);
        text-align: end;
    }
    .posts .title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        margin: 0;
        font-weight: 500;
    }
    .posts .author {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .posts .author h4 {
        margin: 0;
        font-weight: 500;
        transform: translateY(-2px);
    }
    .posts .author img {
        width: 35px;
        height: 35px;
        object-fit: cover;
        border-radius: 100%;
    }
    .posts .text {
        width: 100%;
    }
    .posts .text {
        margin: 0;
        max-width: 100%;
        word-break: break-word;
    }
    .posts span.text-full {
        cursor: pointer;
        font-weight: 600;
    }
    .posts span.text-full:hover {
        color: var(--blue1);
    }
    .posts .bottom {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 5px;
    }
    .posts .bottom svg {
        cursor: pointer;
    }
    .posts .bottom svg.disabled {
        pointer-events: none;
    }
    .posts .bottom svg.delete:hover path {
        stroke: var(--gray4);
    }
    .posts .bottom svg.share:hover path {
        fill: var(--blue1);
    }
    .posts .bottom div.like {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .posts .bottom div.like small {
        color: var(--gray3);
    }
    .posts .bottom svg.like:hover path, .posts.bottom svg.like.active {
        stroke: var(--red);
    }
    .posts .bottom svg.like.active path {
        fill: var(--red);
        stroke: var(--red);
    }
</style>

<script>
import {useForm} from "@inertiajs/vue3";
import {generatePageArray, getProfileURL} from "@/scripts.js";
import {Link} from "@inertiajs/vue3";

export default {
    name: "PostPublish",
    components: {
        Link,
    },
    data() {
        return {
            postFull: {},
            isMyProfile: this.$page.props.auth.user?.id === this.$page.props.user.id,
            form: useForm({
                _token: this.$page.props.csrf_token,
                title: '',
                text: '',
                files: null,
                links: ['']
            })
        }
    },
    props: [
        'posts'
    ],
    methods: {
        getProfileURL,
        generatePageArray,
        postPublish() {
            this.form.post(route('post.store'), {
                onFinish: () => {

                },
                onSuccess: () => {
                    this.form.reset();
                    this.$refs.fileInput.value = '';
                },
            });
        },
        handleFilesChange(event) {
            let files = event.target.files;
            let fileSizeLimit = 10 * 1024 * 1024;
            for (let i = 0; i < files.length; i++) {
                if (files[i].size > fileSizeLimit) {
                    this.$refs.fileInput.value = '';
                    return this.form.errors.files = 'profile.post.new_post.max_file';
                }
            }
            this.form.files = files;
        },
        delete_link(index) {
            this.form.links.splice(index, 1);
        },
        link_add() {
            if (this.form.links.length < 3) {
                this.form.links.push('');
            }
        },
        isImageFile(fileName) {
            const extension = fileName.split('.').pop().toLowerCase();
            return extension === 'png' || extension === 'jpeg' || extension === 'jpg';
        },
        getFileName(filePath) {
            return filePath.split('/').pop();
        },
        formatPost(post) {
            return JSON.parse(post.data)
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
        like(id) {
            axios.post(route('post.like', {post_id: id}), {})
            const post = this.posts.data.find((post) => post.id === id);
            post.is_liked = !post.is_liked;
            post.is_liked ? post.likes_count += 1 : post.likes_count -= 1;
        },
        deletePost(id) {
            axios.delete(route('post.delete', {post_id: id}), {})
            this.posts.data = this.posts.data.filter((post) => post.id !== id);
        },
    }
}
</script>
