import mainProvider from './mainProvider';
import vueInstanceProvider from './vueInstanceProvider';
import textsProvider from './textsProvider';

class userStatusesProvider extends mainProvider {
    async fetch() {
        await textsProvider;
        const vm = await vueInstanceProvider;

        return [
            {
                id: 'site',
                name: vm.t('site'),
            }, {
                id: 'admin',
                name: vm.t('admin'),
            }, {
                id: 'global',
                name: vm.t('global'),
            },
        ];
    }
}

export default new userStatusesProvider;
