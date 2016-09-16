<template>
    <div v-if=" ! status" class="loader loading" :class="{'loader-sm': size}">
        <div class="spinner">Loading...</div>
    </div>
    <slot v-if="status"></slot>
</template>
<script>
    /**
     * @name loading
     * @component loading
     * @props
     *     status
     *     [size]: null
     */
    export default {
        props: {
            status: {
                required: true,
            },
            size: {
                default: null,
            },
        },
    };
</script>
