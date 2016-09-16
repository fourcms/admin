<template>
    <div :class="{wrapper: user, 'login-page': currentPage == 'login'}">
        <loading :status="loaded">
            <main-header v-if="user"></main-header>
            <main-sidebar v-if="user"></main-sidebar>
            <component :is="currentPage" v-if="pageLoaded"></component>
        </loading>
        <bubble v-ref:bubble></bubble>
        <login-modal v-ref:login-modal></login-modal>
        <!-- <hotkeys-modal></hotkeys-modal> -->
    </div>
</template>
<script>
    import modules from 'loaders';
    import auth from 'helpers/auth';
    import _ from 'helpers/fp';

    /**
     * @name app
     * @component app
     */
    export default {
        el: '#app',
        mixins: Array.concat(_.values(modules.rootMixins), []),
        data: {
            currentPage: 'dashboard',
            context: {},
            user: null,
            // socket: null,
            loaded: false,
        },
        async created() {
            await auth.user();
        },
        computed: {
            /**
             * page is loaded if this.loaded is true and user has access to the page
             * @return {Boolean}
             */
            pageLoaded() {
                // return true;
                return  this.user && this.loaded ||
                        this.currentPage == 'login' && this.loaded;
            },
        },
    };
</script>
