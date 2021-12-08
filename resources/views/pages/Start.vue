<template>
    <div class="container ">
        <div class="start-top">
            <ul>
                <li>Читайте о том, что вам интересно.</li>
                <li>Узнайте, о чем говорят в мире.</li>
                <li>Присоединяйтесь к общению.</li>
            </ul>
        </div>
        <div class="start-bottom">
            <div style="margin-bottom: 20px;">Войдите через одну из популярных социальных сетей:</div>
            <div id="uLogin"
                 :data-ulogin="uloginParams"></div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Start",
        computed: {
            uloginParams() {
                var url = encodeURIComponent(location.origin + '/ulogin')
                console.log(url)
                return 'display=small;theme=classic;fields=first_name,last_name;providers=vkontakte,google,facebook,twitter,yandex,instagram,steam;hidden=livejournal,openid,lastfm,linkedin,liveid,soundcloud,youtube,webmoney,wargaming;redirect_uri=' + url + ';mobilebuttons=0;'
            }
        }
    }
</script>

<style scoped>
    .start-top {
        padding: 20px 0;
        display: grid;
        justify-content: center;
        background: #41bb45;
        color: white;
        margin-top: 20px;
    }

    .start-top > ul {
        margin-bottom: 0;
    }

    .start-bottom {
        display: flex;
        flex-direction: column;
        text-align: center;
        padding: 40px 0;
    }
</style>
