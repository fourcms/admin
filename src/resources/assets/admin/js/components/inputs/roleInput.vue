<script>
    import selectInput from 'components/inputs/basicInputs/selectInput';
    import rolesProvider from 'providers/rolesProvider';

    /**
     * @name roleInput
     * @component role-input
     * @props
     *     value
     *     [options]: null
     *     [has-empty-value]: false
     */
    export default {
        mixins: [selectInput],
        provider: rolesProvider,
    };
</script>
