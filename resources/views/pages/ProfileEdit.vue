<template>
    <Layout>
        <div style="padding-left: 10px;padding-right: 10px;">
            <form v-if="user" @submit.prevent.stop="saveProfile">
                <fieldset>
                    <legend>Редактирование:</legend>
                    <p>
                        <label>Никнейм:</label>
                        <input type="text" v-model="user.nickname" required>
                    </p>
                    <p>
                        <label>Логин:</label>
                        <input type="text" v-model="user.login" required>
                    </p>
                    <p>
                        <label>Описание:</label>
                        <textarea style="height: 130px;" v-model="user.description"></textarea>
                    </p>
                    <button>Сохранить</button>
                </fieldset>
            </form>
            <hr>
            <form v-if="user" @submit.prevent.stop="savePhoto">
                <fieldset>
                    <legend>Аватарка:</legend>
                    <p>
                        <label for="file">Загрузить фото</label>
                        <input ref="photoEl" type="file" id="file">
                    </p>
                    <button>Сохранить</button>
                </fieldset>
            </form>
        </div>
    </Layout>
</template>

<script>
    export default {
        name: "ProfileEdit",
        data() {
            return {
                user: null
            }
        },
        methods: {
            saveProfile() {
                let user = this.user
                if (user.nickname.length == 0 || user.login.length == 0) {
                    alert('Введите все поля')
                    return
                }
                this.$api.get('/api/users.save', {...user}, response => {
                    this.$notify({
                        group: 'common',
                        title: 'Сохранение',
                        text: 'Профиль сохранен.'
                    });
                    location.reload()
                })
            },
            savePhoto() {
                const data = new FormData()
                const photoEl = this.$refs.photoEl
                data.append('photo', photoEl.files[0])
                data.append('token', window.user.token)
                this.$axios.post('/api/users.photo', data, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                    .then(response => {
                        this.$notify({
                            group: 'common',
                            title: 'Сохранение',
                            text: 'Профиль сохранен.'
                        });
                        location.reload()
                    })
            }
        },
        mounted() {
            this.$api.get('/api/users.get', {}, response => {
                this.user = response.data.users[0]
            })
        }
    }
</script>

<style scoped>

</style>
