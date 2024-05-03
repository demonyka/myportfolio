<template>
    <div class="profile-info">
        <h3 class="title">
            {{ $t('profile.popular_authors') }}
        </h3>
        <Link :href="getProfileURL(author)" class="user-info" v-for="author in authors">
            <img alt="avatar" :src="JSON.parse(author.external_data).avatar_path || 'http://[::1]:5173/public/assets/images/default_avatar.png'" @onerror="$event.target.src = 'http://[::1]:5173/public/assets/images/default_avatar.png'">
            <h4>{{ JSON.parse(author.external_data).fullname }}</h4>
        </Link>
    </div>
</template>

<style scoped>
.profile-info {
    padding: 20px 30px;
    background-color: white;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    border-radius: 20px;
}
h3.title {
    font-size: 18px;
    font-weight: 500;
    margin: 0 0 15px 0;
}
.user-info {
    display: flex;
    align-items: center;
    margin-top: 10px;
    gap: 10px;
    color: black;
}
.user-info:hover {
    scale: 1;
}
.user-info img {
    width: 30px;
    height: 30px;
    object-fit: cover;
    border-radius: 100%;
}
.user-info h4 {
    font-size: 18px;
    margin: 0;
    font-weight: 400;
}
</style>

<script>
import {Link} from "@inertiajs/vue3";
import {getProfileURL} from "@/scripts.js";
export default {
    name: "UserCard",
    components: {
        Link
    },
    data() {
        return {

        };
    },
    props: [
        'authors'
    ],
    methods: {
        getProfileURL
    }
}
</script>
