import Vue from 'vue';
const TIMEOUT = 20;

/**
 * @name required
 */
export default {
    read(val, key, field, validations) {
        if ( ! key) return val;
        validations = validations || this.validations;
        if (typeof validations == 'undefined') return val;
        setTimeout(() => {
            if ( ! validations[key]) {
                if (validations instanceof Array) {
                    validations[parseInt(key)] = {};
                }
                Vue.set(validations, key, {});
            }
            Vue.set(validations[key], field, Boolean(val));
        }, TIMEOUT);
        return val;
    },
    write(val, oldval, key, field, validations) {
        if ( ! key) return val;
        validations = validations || this.validations;
        if (typeof validations == 'undefined') return val;
        setTimeout(() => {
            if ( ! validations[key]) {
                if (validations instanceof Array) {
                    validations[parseInt(key)] = {};
                }
                Vue.set(validations, key, {});
            }
            Vue.set(validations[key], field, Boolean(val));
        }, TIMEOUT);
        return val;
    },
};
