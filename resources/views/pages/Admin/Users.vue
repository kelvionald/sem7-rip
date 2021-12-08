<template>
    <AdminLayout>
        <div style="padding-left: 10px;padding-right: 10px;">
            <div v-if="users.length">
                <p class="is-size-4">Пользователи:</p>
                <UserCard v-for="user in users" :user="user" :key="user.user_id" :in_admin="true"></UserCard>
            </div>
        </div>
    </AdminLayout>
</template>

<script>
    import UserCard from "../../elements/UserCard";

    export default {
        name: "Users",
        components: {
            UserCard
        },
        data() {
            return {
                users: []
            }
        },
        mounted() {
            this.$api.get('/api/users.getAll', {}, response => {
                this.users = response.data.users
            })
        }
    }
</script>

<style scoped>

</style>
