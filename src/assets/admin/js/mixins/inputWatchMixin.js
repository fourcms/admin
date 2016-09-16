import _ from 'helpers/fp';

export default {
    watch: {
        valuesLoaded() {
            if (this.values.length && _.find(_.propEq('value', this.value), this.values) === undefined) {
                this.$set('value', this.values[0].value);
            }
        },
    },
}
