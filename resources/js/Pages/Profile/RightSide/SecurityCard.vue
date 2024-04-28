<template>
    <div class="profile-info">
        <div class="edit-button">
            <button disabled style="border-radius: 20px" class="primary">Изменить пароль</button>
            <button @click="$inertia.visit(route('auth.logout'))" class="secondary">Выход</button>
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
</style>

<script>
import {useForm} from "@inertiajs/vue3";

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
