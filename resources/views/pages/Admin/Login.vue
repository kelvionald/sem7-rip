<template>
    <AdminLayout>
        <form style="padding: 20px" action="/adminlogin">
            <fieldset>
                <legend>Вход в панель администратора</legend>
                <p>
                    <label>Логин:</label>
                    <input type="text" name="login">
                </p>
                <p>
                    <label>Пароль:</label>
                    <input type="password" name="password">
                </p>
                <button>Войти</button>
            </fieldset>
        </form>
    </AdminLayout>
</template>

<script>
    export default {
        name: "Login"
    }
</script>

<style scoped>

</style>
