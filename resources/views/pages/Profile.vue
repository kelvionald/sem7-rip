<template>
    <Layout>
        <div class="profile" v-if="user">
            <div class="profile-header">
                <img :src="user.photo_url" alt="">
                <div v-if="$user.user_id == $route.params.user_id || !$route.params.user_id">
                    <router-link :to="{ name: 'profile.edit'}" class="button">Редактировать</router-link>
                </div>
                <div v-else>
                    <div v-if="user.reading">
                        <button @click="unfollow" class="button">Отписаться</button>
                    </div>
                    <div v-else>
                        <button @click="follow" class="button">Читать</button>
                    </div>
                </div>
            </div>
            <div>
                <div class="profile-nickname">{{ user.nickname }}</div>
                <div class="profile-login">@{{ user.login }}</div>
            </div>
            <div class="profile-description">{{ user.description }}</div>

            <div class="profile-stat">
                <span>{{ user.statistics.readableNumber }}</span> в читаемых <span>{{ user.statistics.readerNumber }}</span>
                читателя
            </div>
            <div v-if="postsCount" class="profile-stat"><span>{{ postsCount }}</span> постов</div>
            <!--            <div class="sort_profile" @click="changeOrder">-->
            <!--                {{ order ? 'новые' : 'старые' }}-->
            <!--                <i class="fa fa-sort" aria-hidden="true"></i>-->
            <!--            </div>-->
        </div>
        <div class="posts">
            <Posts :postsData="postsData"></Posts>
        </div>
    </Layout>
</template>

<script>
import Posts from "../elements/Posts";

export default {
    name: "Profile",
    components: {
        Posts
    },
    data() {
        return {
            postsData: {},
            postsCount: 0,
            user: null,
            order: true,
        }
    },
    methods: {
        follow() {
            const user_id = this.$route.params.user_id
            this.$api.get('/api/users.follow', {user_id}, response => {
                this.user = response.data.user
            })
        },
        unfollow() {
            const user_id = this.$route.params.user_id
            this.$api.get('/api/users.unfollow', {user_id}, response => {
                this.user = response.data.user
            })
        },
        getQuery() {
            let query = {order: this.order}
            let user_id = this.$route.params.user_id
            if (user_id) {
                const user_ids = user_id
                query = {user_ids}
            }
            return query
        },
        updatePage() {
            let user_id = this.$route.params.user_id
            let query = {order: this.order}
            if (user_id) {
                const user_ids = user_id
                query = {user_ids, order: this.order}
                this.$api.get('/api/users.get', query, response => {
                    this.user = response.data.users[0]
                })
            } else {
                this.user = user
                user_id = user.user_id
            }
            window.$isLoading = true
            this.$api.get('/api/posts.get', query, response => {
                this.postsData = response.data
                window.$isLoading = false
                window.$nextOffset = response.data.nextOffset
            })
            this.$api.get('/api/posts.count', {user_id}, response => {
                this.postsCount = response.data.postsCount
            })
            window.$onScroll = this.onScroll
        },
        onScroll() {
            if (window.$isLoading)
                return
            window.$isLoading = true
            const query = this.getQuery()
            query.offset = window.$nextOffset
            this.$api.get('/api/posts.get', query, response => {
                for (var k in response.data.statistics.likes) {
                    if (!(k in this.postsData.statistics.likes)) {
                        this.$set(this.postsData.statistics.likes, k, response.data.statistics.likes[k])
                    }
                }
                for (var k in response.data.statistics.reposts) {
                    if (!(k in this.postsData.statistics.reposts)) {
                        this.$set(this.postsData.statistics.reposts, k, response.data.statistics.reposts[k])
                    }
                }
                for (var k in response.data.statistics.comments) {
                    if (!(k in this.postsData.statistics.comments)) {
                        this.$set(this.postsData.statistics.comments, k, response.data.statistics.comments[k])
                    }
                }
                for (var k in response.data.users) {
                    if (!(k in this.postsData.users)) {
                        this.$set(this.postsData.users, k, response.data.users[k])
                    }
                }
                for (var post of response.data.posts) {
                    this.postsData.posts.push(post)
                }
                window.$isLoading = false
                window.$nextOffset = response.data.nextOffset
            })
        },
        changeOrder() {
            this.order = !this.order
            window.$nextOffset = 0
            this.postsData = {}
            this.updatePage()
        }
    },
    watch: {
        '$route.params': {
            handler(newValue) {
                this.updatePage()
            },
            immediate: true,
        }
    },
    mounted() {
        this.updatePage()
        var obj = this
        window.$updatePosts = function () {
            obj.updatePage()
        }
        console.log('mounted')
    },
    beforeDestroy() {
        window.$updatePosts = null
        console.log('destroyed')
    }
}
</script>

<style scoped>
.profile {
    padding: 15px;
    border-right: solid 1px #e8e8e8;
    border-left: solid 1px #e8e8e8;
    border-top: solid 1px #e8e8e8;
    position: relative;
}

.profile img {
    width: 100px;
    height: 100px;
    border-radius: 50% !important;
    border: 1px solid #bdbdbd;
    border-style: groove;
}

.profile-nickname {
    font-weight: 700;
    font-size: 1.2em;
    line-height: 1em;
}

.profile-login {
    color: var(--login-color);
    line-height: 1em;
    font-size: 0.9em;
    margin-top: 4px;
}

.profile-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
}

.profile-header .button {
    background: white;
    color: #0080ff;
}

.profile-description {
    margin-top: 4px;
}

.profile-stat {
    color: #565656;
}

.profile-stat span {
    color: black;
}

.sort_profile {
    position: absolute;
    right: 13px;
    bottom: 10px;
    transition-duration: 500ms;
    transition-property: color;
    cursor: pointer;
}

.sort_profile:hover {
    color: grey;
}
</style>
