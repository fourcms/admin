import http from 'helpers/http';
import bubble from 'helpers/bubble';
import vueInstanceProvider from 'providers/vueInstanceProvider';
import page from 'page';
import qs from 'qs';
import eventBus from 'helpers/eventBus';
import {goToUrl} from 'helpers/url';
// import {APP_NODE_PORT} from 'helpers/env';

export async function login(email, password) {
    var vm = await vueInstanceProvider;

    let user = await http.post(`/${vm.params.lang || 'en'}/admin/api/auth/login`, {
        email: email,
        password: password,
    });

    setUser(user);

    getAvatar(user);

    return user;
}
export async function getAvatar(user) {
    var vm = await vueInstanceProvider;

    try {
        const response = await http.rawHTTPRequest({
            method: 'get',
            url: `/${vm.params.lang || 'en'}/admin/api/auth/avatar`,
        });

        const {avatar} = JSON.parse(response.responseText);

        user.avatar = avatar;
    } catch (err) {
        console.error(err);
    }

    return user;
}



export async function loginAs(userId) {
    const user = await http.get(`/@params.lang/admin/api/user/loginas/${userId}`);

    setUser(user);
    getAvatar(user);

    goToUrl('@params.lang/admin/dashboard');

    return user;
}
export async function logoutAs() {
    const user = await http.get(`/@params.lang/admin/api/user/logoutas`);

    setUser(user);
    getAvatar(user);

    goToUrl('@params.lang/admin/dashboard');

    return user;
}

export async function relogin() {
    var vm = await vueInstanceProvider;

    return await vm.$root.$refs.loginModal.login();
}

export async function redirectToLogin() {
    var vm = await vueInstanceProvider;

    var path = location.pathname + location.search;
    if (path != `/${vm.params.lang || 'en'}/admin/dashboard`) {
        page.redirect(`/${vm.params.lang || 'en'}/admin/login?redirect=${encodeURIComponent( path )}`);
    } else {
        page.redirect(`/${vm.params.lang || 'en'}/admin/login`);
    }
}

export async function redirectFromLogin() {
    var vm = await vueInstanceProvider;

    let queryParams = qs.parse(location.search.substring(1));
    var url = queryParams.redirect || `/${vm.params.lang || 'en'}/admin`;

    if (url.startsWith(location.origin)) {
        url = url.slice(location.origin.length);
    }

    page.redirect(url);
}

export async function user() {
    var vm = await vueInstanceProvider;
    try {
        let response = await http.rawHTTPRequest({
            url: `/${vm.params.lang || 'en'}/admin/api/auth/user`,
            type: 'json',
        });
        setUser(JSON.parse(response.responseText));
        if (vm.currentPage === 'login') {
            page.redirect(`/${vm.params.lang || 'en'}/admin`);
        }
        vm.loaded = true;
    } catch (response) {
        var authenticate = response.getResponseHeader('WWW-Authenticate');
        if (authenticate) {
            if (vm.currentPage != 'login') redirectToLogin();
            vm.loaded = true;
        } else {
            bubble.danger(
                'სისტემური შეცდომა',
                'დამატებითი ინფორმაციისთვის დაუკავშირდით ადმინისტრაციას');
        }
    }
}

export async function setUser(user) {
    var vm = await vueInstanceProvider;
    vm.user = user;

    if (typeof raven != 'undefined') {
        raven.setUserContext({
            ... userCompact(user),
            loginasData: user.loginasData ? userCompact(user.loginasData) : null,
        });
    }

    if (typeof io != 'undefined') {
        vm.socket = io(`ws://${location.host}:${APP_NODE_PORT}`);
    }

    eventBus.emit('user', user);
}

export async function logout() {
    var vm = await vueInstanceProvider;

    try {
        await http.get(`/${vm.params.lang || 'en'}/admin/api/auth/logout`);
        setUser(null);

        page.redirect(`/${vm.params.lang || 'en'}/admin/login`);
    } catch (err) {
        console.error(err);
    }
}

function userCompact({id, firstname, lastname, email}) {
    return {id, firstname, lastname, email};
}

export default module.exports;
