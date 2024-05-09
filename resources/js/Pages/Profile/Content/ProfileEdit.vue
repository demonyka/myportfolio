<template>
    <div class="profile-edit">
        <div class="profile-edit-content">
            <h3 class="title">
                Редактирование профиля
                <svg @click="$emit('cancel-clicked')" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.99486 7.00636C6.60433 7.39689 6.60433 8.03005 6.99486 8.42058L10.58 12.0057L6.99486 15.5909C6.60433 15.9814 6.60433 16.6146 6.99486 17.0051C7.38538 17.3956 8.01855 17.3956 8.40907 17.0051L11.9942 13.4199L15.5794 17.0051C15.9699 17.3956 16.6031 17.3956 16.9936 17.0051C17.3841 16.6146 17.3841 15.9814 16.9936 15.5909L13.4084 12.0057L16.9936 8.42059C17.3841 8.03007 17.3841 7.3969 16.9936 7.00638C16.603 6.61585 15.9699 6.61585 15.5794 7.00638L11.9942 10.5915L8.40907 7.00636C8.01855 6.61584 7.38538 6.61584 6.99486 7.00636Z" fill="#0F0F0F"/>
                </svg>
            </h3>
            <form>
                <div class="param-input">
                    <label>Полное имя</label>
                    <input
                        v-model="form.fullname"
                        :placeholder="'Иванов Иван Иванович'"
                        >
                </div>
                <div class="param-input">
                    <label>Дата рождения</label>
                    <input
                        v-model="form.birthday"
                        :placeholder="'YYYY-MM-DD'"
                    >
                </div>
                <div class="param-input">
                    <label>Номер телефона</label>
                    <input
                        v-model="form.phone"
                        :placeholder="'+79393328336'"
                    >
                </div>
                <div class="param-input">
                    <label>Гражданство</label>
                    <input
                        v-model="form.citizen"
                        :placeholder="'Страна'"
                    >
                </div>
                <div class="param-input">
                    <label>Место жительства</label>
                    <input
                        v-model="form.city"
                        :placeholder="'Город'"
                    >
                </div>
                <div class="param-input">
                    <label>Опыт работы</label>
                    <div v-for="(job, index) in form.jobs" style="margin-bottom: 10px">
                        <div style="display: flex; align-items: center; gap: 10px">
                            <input
                                v-model="job.name"
                                :placeholder="'Компания'"
                            >
                            <input
                                v-model="job.start_at"
                                style="width: 40%"
                                :placeholder="'Дата приёма'"
                            >

                            <svg v-if="index === form.jobs.length - 1 && form.jobs.length < 10" @click="job_add" class="delete" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 12H20M12 4V20" stroke="#828282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span style="width: 24px; height: 24px" v-else/>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px; margin-top: 5px">
                            <input
                                v-model="job.jobtitle"
                                :placeholder="'Должность'"
                            >
                            <input
                                v-model="job.end_at"
                                style="width: 40%"
                                :placeholder="'Дата ухода'"
                            >
                            <svg v-if="index !== 0" @click="delete_job(index)" class="delete" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M18 6V16.2C18 17.8802 18 18.7202 17.673 19.362C17.3854 19.9265 16.9265 20.3854 16.362 20.673C15.7202 21 14.8802 21 13.2 21H10.8C9.11984 21 8.27976 21 7.63803 20.673C7.07354 20.3854 6.6146 19.9265 6.32698 19.362C6 18.7202 6 17.8802 6 16.2V6M14 10V17M10 10V17" stroke="#828282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span style="width: 24px; height: 24px" v-else/>
                        </div>
                    </div>
                </div>

                <div class="param-input">
                    <label>Образование</label>
                    <div v-for="(edu, index) in form.education" style="margin-bottom: 10px">
                        <div style="display: flex; align-items: center; gap: 10px">
                            <input
                                v-model="edu.name"
                                :placeholder="'Учебное заведение'"
                            >
                            <input
                                v-model="edu.start_at"
                                style="width: 40%"
                                :placeholder="'Дата приёма'"
                            >

                            <svg v-if="index === form.education.length - 1 && form.education.length < 10" @click="edu_add" class="delete" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 12H20M12 4V20" stroke="#828282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span style="width: 24px; height: 24px" v-else/>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px; margin-top: 5px">
                            <input
                                v-model="edu.degree"
                                :placeholder="'Степень'"
                            >
                            <input
                                v-model="edu.end_at"
                                style="width: 40%"
                                :placeholder="'Дата ухода'"
                            >
                            <svg v-if="index !== 0" @click="delete_edu(index)" class="delete" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M18 6V16.2C18 17.8802 18 18.7202 17.673 19.362C17.3854 19.9265 16.9265 20.3854 16.362 20.673C15.7202 21 14.8802 21 13.2 21H10.8C9.11984 21 8.27976 21 7.63803 20.673C7.07354 20.3854 6.6146 19.9265 6.32698 19.362C6 18.7202 6 17.8802 6 16.2V6M14 10V17M10 10V17" stroke="#828282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span style="width: 24px; height: 24px" v-else/>
                        </div>
                    </div>
                </div>
                <div class="param-input">
                    <label>О себе</label>
                    <textarea
                        v-model="form.about"
                        :placeholder="'Расскажите немного о себе'"
                    />
                </div>
                <button type="submit" class="primary">
                    Сохранить
                </button>
            </form>
        </div>
    </div>
