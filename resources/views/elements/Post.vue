<template>
    <router-link :to="{ name: 'post', params: { post_id: this.post.post_id }}"
                 class="post"
                 :class="{'post-mini': mini}">
        <router-link :to="{ name: 'profile.user', params: { user_id: postOwner }}">
            <img class="user-avatar" :src="users[postOwner].photo_url" :alt="users[postOwner].nickname">
        </router-link>
        <div class="post-wrap">
            <router-link :to="{ name: 'profile.user', params: { user_id: postOwner }}" class="post-title">
                <div class="post-nickname">
                    {{ users[postOwner].nickname }}
                </div>
                <div class="post-login">
                    @{{ users[postOwner].login }}
                </div>
                <div class="post-dot">
                    ·
                </div>
                <div class="post-date">
                    {{ formantDate() }}
                </div>
            </router-link>
            <div class="post-content">
                <div v-if="post.repost_id && !mini">
                    <div v-if="post.content.length">
                        <div class="post-content_wrap" v-html="addHrefs(post.content)"></div>
                        <Post :post="post.repost"
                              :users="users"
                              :statistics="statistics"
                              :mini="true"
                              style="margin-top: 5px;"
                        ></Post>
                    </div>
                    <div v-else class="post-content_wrap" v-html="addHrefs(post.repost.content)"></div>
                </div>
                <div v-else>
                    <div class="post-content_wrap" v-html="addHrefs(post.content)"></div>
                    <img v-for="img in post.images" :key="img.url" :src="img.url">
                </div>
            </div>
            <div class="post-actions" v-if="!mini">
<!--                <div class="post-action">-->
<!--                    <i class="fa fa-comment-o" @click.prevent.stop="comment(post.post_id)"></i>-->
<!--                    {{ statistics.comments[post.post_id] ? statistics.comments[post.post_id].count : '' }}-->
<!--                </div>-->
<!--                <div class="post-action">-->
<!--                    <i class="fa fa-retweet"-->
<!--                       :style="{color: post.repost_id || statistics.reposts[post.post_id] ? '#17bf63' : ''}"-->
<!--                       @click.prevent.stop="repost(post.post_id)"></i>-->
<!--                    {{ repostCount() }}-->
<!--                </div>-->
                <div class="post-action">
                    <i class="fa"
                       :class="{'fa-heart-o': !post.liked, 'fa-heart': post.liked}"
                       :style="{color: post.liked ? 'rgb(236 20 87)' : ''}"
                       @click.prevent.stop="like(post.post_id)"></i>
                    {{ statistics.likes[post.post_id] ? statistics.likes[post.post_id].count : '' }}
                </div>
            </div>
        </div>
    </router-link>
</template>

<script>
    import moment from "moment";
    import Vue from "vue";

    export default {
        name: "Post",
        props: {
            post: {},
            users: {},
            statistics: {},
            mini: {
                default: false
            }
        },
        methods: {
            comment(post_id) {
                this.$special.commenting_id = post_id
                this.$modal.show('addPost')
            },
            like(post_id) {
                this.$api.get('/api/likes.create', {post_id}, response => {
                    if (this.statistics.likes[post_id]) {
                        this.$delete(this.statistics.likes, post_id)
                    } else {
                        this.$set(this.statistics.likes, post_id, response.data.statistics.likes[post_id])
                    }
                    this.post = response.data.posts[0]
                })
            },
            repost(post_id) {
                this.$set(this.$special, 'repost_id', post_id)
                this.$special.postsData = {
                    post: this.post,
                    users: this.users,
                    statistics: this.statistics
                }
                this.$modal.show('addPost')
            },
            formantDate() {
                return moment(this.post.created_at).lang("ru").fromNow()
            },
            repostCount() {
                const reposts = this.statistics.reposts
                if (reposts[this.post.post_id]) {
                    return reposts[this.post.post_id].count
                } else if (this.post.repost_id) {
                    return reposts[this.post.repost_id].count
                }
                return ''
            },
            addHrefs(inputText) {
                return inputText
                var pattern = /([-a-zA-Z0-9@:%_\+.~#?&\/\/=]{2,256}\.[a-zA-Zа-яА-ЯёЁ]{2,4}\b(\/?[-a-zA-Z0-9а-яА-ЯёЁ@:%_\+.~#?&\/\/=]*)?)/gi;
                var replacedText = inputText.replace(pattern, '<a href="$1" target="_blank">$1</a>');
                return replacedText;
            }
        },
        computed: {
            postOwner() {
                if (!this.post.content.length && this.post.repost_id) {
                    return this.post.repost.user_id
                }
                return this.post.user_id
            }
        }
    }
</script>

<style scoped>
    .user-avatar {
        min-width: 47px;
        width: 47px;
        height: 47px;
        border-radius: 50%;
        transition-property: filter;
        transition-duration: 200ms;
    }

    .user-avatar:hover {
        filter: brightness(90%);
    }

    .post {
        border: solid 1px #e8e8e8;
        padding: 10px 11px;
        display: flex;
        transition-property: background;
        transition-duration: 300ms;
        color: black;
    }

    a {
        outline: none;
    }

    .post:hover,
    a:focus,
    a:active {
        color: black;
    }

    .post:hover {
        background: #fbfbfb;
    }

    .post:not(:first-child) {
        border-top: 0;
    }

    .post-title {
        display: flex;
    }

    .post-nickname {
        font-weight: 700;
        margin-right: 7px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        color: black;
    }

    .post-title:hover .post-nickname {
        text-decoration: underline;
    }

    .post-login,
    .post-date,
    .post-dot {
        color: var(--login-color);
    }

    .post-date,
    .post-dot {
        margin-left: 4px;
    }

    .post-date {
        font-size: 0.9em;
    }

    .post-wrap {
        margin-left: 7px;
        width: 100%;
    }

    .post-actions {
        display: flex;
        justify-content: space-between;
        width: 30%;
    }

    .post-actions .fa {
        padding: 7px 0 2px 0;
    }

    .post-action {
        min-width: 40px;
    }

    .post-actions > div {
        cursor: pointer;
    }

    .post-mini {
        border-radius: 8px;
    }

    .post-content_wrap {
        white-space: pre-line;
    }

    .post-content img {
        padding-bottom: 10px;
    }
</style>
