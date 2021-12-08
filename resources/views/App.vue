<template>
    <router-view></router-view>
</template>
<script>
    export default {
        mounted() {
            if (!this.$user) {
                this.$router.push({name: 'start'});
            }

            window.addEventListener("scroll", () => {
                var block = document.body;
                var counter = 1;

                var contentHeight = block.offsetHeight;      // 1) высота блока контента вместе с границами
                var yOffset = window.pageYOffset;      // 2) текущее положение скролбара
                var window_height = window.innerHeight;      // 3) высота внутренней области окна документа
                var y = yOffset + window_height;

                if (y >= contentHeight && window.$onScroll) {
                    window.$onScroll()
                }
            });
        }
    }
</script>
<style>
    :root {
        --login-color: grey;
    }

    .button,
    button {
        border-radius: 0 !important;
    }

    body {
        background: url(/img/bg.png)
    }

    .router-link-exact-active {
        color: black !important;
    }
</style>
