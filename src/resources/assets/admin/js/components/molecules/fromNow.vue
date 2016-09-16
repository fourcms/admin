<template>
    <span :title="humanDateTime(value)">{{ fromNow(value) }}</span>
</template>
<script>
    /**
     * @name fromNow
     * @component from-now
     * @props
     *     value
     */
    export default {
        props: {
            value: {
                required: true,
            },
        },
    };
</script>
