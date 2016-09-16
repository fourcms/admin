import reqwest from 'reqwest';
import bubble from 'helpers/bubble';
import _ from 'helpers/fp';
import auth from 'helpers/auth';
import {urlInject} from 'helpers/url';

import NProgress from 'nprogress';
NProgress.configure({
    showSpinner: false,
});
const defaultOpts = {
    type: 'json',
};

const HTTP_NO_CONTENT = 204;
const HTTP_BAD_REQUEST = 400;
const HTTP_NOT_FOUND = 404;
const HTTP_UNAUTHORIZED = 401;
const HTTP_FORBIDDEN = 403;
const HTTP_UNPROCESSABLE_ENTITY = 422;

var requestCount = 0;

function requestStart() {
    if (requestCount == 0) {
        NProgress.start();
    }
    requestCount++;
}

function requestEnd() {
    setTimeout(() => {
        requestCount--;
        if (requestCount <= 0) {
            NProgress.done();
        } else {
            NProgress.inc();
        }
    }, 100);
}

export async function httpRequest(opts) {
    const response = reqwest({
        ... defaultOpts,
        ... opts,
        url: await urlInject(opts.url),
    });
    requestStart();
    try {
        const data = await response;
        requestEnd();
        switch (response.request.status) {
            case HTTP_NO_CONTENT:
                return null;
            default:
                return data;
        }
    } catch (err) {
        requestEnd();
        switch (response.request.status) {
            case HTTP_UNAUTHORIZED:
                const authenticate = response.request.getResponseHeader('WWW-Authenticate');
                if (authenticate) {
                    await auth.relogin();
                    return httpRequest(opts);
                } else {
                    bubble.danger(
                        'თქვენ არ გაქვთ წვდომა ამ რესურსზე',
                        'დამატებითი ინფორმაციისთვის დაუკავშირდით ადმინისტრაციას');
                }
                break;
            case HTTP_UNPROCESSABLE_ENTITY:
                try {
                    const errors = JSON.parse(err.responseText);
                    if (typeof errors === 'object') {
                        bubble.error(errors);
                        break;
                    } else {
                        // fall through
                    }
                } catch (parseError) {
                    // fall through
                }
            case HTTP_NOT_FOUND:
                break;
            case HTTP_FORBIDDEN:
                bubble.danger(
                    'თქვენ არ გაქვთ წვდომა ამ რესურსზე',
                    'დამატებითი ინფორმაციისთვის დაუკავშირდით ადმინისტრაციას');
                break;
            case HTTP_BAD_REQUEST:
                try {
                    const {message} = JSON.parse(err.responseText);
                    if (typeof message === 'string') {
                        bubble.danger('სისტემური შეცდომა', message);
                        break;
                    } else {
                        // fall through
                    }
                } catch (parseError) {
                    // fall through
                }
            default:
                bubble.danger(
                    'სისტემური შეცდომა',
                    'დამატებითი ინფორმაციისთვის დაუკავშირდით ადმინისტრაციას');
        }
        console.error(err);
        throw err;
    }
}

export async function rawHTTPRequest(opts) {
    let response = reqwest(opts);
    try {
        await response;
        return response.request;
    } catch (err) {
        console.error(err);
        throw response.request
    }
}

export const request = _.curryN(2, async(method, url, data) => {
    return httpRequest({
        method, url, data: data || {},
    });
});

export const get = request('get');
export const post = request('post');
export const put = request('put');
export const del = request('delete');

export default module.exports;
