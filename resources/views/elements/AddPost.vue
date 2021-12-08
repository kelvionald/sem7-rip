<template>
    <div>
        <button @click="showAddPost" type="button">Сделать пост</button>
        <VModal height="auto" :adaptive="true" name="addPost" @before-close="beforeClose">
            <div class="add_post">
                <textarea v-model="content" placeholder="Как обстановка?" :maxlength=max :style="[content.length > red ? {'border-color': 'red'} : {'border-color': 'blue'}]"></textarea>
                <p>{{content.length + '/' + max}}</p>
                <Post v-if="special.repost_id"
                      :post="special.postsData.post"
                      :users="special.postsData.users"
                      :statistics="special.postsData.statistics"
                ></Post>
                <div class="add_post_photos" v-if="photos.length">
                    <div class="add_post_photos_item" v-for="image in photos" @click="removePhoto(image.image_id)">
                        <img v-if="image.url" :src="image.url" alt="">
                        <input type="file" hidden ref="photosRefs">
                    </div>
                </div>
                <div class="add_post_add_photo">
                    <button type="button" @click="addPhoto">Добавить фото</button>
                </div>
                <button type="button" @click="sentPost">Отправить</button>
            </div>
        </VModal>
    </div>
</template>

<script>
    import Post from "./Post"

    export default {
        name: "AddPost",
        components: {
            Post
        },
        data() {
            return {
                content: '',
                special: {},
                photos: [],
                // photosRefs: [],
                max: 200,
                red: 190,
            }
        },
        methods: {
            showAddPost() {
                this.$modal.show('addPost')
            },
            sentPost() {
                if (this.$special.repost_id) {
                    const data = {
                        post_id: this.$special.repost_id,
                        content: this.content,
                        images: this.photos,
                    }
                    this.$api.get('/api/posts.repost', data, response => {
                        console.log(response)
                        this.content = ''
                        this.$modal.hide('addPost')
                    })
                } else {
                    let data = {
                        content: this.content,
                        images: this.photos,
                    }
                    if (this.$special.commenting_id) {
                        data.commenting_id = this.$special.commenting_id
                    }
                    this.$api.post('/api/posts.create', data, response => {
                        console.log(response)
                        this.content = ''
                        this.$modal.hide('addPost')
                        console.log(window.$updatePosts)
                        if (window.$updatePosts) {
                            window.$updatePosts()
                        }
                    })
                }
            },
            addPhoto() {
                const obj = this
                this.photos.push({
                    url: null,
                    yc_key: null,
                    image_id: 0,
                })
                console.log(this.photos)
                this.$nextTick(() => {
                    const i = this.$refs.photosRefs.length - 1
                    const lastRef = this.$refs.photosRefs[i]
                    lastRef.onchange = function () {
                        console.log(i, lastRef.value, lastRef.files)

                        const data = new FormData()
                        data.append('photo', lastRef.files[0])
                        data.append('token', window.user.token)
                        obj.$axios.post('/api/posts.uploadImage', data, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }).then(response => {
                            console.log(response.data)
                            obj.$set(obj.photos, i, response.data.image)
                            console.log(obj.photos)
                        })
                    }
                    lastRef.click()
                })
            },
            removePhoto(image_id) {
                this.photos = this.photos.filter((image) => image.image_id !== image_id)
            },
            beforeClose() {
                this.$special.commenting_id = 0
                this.$special.repost_id = 0
                this.$special.postsData = {}
            }
        },
        mounted() {
            // this.$modal.show('addPost') // for debug
            this.special = this.$special
        },
        computed: {
            reversedMessage: function () {
            if (this.characters < 20){
                return false;
            }else{
                return true;
            }
            }
        }
    }
</script>

<style scoped>
    .add_post {
        padding: 11px 15px;
    }

    .add_post textarea {
        margin: 10px 0px;
        height: 100px;
    }

    .add_post_add_photo, .add_post_photos {
        margin-bottom: 10px;
    }

    .add_post_photos {
        display: flex;
    }

    .add_post_photos_item {
        margin-right: 10px;
        position: relative;
        transition: all;
        transition-duration: 500ms;
    }

    .add_post_photos_item [type="file"] {
        display: none;
    }

    .add_post_photos_item img {
        width: 40px;
        height: 40px;
        object-fit: cover;
    }

    .add_post_photos_item:hover:before {
        content: '\2716';
        position: absolute;
        width: 100%;
        height: 100%;
        display: block;
        box-shadow: inset 0 0 36px 2px #282a2d;
        padding: 8px 14px;
        color: #ffffff;
    }
</style>
