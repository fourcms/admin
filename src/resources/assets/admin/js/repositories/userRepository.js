import mainRepository from 'repositories/mainRepository';
import _ from 'helpers/fp';

export default class userRepository extends mainRepository {
    static apiUrl = '/@params.lang/admin/api/user';
    static url = '/@params.lang/admin/user';
    static title = 'users';
    static newItem() {
        return this.itemTransform({
            firstname: '',
            lastname: '',
            email: '',
            mobile_phone: '',
            address: '',
            password: '',
            password_confirmation: '',
            status: 1,
            role_id: 1,
        });
    }
    static itemTransform(item) {
        item.fullname = `${item.firstname} ${item.lastname}`;
        item.password = '';
        item.password_confirmation = '';

        return item;
    }
    static searchConfiguration = {
        perPage: {
            default: 15,
            read: parseInt,
            dontRemove: true,
        },
        page: {
            default: 1,
            read: parseInt,
        },
        sortBy: {
            default: '',
            serialize(params) {
                if (params.sortBy && params.sortOrder) {
                    if (params.sortBy == 'fullname') {
                        params.sortBy = `firstname:${params.sortOrder},lastname:${params.sortOrder}`;
                    } else {
                        params.sortBy = `${params.sortBy}:${params.sortOrder}`;
                    }
                } else {
                    Reflect.deleteProperty(params, 'sortBy');
                }

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
        status: {
            default: 0,
            read: parseInt,
        },
        role_id: {
            default: 0,
            read: parseInt,
        },
        trashed: {
            default: 0,
            serialize(params) {
                params.trashed = params.trashed ? '1' : 0;

                return params;
            },
            urlify(params) {
                params.trashed = params.trashed ? '1' : 0;

                return params;
            },
        },
    }

    static async update(item) {
        // this needs to be changed (but works for now)
        const itemForSave = _.pickAll([
            'id',
            'email',
            'password',
            'password_confirmation',
            'firstname',
            'lastname',
            'status',
            'role_id',
            // 'country_id',
            'mobile_phone',
            'gender',
            // 'birth_date',
            'address',
        ], item);

        return super.update(itemForSave);
    }
}
