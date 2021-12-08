<template>
    <AdminLayout>
        <div style="padding: 20px">
            <div class="stat-common" v-if="statistics">
                <div class="stat-wrap">
                    <div class="stat-title">Количество пользователей:</div>
                    <div class="stat-value">{{ statistics.usersCount }}</div>
                </div>
                <div class="stat-wrap">
                    <div class="stat-title">Количество постов:</div>
                    <div class="stat-value">{{ statistics.postsCount }}</div>
                </div>
                <div class="stat-wrap">
                    <div class="stat-title">Количество пользователей за последний месяц:</div>
                    <div class="stat-value">{{ statistics.usersCountByMonth }}</div>
                </div>
                <div class="stat-wrap">
                    <div class="stat-title">Количество постов за последний месяц:</div>
                    <div class="stat-value">{{ statistics.postsCountByMonth }}</div>
                </div>
                <div style="display: flex">
                    <ChartLine :data="statistics.usersByDateByMonth" label="Пользователи в течение месяца"></ChartLine>
                    <ChartLine :data="statistics.postsByDateByMonth" label="Посты в течение месяца"></ChartLine>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script>
    import ChartLine from "../../elements/ChartLine";

    export default {
        name: "AdminMain",
        components: {
            ChartLine
        },
        data() {
            return {
                statistics: null
            }
        },
        mounted() {
            this.$api.get('/api/statistics.common', {}, response => {
                this.statistics = response.data
            })
        }
    }
</script>

<style scoped>
    .stat-wrap {
        display: flex;
    }
    .stat-value {
        margin-left: 6px;
        font-weight: 600;
        font-size: 1.1em;
        line-height: 1.4em;
    }
</style>
