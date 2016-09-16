<template>
    <div class="container bubble">
        <div class="col-md-6 col-md-offset-3">
            <div
                v-for="bubble in bubbles"
                transition="fade"
                stagger="100"
                class="alert alert-dismissible animated"
                :class="['alert-' + (bubble.class || 'info')]"
            >
                <button type="button" class="close" @click="bubbles.$remove(bubble)">×</button>
                <h4 v-if="bubble.title">{{ bubble.title }}</h4>
                <p v-if="bubble.message">{{ bubble.message }}</p>
                <template v-if="bubble.errors">
                    <template v-for="field in bubble.errors">
                        <p v-for="error in field" :title="$key">{{ error }}</p>
                    </template>
                </template>
            </div>
        </div>
    </div>
</template>
<script>
    import Vue from 'vue';

    Vue.transition('fade', {
        css: false,
        enter: function (el, done) {
            $(el).hide().slideDown(done);
        },
        enterCancelled: function (el) {
            $(el).stop()
        },
        leave: function (el, done) {
            $(el).slideUp(done);
        },
        leaveCancelled: function (el) {
            $(el).stop()
        },
    });

    /**
     * @name bubble
     * @component bubble
     * @methods
     *     show
     */
    export default {
        data() {
            return {
                bubbles: [],
            };
        },
        methods: {
            show(bubble) {
                this.bubbles.push(bubble);

                setTimeout(() => {
                    this.bubbles.$remove(bubble);
                }, 7500);
            },
        },
    };
</script>
