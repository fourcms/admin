import _ from 'helpers/fp';
import page from 'page';
import qs from 'qs';
import vueInstanceProvider from 'providers/vueInstanceProvider';
import configProvider from 'providers/configProvider';

export const route = _.curry((vm, currentPage, context) => {
    context.title = vm.t(currentPage);

    vm.currentPage = currentPage;
    vm.context = context;
});

export const filterLang = ({langs, defaultLang}) => (context, next) => {
    if (langs.includes(context.params.lang)) {
        next();
    } else {
        page(`/${defaultLang}/admin`);
    }
}

export function query(context, next) {
    context.query = qs.parse(context.querystring);

    next();
}

export async function routes(fn) {
    const vm = await vueInstanceProvider;
    const config = await configProvider;

    page.base('/');

    page(':lang/admin', filterLang(config));
    page(':lang/admin/*', filterLang(config));
    page(':lang/admin/*', query);

    fn({
        route: route(vm),
        page,
    });

    page({ hashbang: false });
}

export default module.exports;
