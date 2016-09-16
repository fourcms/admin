<template>
    <input type="text" class="form-control" v-model="value">
</template>

<script>
    /**
     * @name textInput
     * @component text-input
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
