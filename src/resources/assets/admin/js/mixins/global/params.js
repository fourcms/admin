
export default {
    computed: {
        params() {
            return (this.$root.context && this.$root.context.params) || {};
        },
    },
};
