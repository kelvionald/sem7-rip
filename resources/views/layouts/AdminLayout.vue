<template>
    <div class="my-container layout">
        <h1>Posterz</h1>
        <div style="width: 100%;background:white;display:flex;     padding: 4px 19px;">
            {{ $user.nickname }} (@{{ $user.login }})
        </div>
        <div style="width: 100%;background:white;display:flex">
            <div class="menu">
                <ul class="is-unstyled">
                    <li>
                        <router-link :to="{ name: 'admin.main'}">Состояние</router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'admin.search'}">Поиск</router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'admin.users'}">Пользователи</router-link>
                    </li>
                    <li>
                        <a style="color: red" href="/logout">Выход</a>
                    </li>
                </ul>
            </div>
            <slot></slot>
        </div>
        <notifications group="common"/>
    </div>
</template>

<script>
    export default {
        name: "AdminLayout",
        data() {
            return {
                user: null
            }
        },
        mounted() {
            // this.user =
        }
    }
</script>

<style scoped>
    .layout {
        max-width: 1000px;
        margin: auto;
        padding: 30px 0;
        padding-bottom: 500px;
    }

    .menu {
        margin-right: 30px;
        padding: 20px;
    }

    .mobile-logo {
        display: none;
        text-align: center;
        font-size: 2em;
        margin: 3px 0;
    }

    .mobile-menu-btn i {
        font-size: 1.7em;
        position: absolute;
        top: 9px;
        left: 10px;
        color: #404040;
        display: none;
        cursor: pointer;
    }

    .mobile-menu-wrapper {
        position: fixed;
        top: 0;
        width: 100%;
        height: 100%;
        background: white;
        padding: 30px;
    }

    @media screen and (max-width: 769px) {
        .menu {
            display: none;
        }

        .layout {
            margin-top: 0;
            display: block;
            padding: 1px 0;
        }

        .mobile-logo,
        .mobile-menu-btn i {
            display: block;
        }
    }
</style>
