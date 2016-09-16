<template>
    <input type="text" number class="form-control" v-model="value">
</template>

<script>
    /**
     * @name numberInput
     * @component number-input
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
