<template>
    <div>
        <Post v-for="post in postsData.posts"
              :key="post.post_id"
              :post="post"
              :users="postsData.users"
              :statistics="postsData.statistics"></Post>
    </div>
</template>

<script>
    import Post from "../elements/Post";

    export default {
        name: "Posts",
        props: ['postsData'],
        components: {
            Post
        }
    }
</script>

<style scoped>

</style>
