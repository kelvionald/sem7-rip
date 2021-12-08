<template>
    <Layout>
        <div class="posts">
            <Posts :postsData="postsData"></Posts>
        </div>
    </Layout>
</template>

<script>
    import Posts from "../elements/Posts";
    export default {
        name: "Home",
        components: {
            Posts
        },
        data() {
            return {
                postsData: {}
            }
        },
        mounted() {
            this.$api.get('/api/posts.feed', {}, response => {
                this.postsData = response.data
            })
        }
    }
</script>

<style scoped>

</style>