</template>

<style scoped>
    .profile-edit {
        width: 100%;
        background-color: white;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        border-radius: 20px;
    }
    .profile-edit-content {
        padding: 20px 30px;
    }
    .profile-edit-content .title {
        font-weight: 500;
        margin: 0;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .profile-edit-content .title svg {
        cursor: pointer;
    }
    .profile-edit-content .title svg:hover {
        opacity: .7;
    }
    form {
        margin-top: 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    form .param-input {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    .param-input label {
        font-size: 14px;
    }
    .param-input input, .param-input textarea {
        padding: 5px 10px;
        border: 1px solid var(--gray3);
        border-radius: 10px;
        width: 50%;
        outline: none;
    }
    .param-input input:focus, .param-input textarea:focus {
        border-color: var(--blue1);
    }
    .param-input textarea {
        resize: vertical;
        width: auto !important;
        transition: none;
        min-height: 75px;
        max-height: 300px;
    }
    svg.delete {
        cursor: pointer;
    }
    svg.delete:hover path {
        stroke: var(--blue1);
    }
    form button.primary:focus {
        scale: 1 !important;
    }
</style>

<script>
import {Head, Link, useForm} from "@inertiajs/vue3";
import '@/../css/vue-quill.css';

export default {
    name: "ProfileEdit",
    components: {
        Head,
        Link,
    },
    data() {
        return {
            isMyProfile: this.$page.props.auth.user?.id === this.$page.props.user.id,
            form: useForm({
                fullname: JSON.parse(this.$page.props.auth.user.external_data).fullname,
                birthday: JSON.parse(this.$page.props.auth.user.external_data).birthday,
                phone: JSON.parse(this.$page.props.auth.user.external_data).phone,
                citizen: JSON.parse(this.$page.props.auth.user.external_data).citizen,
                city: JSON.parse(this.$page.props.auth.user.external_data).city,
                about: JSON.parse(this.$page.props.auth.user.external_data).about,
                jobs: JSON.parse(this.$page.props.auth.user.external_data).jobs || [
                    {
                        'name': '',
                        'jobtitle': '',
                        'start_at': '',
                        'end_at': ''
                    },
                ],
                education: JSON.parse(this.$page.props.auth.user.external_data).education || [
                    {
                        'name': '',
                        'degree': '',
                        'start_at': '',
                        'end_at': ''
                    },
                ]
            })
        };
    },
    props: [

    ],
    mounted() {

    },
    methods: {
        job_add() {
            if (this.form.jobs.length < 10) {
                this.form.jobs.push({
                    'name': '',
                    'jobtitle': '',
                    'start_at': '',
                    'end_at': ''
                });
            }
        },
        delete_job(index) {
            this.form.jobs.splice(index, 1);
        },
        edu_add() {
            if (this.form.education.length < 10) {
                this.form.education.push({
                    'name': '',
                    'degree': '',
                    'start_at': '',
                    'end_at': ''
                });
            }
        },
        delete_edu(index) {
            this.form.education.splice(index, 1);
        }
    }
}
</script>
