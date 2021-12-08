<template>
    <div class="profile" @click="onProfileClick">
        <div v-if="in_admin" class="admin_actions">
            <button @click.prevent.stop="block(user)">
                {{ user.is_block ? 'Разблокировать' : 'Заблокировать' }}
            </button>
        </div>
        <div class="profile-header">
            <img :src="user.photo_url" alt="">
        </div>
        <div class="name-wrap">
            <div class="profile-nickname">{{ user.nickname }}</div>
            <div class="profile-login">@{{ user.login }}</div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "UserCard",
        props: {
            user: {},
            in_admin: {
                default: false
            }
        },
        methods: {
            onProfileClick() {
                this.$router.push({ name: 'profile.user', params: { user_id: this.user.user_id }})
            },
            block(user) {
                console.log(user)
                let user_id = user.user_id
                this.$api.get('/api/users.block', {user_id}, response => {
                    location.reload()
                })
            }
        }
    }
</script>

<style scoped>
    .profile {
        display: flex;
        margin: 15px 0;
        cursor: pointer;
    }

    .profile-header img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }

    .profile-nickname {
        font-weight: 700;
        margin-right: 7px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .profile-login {
        color: var(--login-color);
    }

    .name-wrap {
        margin-left: 7px;
    }

    .admin_actions {
        margin-right: 10px;
    }
</style>
