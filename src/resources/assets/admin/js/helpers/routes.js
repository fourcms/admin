import _ from 'helpers/fp';
import page from 'page';
import qs from 'qs';
import vueInstanceProvider from 'providers/vueInstanceProvider';
import {langs, defaultLang} from 'helpers/app';

export const route = _.curry((vm, currentPage, context) => {
    context.title = vm.t(currentPage);

    vm.currentPage = currentPage;
    vm.context = context;
});

export function filterLang(context, next) {
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

    page.base('/');

    page(':lang/admin', filterLang);
    page(':lang/admin/*', filterLang);
    page(':lang/admin/*', query);

    fn({
        route: route(vm),
        page,
    });

    page({ hashbang: false });
}

export default module.exports;
