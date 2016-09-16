<template>
    <ul class="nav nav-tabs">
        <li v-for="option in values" :class="{active: option.value == value}">
            <a @click="value = option.value">
                {{ option.text }}
            </a>
        </li>
    </ul>
</template>

<script>
    import selectInput from 'components/inputs/basicInputs/selectInput';

    /**
     * @name tabInput
     * @component tab-input
     * @props
     *     value
     *     [options]: null
     *     [has-empty-value]: false
     */
    export default {
        mixins: [selectInput],
    };
</script>
