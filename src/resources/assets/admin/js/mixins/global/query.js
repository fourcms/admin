
export default {
    computed: {
        query() {
            return (this.$root.context && this.$root.context.query) || {};
        },
    },
};
