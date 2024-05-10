<template>
    <div class="profile-info">
        <div class="avatar">
            <img alt="avatar" :src="userData.avatar_path || '/assets/images/default_avatar.png'" @onerror="$event.target.src = '/assets/images/default_avatar.png'">
            <h2 class="fullname">
                <span>
                    {{ userData.fullname }}
                </span>
                <svg v-if="user.verified" style="transform: translateY(4px); margin-left: 5px" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.5 12.5L10.0089 14.0089C10.3526 14.3526 10.5245 14.5245 10.7198 14.5822C10.8914 14.6328 11.0749 14.6245 11.2412 14.5585C11.4305 14.4834 11.5861 14.2967 11.8973 13.9232L16 9M16.3287 4.75855C17.0676 4.77963 17.8001 5.07212 18.364 5.636C18.9278 6.19989 19.2203 6.9324 19.2414 7.67121C19.2623 8.40232 19.2727 8.76787 19.2942 8.85296C19.3401 9.0351 19.2867 8.90625 19.383 9.06752C19.428 9.14286 19.6792 9.40876 20.1814 9.94045C20.6889 10.4778 21 11.2026 21 12C21 12.7974 20.6889 13.5222 20.1814 14.0595C19.6792 14.5912 19.428 14.8571 19.383 14.9325C19.2867 15.0937 19.3401 14.9649 19.2942 15.147C19.2727 15.2321 19.2623 15.5977 19.2414 16.3288C19.2203 17.0676 18.9278 17.8001 18.364 18.364C17.8001 18.9279 17.0676 19.2204 16.3287 19.2414C15.5976 19.2623 15.2321 19.2727 15.147 19.2942C14.9649 19.3401 15.0937 19.2868 14.9325 19.3831C14.8571 19.4281 14.5912 19.6792 14.0595 20.1814C13.5222 20.6889 12.7974 21 12 21C11.2026 21 10.4778 20.6889 9.94047 20.1814C9.40874 19.6792 9.14287 19.4281 9.06753 19.3831C8.90626 19.2868 9.0351 19.3401 8.85296 19.2942C8.76788 19.2727 8.40225 19.2623 7.67121 19.2414C6.93238 19.2204 6.19986 18.9279 5.63597 18.364C5.07207 17.8001 4.77959 17.0676 4.75852 16.3287C4.73766 15.5976 4.72724 15.2321 4.70578 15.147C4.65985 14.9649 4.71322 15.0937 4.61691 14.9324C4.57192 14.8571 4.32082 14.5912 3.81862 14.0595C3.31113 13.5222 3 12.7974 3 12C3 11.2026 3.31113 10.4778 3.81862 9.94048C4.32082 9.40876 4.57192 9.14289 4.61691 9.06755C4.71322 8.90628 4.65985 9.03512 4.70578 8.85299C4.72724 8.7679 4.73766 8.40235 4.75852 7.67126C4.77959 6.93243 5.07207 6.1999 5.63597 5.636C6.19986 5.07211 6.93238 4.77963 7.67121 4.75855C8.40232 4.73769 8.76788 4.72727 8.85296 4.70581C9.0351 4.65988 8.90626 4.71325 9.06753 4.61694C9.14287 4.57195 9.40876 4.32082 9.94047 3.81863C10.4778 3.31113 11.2026 3 12 3C12.7974 3 13.5222 3.31114 14.0595 3.81864C14.5913 4.32084 14.8571 4.57194 14.9325 4.61693C15.0937 4.71324 14.9649 4.65988 15.147 4.70581C15.2321 4.72726 15.5976 4.73769 16.3287 4.75855Z" stroke="var(--blue1)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </h2>
            <h3 id="username" class="username" v-if="user.username" @click="copyUsername">
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
            <p class="param">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 7.00005L10.2 11.65C11.2667 12.45 12.7333 12.45 13.8 11.65L20 7" stroke="#828282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <rect x="3" y="5" width="18" height="14" rx="2" stroke="#828282" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <span>{{ user.email }}</span>
            </p>
            <p class="param" v-if="userData.city || userData.citizen">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 21C15.5 17.4 19 14.1764 19 10.2C19 6.22355 15.866 3 12 3C8.13401 3 5 6.22355 5 10.2C5 14.1764 8.5 17.4 12 21Z" stroke="#828282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z" stroke="#828282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>
                    <span v-if="userData.city">{{ userData.city }}</span>
                    <br v-if="userData.citizen && userData.city"><span v-if="userData.citizen">Гражданство: {{ userData.citizen }}</span>
                </span>

            </p>
            <div v-if="userData.jobs[0].name || userData.jobs[0].jobtitle">
                <p style="margin-bottom: 5px" class="param">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 7V6.2C16 5.0799 16 4.51984 15.782 4.09202C15.5903 3.71569 15.2843 3.40973 14.908 3.21799C14.4802 3 13.9201 3 12.8 3H11.2C10.0799 3 9.51984 3 9.09202 3.21799C8.71569 3.40973 8.40973 3.71569 8.21799 4.09202C8 4.51984 8 5.0799 8 6.2V7M3.02721 10.0263C3.38776 10.3719 7.28572 14 12 14C16.7143 14 20.6122 10.3719 20.9728 10.0263M3.02721 10.0263C3 10.493 3 11.0665 3 11.8V16.2C3 17.8802 3 18.7202 3.32698 19.362C3.6146 19.9265 4.07354 20.3854 4.63803 20.673C5.27976 21 6.11984 21 7.8 21H16.2C17.8802 21 18.7202 21 19.362 20.673C19.9265 20.3854 20.3854 19.9265 20.673 19.362C21 18.7202 21 17.8802 21 16.2V11.8C21 11.0665 21 10.493 20.9728 10.0263M3.02721 10.0263C3.06233 9.4241 3.14276 8.99959 3.32698 8.63803C3.6146 8.07354 4.07354 7.6146 4.63803 7.32698C5.27976 7 6.11984 7 7.8 7H16.2C17.8802 7 18.7202 7 19.362 7.32698C19.9265 7.6146 20.3854 8.07354 20.673 8.63803C20.8572 8.99959 20.9377 9.4241 20.9728 10.0263" stroke="#828282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Опыт работы</span>
                </p>
                <ul class="param" v-if="userData.jobs">
                    <li v-for="job in userData.jobs">{{ job.name }} ({{ formattedDate(job.start_at) || 'не указано' }} - {{ formattedDate(job.end_at) || 'н.в.' }}) {{ job.jobtitle ? ' | ' + job.jobtitle : '' }}</li>
                </ul>
            </div>
            <p class="param" v-if="userData.github">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.0744 2.9938C4.13263 1.96371 4.37869 1.51577 5.08432 1.15606C5.84357 0.768899 7.04106 0.949072 8.45014 1.66261C9.05706 1.97009 9.11886 1.97635 10.1825 1.83998C11.5963 1.65865 13.4164 1.65929 14.7213 1.84164C15.7081 1.97954 15.7729 1.97265 16.3813 1.66453C18.3814 0.651679 19.9605 0.71795 20.5323 1.8387C20.8177 2.39812 20.8707 3.84971 20.6494 5.04695C20.5267 5.71069 20.5397 5.79356 20.8353 6.22912C22.915 9.29385 21.4165 14.2616 17.8528 16.1155C17.5801 16.2574 17.3503 16.3452 17.163 16.4167C16.5879 16.6363 16.4133 16.703 16.6247 17.7138C16.7265 18.2 16.8491 19.4088 16.8973 20.4002C16.9844 22.1922 16.9831 22.2047 16.6688 22.5703C16.241 23.0676 15.6244 23.076 15.2066 22.5902C14.9341 22.2734 14.9075 22.1238 14.9075 20.9015C14.9075 19.0952 14.7095 17.8946 14.2417 16.8658C13.6854 15.6415 14.0978 15.185 15.37 14.9114C17.1383 14.531 18.5194 13.4397 19.2892 11.8146C20.0211 10.2698 20.1314 8.13501 18.8082 6.83668C18.4319 6.3895 18.4057 5.98446 18.6744 4.76309C18.7748 4.3066 18.859 3.71768 18.8615 3.45425C18.8653 3.03823 18.8274 2.97541 18.5719 2.97541C18.4102 2.97541 17.7924 3.21062 17.1992 3.49805L16.2524 3.95695C16.1663 3.99866 16.07 4.0147 15.975 4.0038C13.5675 3.72746 11.2799 3.72319 8.86062 4.00488C8.76526 4.01598 8.66853 3.99994 8.58215 3.95802L7.63585 3.49882C7.04259 3.21087 6.42482 2.97541 6.26317 2.97541C5.88941 2.97541 5.88379 3.25135 6.22447 4.89078C6.43258 5.89203 6.57262 6.11513 5.97101 6.91572C5.06925 8.11576 4.844 9.60592 5.32757 11.1716C5.93704 13.1446 7.4295 14.4775 9.52773 14.9222C10.7926 15.1903 11.1232 15.5401 10.6402 16.9905C10.26 18.1319 10.0196 18.4261 9.46707 18.4261C8.72365 18.4261 8.25796 17.7821 8.51424 17.1082C8.62712 16.8112 8.59354 16.7795 7.89711 16.5255C5.77117 15.7504 4.14514 14.0131 3.40172 11.7223C2.82711 9.95184 3.07994 7.64739 4.00175 6.25453C4.31561 5.78028 4.32047 5.74006 4.174 4.83217C4.09113 4.31822 4.04631 3.49103 4.0744 2.9938Z" fill="#828282"/>
                    <path d="M3.33203 15.9454C3.02568 15.4859 2.40481 15.3617 1.94528 15.6681C1.48576 15.9744 1.36158 16.5953 1.66793 17.0548C1.8941 17.3941 2.16467 17.6728 2.39444 17.9025C2.4368 17.9449 2.47796 17.9858 2.51815 18.0257C2.71062 18.2169 2.88056 18.3857 3.05124 18.5861C3.42875 19.0292 3.80536 19.626 4.0194 20.6962C4.11474 21.1729 4.45739 21.4297 4.64725 21.5419C4.85315 21.6635 5.07812 21.7352 5.26325 21.7819C5.64196 21.8774 6.10169 21.927 6.53799 21.9559C7.01695 21.9877 7.53592 21.998 7.99999 22.0008C8.00033 22.5527 8.44791 23.0001 8.99998 23.0001C9.55227 23.0001 9.99998 22.5524 9.99998 22.0001V21.0001C9.99998 20.4478 9.55227 20.0001 8.99998 20.0001C8.90571 20.0001 8.80372 20.0004 8.69569 20.0008C8.10883 20.0026 7.34388 20.0049 6.67018 19.9603C6.34531 19.9388 6.07825 19.9083 5.88241 19.871C5.58083 18.6871 5.09362 17.8994 4.57373 17.2891C4.34391 17.0194 4.10593 16.7834 3.91236 16.5914C3.87612 16.5555 3.84144 16.5211 3.80865 16.4883C3.5853 16.265 3.4392 16.1062 3.33203 15.9454Z" fill="#828282"/>
                </svg>
                <a class="profile-link" target="_blank" :href="`https://github.com/${userData.github}`">{{ `https://github.com/${userData.github}` }}</a>
            </p>
            <div v-for="link in userData.links">
                <p class="param" v-if="link">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.1718 14.8288L14.8287 9.17192M7.05086 11.293L5.63664 12.7072C4.07455 14.2693 4.07409 16.8022 5.63619 18.3643C7.19829 19.9264 9.7317 19.9259 11.2938 18.3638L12.7065 16.9498M11.2929 7.05L12.7071 5.63579C14.2692 4.07369 16.8016 4.07397 18.3637 5.63607C19.9258 7.19816 19.9257 9.73085 18.3636 11.2929L16.9501 12.7071" stroke="#828282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <a class="profile-link" target="_blank" :href="link">{{ link }}</a>
                </p>
            </div>

            <div v-if="isMyProfile" class="edit-button" style="margin-top: 10px">
                <button :disabled="isEdit" @click="$emit('edit-clicked')" class="secondary">{{ $t('profile.edit.edit') }}</button>
            </div>
        </div>
    </div>
