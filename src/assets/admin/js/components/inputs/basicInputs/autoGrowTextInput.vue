<template>
    <textarea
        class="form-control"
        v-model="value"
        rows="1"
        @keydown.enter.prevent=""
        @keydown.
        @focus="focus"
        @blur="blur"

    ></textarea>
</template>

<script>
    import autosize from 'helpers/autosize';

    /**
     * @name autoGrowTextInput
     * @component auto-grow-text-input
     * @props
     *     value
     */
    export default {
        props: {
            value: {
                required: true,
            },
        },
        data() {
            return {
                animate: true,
            };
        },
        watch: {
            value() {
                // debugger;
                // autosize.update(this.$el);
            },
        },
        methods: {
            async focus(e) {
                $(this.$el).addClass('auto-grow-text-input--animate');

                autosize(this.$el);

                setTimeout(() => {
                    $(this.$el).removeClass('auto-grow-text-input--animate');
                }, 210);
            },
            blur() {
                $(this.$el).addClass('auto-grow-text-input--animate');

                autosize.destroy(this.$el);

                setTimeout(() => {
                    $(this.$el).removeClass('auto-grow-text-input--animate');
                }, 210);
            },
        },
    };
</script>
