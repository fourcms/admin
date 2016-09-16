import _ from 'helpers/fp';

export default class mainProvider {
    get() {
        if ( ! this.data) {
            this.data = this.fetch();
        }
        return this.data.then(data => {
            return data === null ? this.emptyValue() : data
        });
    }
    fetch() {}
    reset() {
        this.data = null;
    }
    set(data) {}
    then(fn) {
        return this.get().then(fn).catch(error => console.error(error));
    }
    emptyValue() {
        return [];
    }
    mixin(name, fn) {
        let providerInstance = this;
        return {
            data() {
                return {
                    [name]: providerInstance.emptyValue(),
                    [`${name}Loaded`]: false,
                }
            },
            created() {
                let vm = this;

                providerInstance.then(async data => {
                    if (typeof fn === 'function') {
                        let response = _.bind(fn, vm)(data, vm);
                        if (response instanceof Promise) {
                            vm[name] = await response;
                        } else {
                            vm[name] = response;
                        }
                    } else {
                        vm[name] = data;
                    }
                    vm[`${name}Loaded`] = true;
                });
            },
        };
    }
}
