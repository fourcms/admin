import mainProvider from './mainProvider';
import http from 'helpers/http';
import _ from 'helpers/fp';
import vueInstanceProvider from './vueInstanceProvider';
import textsProvider from './textsProvider';

function filterItems(items, permissions) {
    return _.filter(item => {
        var has = item.permission === null || _.find(_.propSatisfies(_.glob(item.permission), 'name'), permissions);
        if (has && item.items && item.items.length) {
            item.items = filterItems(item.items, permissions);
            if (Array.isArray(item.items) && item.items.length === 0) {
                has = false;
            }
        }
        return has;
    }, items);
}

class navigationProvider extends mainProvider {
    async fetch() {
        await textsProvider;
        const vm = await vueInstanceProvider;

        const items = [
            {
                name: vm.t('dashboard'),
                url: '/@params.lang/admin/dashboard',
                icon: 'dashboard',
                permission: null,
                items: [],
            },
            {
                name: vm.t('users'),
                url: '/@params.lang/admin/user',
                icon: 'users',
                permission: 'user.*',
                items: [],
            },
            {
                name: vm.t('texts'),
                url: '/@params.lang/admin/text',
                icon: 'globe',
                permission: 'text.*',
                items: [],
            },
        ];

        try {
            return filterItems(_.clone(items), vm.user.permissions);
        } catch (err) {
            console.error(err);
            return [];
        }
    }
}

export default new navigationProvider;
