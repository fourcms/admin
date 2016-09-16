<template>
    <select class="form-control" v-model="value">
        <option v-for="option in values" :value="option.value">{{ option.text }}</option>
    </select>
</template>
<script>
    import inputMixin from 'mixins/inputMixin';

    /**
     * @name selectInput
     * @component select-input
     * @props
     *     value
     *     [options]: null
     *     [has-empty-value]: false
     */
    export default {
        mixins: [inputMixin],
    };
</script>
