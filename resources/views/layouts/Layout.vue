<template>
    <div class="my-container layout">
        <div class="mobile-menu-btn" @click="mobileMenuVisible = true">
            <i class="fa fa-bars"></i>
        </div>
        <h1 class="mobile-logo">Posterz</h1>
        <div class="menu">
            <h1 class="logo">Posterz</h1>
            <Navigation/>
        </div>
        <div style="width: 100%;background:white;">
            <slot></slot>
        </div>
        <notifications group="common"/>
        <div v-if="mobileMenuVisible" class="mobile-menu-wrapper" @click="hideMenu">
            <Navigation/>
        </div>
    </div>
</template>

<script>
    import Navigation from "../elements/Navigation";

    export default {
        name: "Layout",
        data() {
            return {
                mobileMenuVisible: false,
            }
        },
        components: {
            Navigation
        },
        methods: {
            hideMenu(e) {
                if (e.target.tagName === 'BUTTON') {
                    return
                }
                this.mobileMenuVisible = false
            }
        }
    }
</script>

<style scoped>
    .layout {
        max-width: 800px;
        margin: auto;
        padding: 30px 0;
        display: flex;
        padding-bottom: 500px;
    }

    .menu {
        margin-right: 30px;
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

    .mobile-menu-btn {
        position: absolute;
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
        }

        .mobile-logo,
        .mobile-menu-btn i {
            display: block;
        }
    }
</style>
