
export default {
    computed: {
        $user() {
            return this.$root.user || {};
        },
    },
};
