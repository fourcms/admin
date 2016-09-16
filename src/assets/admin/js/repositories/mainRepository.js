import _ from 'helpers/fp';
import page from 'page';
import http from 'helpers/http';
import Vue from 'vue';
import qs from 'qs';
import bubble from 'helpers/bubble';
import vueInstanceProvider from 'providers/vueInstanceProvider';

export default class mainRepository {
    static newItem() {}
    static fields() {}

    static async item(id) {
        const item = await http.get(`${this.apiUrl}/${id}`);
        return this.itemTransform(item);
    }
    static async create(item) {
        const vm = await vueInstanceProvider;

        const responseData = await http.post(`${this.apiUrl}`, item);

        bubble.success(vm.t('item_create_success'));

        return this.itemTransform(responseData);
    }
    static async update(item) {
        const vm = await vueInstanceProvider;

        const responseData = await http.put(`${this.apiUrl}/${item.id}`, item);

        bubble.success(vm.t('item_update_success'));

        return this.itemTransform(responseData);
    }
    static async remove(item) {
        const vm = await vueInstanceProvider;

        const responseData = await http.del(`${this.apiUrl}/${item.id}`);

        bubble.success(vm.t('item_remove_success'));

        return this.itemTransform(responseData);
    }
    static async restore(item) {
        const vm = await vueInstanceProvider;

        const responseData = await http.put(`${this.apiUrl}/${item.id}/restore`);

        bubble.success(vm.t('item_restore_success'));

        return this.itemTransform(responseData);
    }
    static async list(prop, vm) {
        return new this(prop, vm);
    }
    constructor(prop, vm, extended=false) {
        this.apiUrl = this.constructor.apiUrl;
        this.url = this.constructor.url;
        this.title = this.constructor.title;
        this.searchConfiguration = this.constructor.searchConfiguration;

        this.vm = vm;
        this.loaded = false;
        this.prop = prop;
        this.params = this.parseLocationSearch();
        this.loadedParams = null;
        this.notFound = false;
        this.total = 0;

        Vue.set(this.vm, prop, this);

        this.vm.$watch('$root.context.query', () => {
            const params = this.parseLocationSearch();

            if (JSON.stringify(this.params) != JSON.stringify(params)) {
                this.params = params;
            }
        }, { immediate: false, deep: true });

        this.vm.$watch(`${this.prop}.params`, this.paramsWatcher.bind(this), { immediate: true, deep: true });
    }
    static itemsTransform(items) {
        return _.map(this.itemTransform, items);
    }
    static itemTransform(item) {
        return item;
    }

    resetParams() {
        this.params = this.filterParams();
    }

    paramsWatcher() {
        let loadedParams = _.clone(this.loadedParams);
        let params = _.clone(this.parseParams(this.params));

        let haveParamsLoaded = _.equals(loadedParams, params);

        page(`${location.pathname}${this.query()}`);

        if ( ! haveParamsLoaded) {
            if (this.loadedParams
                && ( this.params.q && this.params.q != this.loadedParams.search )
                && this.params.p > 1) {
                this.params.p = 1;
            } else {
                this.retrieve(this.params);
            }
        }
    }

    static searchConfiguration = {
        perPage: {
            default: 15,
            read: parseInt,
        },
        page: {
            default: 1,
            read: parseInt,
        },
        sortBy: {
            default: '',
            serialize(params) {
                if (params.sortBy && params.sortOrder) {
                    params.sortBy = `${params.sortBy}:${params.sortOrder}`;
                } else {
                    Reflect.deleteProperty(params, 'sortBy');
                }

                Reflect.deleteProperty(params, 'sortOrder');

                return params;
            },
            urlify(params) {
                if (params.sortBy && params.sortOrder) {
                    params.sortBy = `${params.sortBy}:${params.sortOrder}`;
                } else {
                    Reflect.deleteProperty(params, 'sortBy');
                }

                Reflect.deleteProperty(params, 'sortOrder');

                return params;
            },
            parse(params) {
                if (params.sortBy) {
                    [params.sortBy, params.sortOrder] = params.sortBy.split(':');
                }
                return params;
            },
        },
        sortOrder: {
            default: '',
        },
        search: {
            default: '',
        },
    }

    filterParams(params={}) {
        return _.pipe(
            _.merge(_.pluck('default', this.searchConfiguration)),
            _.setPropsBy(_.pipe(_.pluck('read'), _.filter(_.identity))(this.searchConfiguration)),
        )(params);
    }
    parseParams(params) {
        params = this.filterParams(params);

        for (const key in this.searchConfiguration) {
            if (this.searchConfiguration[key].serialize) {
                params = this.searchConfiguration[key].serialize(params);
            }

            if ( ! this.searchConfiguration[key].dontRemove && params[key] === this.searchConfiguration[key].default) {
                Reflect.deleteProperty(params, key);
            }
        }

        return params;
    }
    parseLocationSearch() {
        var params = this.filterParams(this.vm.query);
        params = _.pick(Object.keys(this.searchConfiguration), params);

        for (const key in this.searchConfiguration) {
            if (this.searchConfiguration[key].parse) {
                params = this.searchConfiguration[key].parse(params);
            }
        }

        return params;
    }
    query() {
        var params = _.clone(this.params);

        for (const key in this.searchConfiguration) {
            if (this.searchConfiguration[key].urlify) {
                params = this.searchConfiguration[key].urlify(params);
            }

            if (params[key] === this.searchConfiguration[key].default) {
                Reflect.deleteProperty(params, key);
            }
        }

        var paramsString = qs.stringify(params);

        paramsString = paramsString.replace(/%3A/g, ':');

        if (paramsString) {
            return `?${paramsString}`;
        } else {
            return '';
        }
    }

    async retrieve(params) {
        params = this.parseParams(params)
        Vue.set(this, 'loaded', false);

        Vue.set(this, 'loadedParams', _.clone(params));

        let response = await http.get(this.apiUrl, params);
        try {
            var data = this.constructor.itemsTransform(response.data || []);

            Vue.set(this, 'total', response.total);
            Vue.set(this, 'loaded', true);
            Vue.set(this, 'data', data);
            Vue.set(this, 'loadedParams', _.clone(params));
            Vue.set(this, 'notFound', false);
        } catch (err) {
            Vue.set(this, 'total', 0);
            Vue.set(this, 'loaded', true);
            Vue.set(this, 'notFound', true);
            Vue.set(this, 'data', []);
            Vue.set(this, 'loadedParams', _.clone(params));
            console.error(err);
        }
    }

    remove(e, index) {
        e.preventDefault();
        e.stopImmediatePropagation();
        if (this.data[index].create) {
            if (index == this.index) {
                this.index = null;
            }
            this.data.splice(index, 1);

            if (this.index === null) {
                page(this.url);
            } else {
                this.index = this.data.indexOf(this.item);
            }
        }
    }
}
