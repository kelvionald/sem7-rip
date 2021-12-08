<template>
    <Layout>
        <Posts :postsData="postsData"></Posts>
        <div class="posts-comment">
            <Posts :postsData="comments"></Posts>
        </div>
    </Layout>
</template>

<script>
    import Posts from "../elements/Posts";

    export default {
        name: "Post",
        components: {
            Posts
        },
        data() {
            return {
                postsData: [],
                comments: []
            }
        },
        methods: {
            updatePage() {
                let post_id = this.$route.params.post_id
                this.$api.get('/api/posts.getPost', {post_id}, response => {
                    this.postsData = response.data
                    this.comments = response.data.comments
                })
            }
        },
        mounted() {
            this.updatePage()
        },
        watch: {
            '$route.params': {
                handler(newValue) {
                    this.updatePage()
                },
                immediate: true,
            }
        }
    }
</script>

<style scoped>
    .posts-comment {
        margin: 6px 0 0 8px;
    }
</style>