</template>

<style scoped>
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
ul.param {
    margin: 0;
    font-size: 14px;
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
    cursor: pointer;
}
.profile-info .avatar h3.username:hover {
    opacity: .8;
}
.profile-info .avatar h3.username:active {
    color: var(--blue1);
}
.edit-button {
    width: 100%;
    display: flex;
    align-items: center;
    flex-direction: column;
    gap: 10px;
}
.edit-button button {
    width: 100%;
}
@media screen and (max-width: 1400px) {
    .profile-info .avatar img {
        width: 125px;
        height: 125px;
    }
    .profile-info .avatar h2.fullname {
        font-size: 22px;
    }
    .profile-info .avatar h3.username {
        font-size: 14px;
    }
    .profile-info .more-info .param {
        font-size: 14px;
    }
    .profile-info .more-info .param svg {
        min-width: 18px;
        min-height: 18px;
        width: 18px;
        height: 18px;
    }
}
</style>

<script>
import {getProfileURL} from "@/scripts.js";

export default {
    name: "UserCard",
    data() {
        return {
            isMyProfile: this.$page.props.auth.user?.id === this.user.id,
        };
    },
    props: [
        'isEdit',
        'user',
        'userData'
    ],
    methods: {
        getProfileURL,
        copyUsername() {
            const text = this.getProfileURL(this.user);
            navigator.clipboard.writeText(text)
                .then(() => {
                    const usernameElement = document.getElementById('username');
                    if (usernameElement) {
                        usernameElement.style.color = 'var(--blue1)';
                        setTimeout(() => {
                            usernameElement.style.color = 'var(--black)';
                        }, 5000);
                    }
                });
        },
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
            const formattedDate = new Date(date);
            return this.$d(formattedDate, 'long');
        },
    }
}
</script>
