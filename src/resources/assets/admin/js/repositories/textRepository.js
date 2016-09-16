import mainRepository from 'repositories/mainRepository';
import http from 'helpers/http';

export default class textRepository extends mainRepository {
    static apiUrl = '/@params.lang/admin/api/text';
    static url = '/@params.lang/admin/text';
    static title = 'texts';

    static async update(item) {
        const responseData = await http.put(`${this.apiUrl}`, item);
        return this.itemTransform(responseData);
    }

    static itemTransform(item) {
        if (item.key) {
            item.changed = false;
            item.submitting = false;
        } else {
            for (const lang in item) {
                item[lang].changed = false;
                item[lang].submitting = false;
            }
        }

        return item;
    }

    static searchConfiguration = {
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
        scope: {
            default: 'site',
            dontRemove: true,
        },
    }
}
