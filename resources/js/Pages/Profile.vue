<template>
    <Head :title=userData.fullname />
    <Layout>
        <div class="index">
            <div class="left-side">
                <div class="profile-info">
                    <div class="avatar">
                        <img alt="avatar" :src="userData.avatar_path ?? '/storage/avatars/default.png'" @error="$event.target.src = '/storage/avatars/default.png'">
                        <h2 class="fullname">
                            <span>
                                {{ userData.fullname }}
                            </span>

                        </h2>
                        <h3 class="username" v-if="user.username">
                            @{{ user.username }}
                        </h3>
                    </div>
                    <div class="more-info">
                        <p class="param" v-if="userData.birthday">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 9H21M7 3V5M17 3V5M6 13H8M6 17H8M11 13H13M11 17H13M16 13H18M16 17H18M6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21Z" stroke="#828282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>{{ formattedDate(userData.birthday) }} ({{ $tc('years_old', getYearsOld(userData.birthday)) }})</span>
                        </p>
                        <p class="param" v-if="userData.geolocation">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 21C15.5 17.4 19 14.1764 19 10.2C19 6.22355 15.866 3 12 3C8.13401 3 5 6.22355 5 10.2C5 14.1764 8.5 17.4 12 21Z" stroke="#828282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z" stroke="#828282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>{{ userData.geolocation }}</span>
                        </p>
                        <p class="param" v-if="userData.job">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16 7V6.2C16 5.0799 16 4.51984 15.782 4.09202C15.5903 3.71569 15.2843 3.40973 14.908 3.21799C14.4802 3 13.9201 3 12.8 3H11.2C10.0799 3 9.51984 3 9.09202 3.21799C8.71569 3.40973 8.40973 3.71569 8.21799 4.09202C8 4.51984 8 5.0799 8 6.2V7M3.02721 10.0263C3.38776 10.3719 7.28572 14 12 14C16.7143 14 20.6122 10.3719 20.9728 10.0263M3.02721 10.0263C3 10.493 3 11.0665 3 11.8V16.2C3 17.8802 3 18.7202 3.32698 19.362C3.6146 19.9265 4.07354 20.3854 4.63803 20.673C5.27976 21 6.11984 21 7.8 21H16.2C17.8802 21 18.7202 21 19.362 20.673C19.9265 20.3854 20.3854 19.9265 20.673 19.362C21 18.7202 21 17.8802 21 16.2V11.8C21 11.0665 21 10.493 20.9728 10.0263M3.02721 10.0263C3.06233 9.4241 3.14276 8.99959 3.32698 8.63803C3.6146 8.07354 4.07354 7.6146 4.63803 7.32698C5.27976 7 6.11984 7 7.8 7H16.2C17.8802 7 18.7202 7 19.362 7.32698C19.9265 7.6146 20.3854 8.07354 20.673 8.63803C20.8572 8.99959 20.9377 9.4241 20.9728 10.0263" stroke="#828282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>{{ userData.job }}</span>
                        </p>
                        <p class="param" v-for="link in userData.links">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.1718 14.8288L14.8287 9.17192M7.05086 11.293L5.63664 12.7072C4.07455 14.2693 4.07409 16.8022 5.63619 18.3643C7.19829 19.9264 9.7317 19.9259 11.2938 18.3638L12.7065 16.9498M11.2929 7.05L12.7071 5.63579C14.2692 4.07369 16.8016 4.07397 18.3637 5.63607C19.9258 7.19816 19.9257 9.73085 18.3636 11.2929L16.9501 12.7071" stroke="#828282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <a class="profile-link" target="_blank" :href="link">{{ link }}</a>
                        </p>
                    </div>
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
        width: 25%;
    }
    .profile-info {
        padding: 20px 30px;
        background-color: white;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        border-radius: 20px;
    }
    .profile-info .more-info {
        width: 100%;
    }
    .profile-info .more-info p.param {
        display: flex;
        align-items: center;
        gap: 5px;
        color: var(--gray3);
        word-break: break-word;
    }
    .profile-info .more-info p.param svg {
        min-width: 24px;
        min-height: 24px;
    }
    a.profile-link {
        color: var(--gray3);
        text-decoration: underline;
        word-break: break-word;
    }
    a.profile-link:hover {
        scale: 1;

    }
    .profile-info .avatar {
        width: 100%;
        text-align: center;
    }
    .profile-info .avatar img {
        border-radius: 100px;
        width: 175px;
        height: 175px;
        object-fit: cover;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.25);
        user-select: none;
    }
    .profile-info .avatar h2.fullname {
        font-weight: 500;
        margin: 15px 0 0;
    }
    .profile-info .avatar h3.username {
        font-weight: 400;
        margin: 0;
        font-size: 14px;
    }
    @media screen and (max-width: 1000px) {
        .left-side {
            width: 100%;
        }
    }
    @media screen and (max-width: 1400px) {
        .profile-info .avatar img {
            width: 125px;
            height: 125px;
        }
        .profile-info .avatar h2.fullname {
            font-size: 20px;
        }
        .profile-info .avatar h3.username {
            font-size: 12px;
        }
        .profile-info .more-info p.param {
            font-size: 12px;
        }
        .profile-info .more-info p.param svg {
            min-width: 18px;
            min-height: 18px;
            width: 18px;
            height: 18px;
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
    },
    data() {
        return {
            isMyProfile: this.$page.props.auth.user?.id === this.user.id,
            userData: JSON.parse(this.user.external_data)
        };
    },
    props: [
        'user'
    ],
    methods: {
        getYearsOld(date) {
            const birthday = new Date(date);
            const currentDate = new Date();

            let age = currentDate.getFullYear() - birthday.getFullYear();
            const monthDiff = currentDate.getMonth() - birthday.getMonth();

            if (monthDiff < 0 || (monthDiff === 0 && currentDate.getDate() < birthday.getDate())) {
                age--;
            }

            return age;
        },
        formattedDate(date) {
            // Предположим, что у вас есть переменная с датой
            const formattedDate = new Date(date);
            // Используйте метод `$d` из i18n для форматирования даты
            return this.$d(formattedDate, 'long');
        }
    }
}
</script>
