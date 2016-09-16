export default {
    watch: {
        'context.title': {
            async handler(title) {
                document.title = title
            },
            immediate: true,
        }
    },
};
