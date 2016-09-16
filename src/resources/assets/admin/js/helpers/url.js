import page from 'page/index';
import _ from 'helpers/fp';
import dontLeave from 'helpers/dontLeave';
import sweetAlert from 'helpers/sweetAlert';
import vueInstanceProvider from 'providers/vueInstanceProvider';

// str -> str
export const stripslashes = txt => txt.replace(/^\/+/, '/');

// str => str
export const pageName = _.pipe(
    _.split('/'),
    _.reject(_.isEmpty),
    _.drop(2),
    _.head
);

export const urlInject = async url => {
    let vm = await vueInstanceProvider;

    return _.pipe(
        _.split('/'),
        _.map(part => part.startsWith("@") && _.path(_.split('.', part.substring(1)), vm) || part),
        _.join('/'),
    )(url);
}

export const externalLink = url => /^https?\:\/\//.test(url);
export const samePage = url => pageName(location.pathname) == pageName(url);
export const urlTarget = url => externalLink(url) ? '_blank' : '_self';
export const urlToHref = async (url, forceNotSamePage=false) => {
    let vm = await vueInstanceProvider;

    url = await urlInject(url);

    if (externalLink(url)) {
        return url;
    } else {
        return stripslashes(`/${url}${ (!forceNotSamePage && samePage(url)) ? location.search : ''}`);
    }
};
export const redirectUrl = async (url, forceNotSamePage=false) => {
    if (forceNotSamePage || ! samePage(url)) {
        $('html, body').animate({scrollTop: 0}, 100);
    }
    page(await urlToHref(url, forceNotSamePage));
};
export const goToUrl = async (url, forceNotSamePage=false) => {
    let vm = await vueInstanceProvider;

    if (externalLink(url)) {
        var newPage = open(await urlToHref(url, forceNotSamePage), urlTarget(url));
        newPage.opener = null;
    } else if ( ! onbeforeunload) {
        await redirectUrl(url, forceNotSamePage);
    } else {
        if (await sweetAlert(vm.t('attention'), onbeforeunload())) {
            await redirectUrl(url, forceNotSamePage);
            dontLeave.release();
        }
    }
}
