import _ from 'helpers/fp';
import inputBaseMixin from 'mixins/inputBaseMixin';

export const mixin = {
    props: {
        hasEmptyValue: {
            default: false,
        },
    },
    mixins: [inputBaseMixin],
    data() {
        return {
            all: false,
        };
    },
    ready() {
        this.valueWatcher(this.value);
    },
    watch: {
        all(isAll) {
            if (isAll) {
                this.$set('value', _.pluck('value', this._options));
            } else {
                this.$set('value', []);
            }
        },
        value(selectedValues) {
            this.valueWatcher(selectedValues);
        },
        optionsLoaded() {
            this.valueWatcher(this.value);
        },
    },
    methods: {
        valueWatcher(selectedValues) {
            if (selectedValues.length == 0) {
                this.all = false;
                this.$els.all.indeterminate = false;
            } else if (selectedValues.length == this._options.length) {
                this.all = true;
                this.$els.all.indeterminate = false;
            } else {
                this.$els.all.indeterminate = true;
            }
        },
    },
};

export default mixin;
