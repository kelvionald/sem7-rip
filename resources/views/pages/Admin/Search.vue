<template>
    <AdminLayout>
        <div style="padding-left: 10px;padding-right: 10px;">
            <div class="tabs">
                <a @click="setModeUsers">Люди</a>
                <a @click="setModePosts">Посты</a>
            </div>
            <input type="text" placeholder="Поиск в Posterz" v-model="q" @input="search">
            <div v-if="users.length">
                <hr>
                <UserCard v-for="user in users" :user="user" :key="user.user_id"></UserCard>
            </div>
            <div v-if="postsData.posts.length">
                <hr>
                <Posts :postsData="postsData"></Posts>
            </div>
            <hr>
            <div>
                <p class="is-size-4">Новые пользователи:</p>
                <UserCard v-for="user in usersNew" :user="user" :key="user.user_id"></UserCard>
            </div>
            <hr>
            <div>
                <p class="is-size-4">Новые посты:</p>
                <Posts :postsData="postsNew"></Posts>
            </div>
        </div>
    </AdminLayout>
</template>

<script>
    import UserCard from "../../elements/UserCard";
    import Posts from "../../elements/Posts";

    export default {
        name: "Home",
        components: {
            UserCard,
            Posts
        },
        data() {
            return {
                usersNew: [],
                postsNew: {
                    posts: [],
                    users: {},
                    statistics: {}
                },

                users: [],
                postsData: {
                    posts: [],
                    users: {},
                    statistics: {}
                },

                q: '',

                MODE_USERS: 1,
                MODE_POSTS: 2,
                mode: 0
            }
        },
        methods: {
            search() {
                const q = this.q
                if (q.length) {
                    if (this.mode === this.MODE_USERS) {
                        this.$api.get('/api/users.search', {q}, response => {
                            this.users = response.data.users
                        })
                    } else if (this.mode === this.MODE_POSTS) {
                        this.$api.get('/api/posts.search', {q}, response => {
                            this.$set(this.postsData, 'posts', response.data.posts)
                            this.$set(this.postsData, 'users', response.data.users)
                            this.$set(this.postsData, 'statistics', response.data.statistics)
                        })
                    }
                }
            },
            setModeUsers() {
                this.mode = this.MODE_USERS
                this.postsData = {
                    posts: []
                }
            },
            setModePosts() {
                this.mode = this.MODE_POSTS
                this.users = []
            }
        },
        mounted() {
            this.mode = this.MODE_USERS
            this.$api.get('/api/users.getNew', {}, response => {
                this.usersNew = response.data.users
            })
            this.$api.get('/api/posts.getNew', {}, response => {
                this.$set(this.postsNew, 'posts', response.data.posts)
                this.$set(this.postsNew, 'users', response.data.users)
                this.$set(this.postsNew, 'statistics', response.data.statistics)
            })
        }
    }
</script>

<style scoped>
    .tabs {
        display: flex;
    }

    .tabs a {
        margin-right: 11px;
        padding: 5px 7px;
    }
</style>
