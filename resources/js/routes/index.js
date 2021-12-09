import VueRouter from "vue-router";
import Start from "../../views/pages/Start";
import Home from "../../views/pages/Home";
import ProfileEdit from "../../views/pages/ProfileEdit";
import Profile from "../../views/pages/Profile";
import Post from "../../views/pages/Post";
import Search from "../../views/pages/Search";
import AdminLogin from "../../views/pages/Admin/Login";
import AdminMain from "../../views/pages/Admin/Main";
import AdminSearch from "../../views/pages/Admin/Search";
import AdminUsers from "../../views/pages/Admin/Users";

export default new VueRouter({
    mode: 'history',
    base: '/',
    routes: [
        {
            path: '/',
            name: 'start',
            component: Start
        },
        {
            path: '/search',
            name: 'search',
            component: Search,
        },
        {
            path: '/home',
            name: 'home',
            component: Home,
        },
        {
            path: '/profile/edit',
            name: 'profile.edit',
            component: ProfileEdit,
        },
        {
            path: '/profile/:user_id',
            name: 'profile.user',
            component: Profile,
        },
        {
            path: '/profile',
            name: 'profile',
            component: Profile,
        },
        {
            path: '/post/:post_id',
            name: 'post',
            component: Post,
        },
        {
            path: '/admin',
            name: 'admin.main',
            component: AdminMain,
        },
        {
            path: '/admin/search',
            name: 'admin.search',
            component: AdminSearch,
        },
        {
            path: '/admin/users',
            name: 'admin.users',
            component: AdminUsers,
        },
        {
            path: '/admin/login',
            name: 'admin.login',
            component: AdminLogin,
        },
    ],
});
