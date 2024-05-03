<template>
    <div class="profile-info">
        <div class="edit-button">
            <button disabled style="border-radius: 20px" class="primary">{{ $t('profile.security.change_password.title') }}</button>
            <button @click="$inertia.visit(route('auth.logout'))" class="secondary">{{ $t('profile.security.logout') }}</button>
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

export default {
    name: "UserCard",
    data() {
        return {

        };
    },
    props: [

    ],
    methods: {

    }
}
</script>
