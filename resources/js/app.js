import Vue from 'vue'
import VueRouter from 'vue-router'
import axios from "axios";
import VModal from 'vue-js-modal'
import Notifications from 'vue-notification'
import Layout from "../views/layouts/Layout";
import AdminLayout from "../views/layouts/AdminLayout";
import App from '../views/App'
import router from './routes'

Vue.use(VueRouter)
Vue.use(VModal, {dynamicDefault: {resizable: true}, height: 'auto', componentName: 'VModal'})
Vue.use(Notifications)

function errorHandler(err) {
    console.log(err)
    Vue.notify({
        group: 'common',
        type: 'error',
        title: 'Ошибка',
        text: 'Ошибка запроса. Попробуйте позже.'
    })
}

Vue.prototype.$api = {
    get: function (url, data, success, error = null) {
        data['token'] = window.user.token
        if (!error) {
            error = errorHandler
        }
        axios.get(url, {
            params: data
        })
            .then(success)
            .catch(error)
    },
    post: function (url, data, success, error = null) {
        data['token'] = window.user.token
        if (!error) {
            error = errorHandler
        }
        axios.post(url, data)
            .then(success)
            .catch(error)
    }
}
Vue.prototype.$special = {
    commenting_id: 0,
    repost_id: 0,
    postsData: {
        post: {},
        users: {},
        statistics: {}
    },
}
Vue.prototype.$axios = axios
Vue.prototype.$user = user
window.$updatePosts = null
window.$onScroll = null
window.$isLoading = false
Vue.component('Layout', Layout);
Vue.component('AdminLayout', AdminLayout);

const app = new Vue({
    el: '#app',
    components: {App},
    template: '<App/>',
    router,
});

window.app = app
