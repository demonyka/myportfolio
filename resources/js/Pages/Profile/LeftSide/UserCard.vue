<template>
    <div class="profile-info">
        <div class="avatar">
            <img alt="avatar" :src="userData.avatar_path || 'http://[::1]:5173/public/assets/images/default_avatar.png'" @onerror="$event.target.src = 'http://[::1]:5173/public/assets/images/default_avatar.png'">
            <h2 class="fullname">
                <span>
                    {{ userData.fullname }}
                </span>
            </h2>
            <h3 id="username" class="username" v-if="user.username" @click="copyUsername">
                @{{ user.username }}
            </h3>
        </div>

        <div v-if="!isProfileEdit" class="more-info">
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

            <div class="edit-button">
                <button @click="isProfileEdit = true" v-if="isMyProfile" class="secondary">{{ $t('profile.edit.edit') }}</button>
            </div>
        </div>

        <!-- profile edit -->

        <form @submit.prevent="editProfileSubmit()" v-else class="more-info">
            <div class="param-input">
                <p class="param">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.5 14C16.2164 12.8589 14.981 12 13.5 12C12.019 12 10.7836 12.8589 10.5 14M13.5 8H13.51M18 21H10.2C7.67976 21 6.41965 21 5.45704 20.5095C4.61031 20.0781 3.9219 19.3897 3.49047 18.543C3 17.5804 3 16.3202 3 13.8V6M9.2 18H17.8C18.9201 18 19.4802 18 19.908 17.782C20.2843 17.5903 20.5903 17.2843 20.782 16.908C21 16.4802 21 15.9201 21 14.8V6.2C21 5.0799 21 4.51984 20.782 4.09202C20.5903 3.71569 20.2843 3.40973 19.908 3.21799C19.4802 3 18.9201 3 17.8 3H9.2C8.0799 3 7.51984 3 7.09202 3.21799C6.71569 3.40973 6.40973 3.71569 6.21799 4.09202C6 4.51984 6 5.07989 6 6.2V14.8C6 15.9201 6 16.4802 6.21799 16.908C6.40973 17.2843 6.71569 17.5903 7.09202 17.782C7.51984 18 8.0799 18 9.2 18ZM14.5 8C14.5 8.55228 14.0523 9 13.5 9C12.9477 9 12.5 8.55228 12.5 8C12.5 7.44772 12.9477 7 13.5 7C14.0523 7 14.5 7.44772 14.5 8Z" stroke="#828282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <input
                        :placeholder="$t('profile.avatar')"
                        type="file"
                        accept="image/png, image/jpeg"
                        :class="{ 'error': formProfileEdit.errors.avatar }"
                        @change="handleAvatarChange"
                    >
                </p>
                <transition name="fade">
                    <p class="error-message" v-if="formProfileEdit.errors.avatar">{{ $t(formProfileEdit.errors.avatar) }}</p>
                </transition>
            </div>

            <div class="param-input">
                <p class="param">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.5 21H4C4 17.134 7.13401 14 11 14C11.1681 14 11.3348 14.0059 11.5 14.0176M15 7C15 9.20914 13.2091 11 11 11C8.79086 11 7 9.20914 7 7C7 4.79086 8.79086 3 11 3C13.2091 3 15 4.79086 15 7ZM12.5898 21L14.6148 20.595C14.7914 20.5597 14.8797 20.542 14.962 20.5097C15.0351 20.4811 15.1045 20.4439 15.1689 20.399C15.2414 20.3484 15.3051 20.2848 15.4324 20.1574L19.5898 16C20.1421 15.4477 20.1421 14.5523 19.5898 14C19.0376 13.4477 18.1421 13.4477 17.5898 14L13.4324 18.1574C13.3051 18.2848 13.2414 18.3484 13.1908 18.421C13.1459 18.4853 13.1088 18.5548 13.0801 18.6279C13.0478 18.7102 13.0302 18.7985 12.9948 18.975L12.5898 21Z" stroke="#828282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <input
                        :placeholder="$t('profile.fullname')"
                        type="text"
                        v-model="formProfileEdit.fullname"
                        :class="{ 'error': formProfileEdit.errors.fullname }"
                        @focus="formProfileEdit.errors.fullname = null"
                    >
                </p>
                <transition name="fade">
                    <p class="error-message" v-if="formProfileEdit.errors.fullname">{{ $t(formProfileEdit.errors.fullname) }}</p>
                </transition>
            </div>

            <div v-if="user.verified" class="param-input">
                <p class="param">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.4009 19.2C15.8965 20.3302 14.0265 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12V13.5C21 14.8807 19.8807 16 18.5 16C17.1193 16 16 14.8807 16 13.5V8M16 12C16 14.2091 14.2091 16 12 16C9.79086 16 8 14.2091 8 12C8 9.79086 9.79086 8 12 8C14.2091 8 16 9.79086 16 12Z" stroke="#828282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <input
                        :placeholder="$t('profile.username')"
                        type="text"
                        v-model="formProfileEdit.username"
                        :class="{ 'error': formProfileEdit.errors.username }"
                        @focus="formProfileEdit.errors.username = null"
                    >
                </p>
                <transition name="fade">
                    <p class="error-message" v-if="formProfileEdit.errors.username">{{ $t(formProfileEdit.errors.username) }}</p>
                </transition>
            </div>

            <div class="param-input">
                <p class="param">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 9H21M7 3V5M17 3V5M6 13H8M6 17H8M11 13H13M11 17H13M16 13H18M16 17H18M6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21Z" stroke="#828282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <input
                        :placeholder="$t('profile.birthday') + ' (YYYY-MM-DD)'"
                        type="text"
                        v-model="formProfileEdit.birthday"
                        :class="{ 'error': formProfileEdit.errors.birthday }"
                        @focus="formProfileEdit.errors.birthday = null"
                    >
                </p>
                <transition name="fade">
                    <p class="error-message"  v-if="formProfileEdit.errors.birthday">{{ $t(formProfileEdit.errors.birthday) }}</p>
                </transition>
            </div>

            <div class="param-input">
                <p class="param">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 21C15.5 17.4 19 14.1764 19 10.2C19 6.22355 15.866 3 12 3C8.13401 3 5 6.22355 5 10.2C5 14.1764 8.5 17.4 12 21Z" stroke="#828282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z" stroke="#828282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <input
                        :placeholder="$t('profile.geolocation')"
                        type="text"
                        v-model="formProfileEdit.geolocation"
                        :class="{ 'error': formProfileEdit.errors.geolocation }"
                        @focus="formProfileEdit.errors.geolocation = null"
                    >
                </p>
                <transition name="fade">
                    <p class="error-message" v-if="formProfileEdit.errors.geolocation">{{ $t(formProfileEdit.errors.geolocation) }}</p>
                </transition>
            </div>

            <div class="param-input">
                <p class="param">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 7V6.2C16 5.0799 16 4.51984 15.782 4.09202C15.5903 3.71569 15.2843 3.40973 14.908 3.21799C14.4802 3 13.9201 3 12.8 3H11.2C10.0799 3 9.51984 3 9.09202 3.21799C8.71569 3.40973 8.40973 3.71569 8.21799 4.09202C8 4.51984 8 5.0799 8 6.2V7M3.02721 10.0263C3.38776 10.3719 7.28572 14 12 14C16.7143 14 20.6122 10.3719 20.9728 10.0263M3.02721 10.0263C3 10.493 3 11.0665 3 11.8V16.2C3 17.8802 3 18.7202 3.32698 19.362C3.6146 19.9265 4.07354 20.3854 4.63803 20.673C5.27976 21 6.11984 21 7.8 21H16.2C17.8802 21 18.7202 21 19.362 20.673C19.9265 20.3854 20.3854 19.9265 20.673 19.362C21 18.7202 21 17.8802 21 16.2V11.8C21 11.0665 21 10.493 20.9728 10.0263M3.02721 10.0263C3.06233 9.4241 3.14276 8.99959 3.32698 8.63803C3.6146 8.07354 4.07354 7.6146 4.63803 7.32698C5.27976 7 6.11984 7 7.8 7H16.2C17.8802 7 18.7202 7 19.362 7.32698C19.9265 7.6146 20.3854 8.07354 20.673 8.63803C20.8572 8.99959 20.9377 9.4241 20.9728 10.0263" stroke="#828282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <input
                        :placeholder="$t('profile.job')"
                        type="text"
                        v-model="formProfileEdit.job"
                        :class="{ 'error': formProfileEdit.errors.job }"
                        @focus="formProfileEdit.errors.job = null"
                    >
                </p>
                <transition name="fade">
                    <p class="error-message" v-if="formProfileEdit.errors.job">{{ $t(formProfileEdit.errors.job) }}</p>
                </transition>
            </div>

            <div class="param-input" v-for="(link, index) in formProfileEdit.links">
                <p class="param">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.1718 14.8288L14.8287 9.17192M7.05086 11.293L5.63664 12.7072C4.07455 14.2693 4.07409 16.8022 5.63619 18.3643C7.19829 19.9264 9.7317 19.9259 11.2938 18.3638L12.7065 16.9498M11.2929 7.05L12.7071 5.63579C14.2692 4.07369 16.8016 4.07397 18.3637 5.63607C19.9258 7.19816 19.9257 9.73085 18.3636 11.2929L16.9501 12.7071" stroke="#828282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <input
                        :placeholder="$t('profile.link')"
                        type="text"
                        v-model="formProfileEdit.links[index]"
                        :class="{ 'error': formProfileEdit.errors && formProfileEdit.errors['links.' + index] }"
                        @focus="formProfileEdit.errors.links = null"
                        @blur="setURLMask(index)"
                    >
                </p>
                <transition name="fade">
                    <p class="error-message" v-if="formProfileEdit.errors && formProfileEdit.errors['links.' + index]">
                        {{ $t(formProfileEdit.errors['links.' + index]) }}
                    </p>
                </transition>
            </div>


            <div class="edit-button">
                <button type="submit" v-if="isMyProfile" class="secondary">{{ $t('profile.edit.submit') }}</button>
                <a v-if="isMyProfile" @click="closeEditProfile" class="cancel-button">{{ $t('profile.edit.cancel') }}</a>
            </div>
        </form>
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
form.more-info input[type="text"] {
    border: solid 1px var(--gray4);
    padding: 5px 10px;
    width: 100%;
    border-radius: 10px;
    outline: none;
}
form.more-info input[type="text"]:focus {
    border: solid 1px var(--blue1);
}
form.more-info div.param-input {
    margin: 16px 0;
    display: flex;
    flex-direction: column;
}
form.more-info div.param-input p {
    margin: 0;
}
form.more-info div.param-input p.error-message {
    margin-top: 5px;
    font-size: 12px;
    width: calc(100% - 24px);
    align-self: flex-end;
    text-align: end;
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
import {useForm} from "@inertiajs/vue3";
import {getProfileURL} from "@/scripts.js";

export default {
    name: "UserCard",
    data() {
        return {
            user: this.$page.props.user,
            isMyProfile: this.$page.props.auth.user?.id === this.$page.props.user.id,
            userData: JSON.parse(this.$page.props.user.external_data),
            isProfileEdit: false,
            formProfileEdit: useForm({
                _token: this.$page.props.csrf_token,
                avatar: null,
                fullname: JSON.parse(this.$page.props.user.external_data).fullname,
                username: this.$page.props.user.username ?? '',
                birthday: JSON.parse(this.$page.props.user.external_data).birthday ?? '',
                geolocation: JSON.parse(this.$page.props.user.external_data).geolocation ?? '',
                job: JSON.parse(this.$page.props.user.external_data).job ?? '',
                links: JSON.parse(this.$page.props.user.external_data).links ?? [null, null, null],
            }),
        };
    },
    props: [

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
        handleAvatarChange(event) {
            const file = event.target.files[0];
            if (file.size > 10 * 1024 * 1024) {
                this.formProfileEdit.errors.avatar = "validation.avatar.max_file";
                return;
            }

            this.formProfileEdit.avatar = file;
        },
        editProfileSubmit() {
            this.formProfileEdit.post(route('api.user.edit.store'), {
                onFinish: () => {

                },
                onSuccess: (response) => {
                    this.isProfileEdit = false;
                    this.user = response.props.user;
                    this.userData = JSON.parse(response.props.user.external_data);
                }
            });
        },
        closeEditProfile() {
            this.isProfileEdit = false;
            this.formProfileEdit = useForm({
                _token: this.$page.props.csrf_token,
                avatar: null,
                fullname: this.userData.fullname,
                username: this.user.username ?? '',
                birthday: this.userData.birthday ?? '',
                geolocation: this.userData.geolocation ?? '',
                job: this.userData.job ?? '',
                links: this.userData.links ?? [null, null, null],
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
        setURLMask(index) {
            const url = this.formProfileEdit.links[index].trim();
            if (url && !/^https?:\/\//i.test(url)) {
                this.formProfileEdit.links[index] = "https://" + url;
            }
        }
    }
}
</script>
