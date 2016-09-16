import _ from 'helpers/fp';

export const defaultOptions = [{text: '', value: 0}];
export const defaultTransformer = obj => {
    if (typeof obj === 'object') {
        return {
            text: obj.name,
            value: obj.id,
            obj: obj,
        };
    } else {
        return {
            text: obj,
            value: obj,
            obj: obj,
        };
    }
};

export const mixin = {
    data() {
        return {
            values: this.$options.provider ? this.$options.provider.emptyValue() : [],
            valuesLoaded: false,
        };
    },
    async created() {
        let transformer = this.$options.transformer || defaultTransformer;
        let defaults = this.hasEmptyValue ? (this.$options.default || defaultOptions) : [];
        let options = this.options === null ? await this.$options.provider : this.options;

        if (typeof options === 'object' && ! Array.isArray(options)) {
            options = _.pipe(
                _.toPairs,
                _.map(_.pickAllAs({0: 'id', 1: 'name'})),
            )(options);
        }

        this.values = _.concat(defaults, _.map(transformer, options));
        this.valuesLoaded = true;
    },
    props: {
        value: {
            required: true,
        },
        hasEmptyValue: {
            default: false,
        },
        options: {
            default: null,
        },
    },
};

export default mixin;
