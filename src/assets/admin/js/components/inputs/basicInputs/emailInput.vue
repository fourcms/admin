<template>
    <input type="email" class="form-control" v-model="value">
</template>

<script>
    /**
     * @name emailInput
     * @component email-input
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
