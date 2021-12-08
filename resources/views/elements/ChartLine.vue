<script>
    import {Line} from 'vue-chartjs'

    export default {
        extends: Line,
        name: "ChartLine",
        props: ['data', 'label'],
        mounted() {
            this.renderChart({
                labels: this.data.map(function (el) {
                    return el.date
                }),
                datasets: [
                    {
                        label: this.label,
                        backgroundColor: '#f87979',
                        data: this.data.map(function (el) {
                            return el.count
                        })
                    }
                ]
            }, {})
        }
    }
</script>

<style scoped>

</style>
