<template>
    <div>
        <ul class="is-unstyled">
            <li>
                <router-link :to="{ name: 'home'}">Главная</router-link>
            </li>
            <li>
                <router-link :to="{ name: 'profile'}">Профиль</router-link>
            </li>
            <li>
                <router-link :to="{ name: 'search'}">Поиск</router-link>
            </li>
            <li>
                <a style="color: red" href="/logout">Выход</a>
            </li>
        </ul>
        <AddPost></AddPost>
    </div>
</template>

<script>
    import AddPost from "../elements/AddPost";
    export default {
        name: "Navigation",
        components: {
            AddPost
        }
    }
</script>

<style scoped>
    li a {
        font-size: 1.1em;
    }

    ul li {
        margin-bottom: 2px;
    }
</style>
