<script>
    import selectInput from 'components/inputs/basicInputs/selectInput';
    import userStatusesProvider from 'providers/userStatusesProvider';

    /**
     * @name userStatusInput
     * @component user-status-input
     * @props
     *     value
     *     [options]: null
     *     [has-empty-value]: false
     */
    export default {
        mixins: [selectInput],
        provider: userStatusesProvider,
    };
</script>
