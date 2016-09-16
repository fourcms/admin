<script>
    import tabInput from 'components/inputs/basicInputs/tabInput';
    import textScopesProvider from 'providers/textScopesProvider';

    /**
     * @name textScopeInput
     * @component text-scope-input
     * @props
     *     value
     *     [options]: null
     *     [has-empty-value]: false
     */
    export default {
        mixins: [tabInput],
        provider: textScopesProvider,
    };
</script>
