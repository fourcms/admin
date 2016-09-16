<template>
    <div class="checkbox">
        <label>
            <input type="checkbox" v-model="value"> {{ text }}
        </label>
    </div>
</template>

<script>
    /**
     * @name checkboxInput
     * @component checkbox-input
     * @props
     *     value
     *     [text]
     */
    export default {
        props: {
            value: {
                required: true,
            },
            text: {
                default: '',
            },
        },
    };
</script>
