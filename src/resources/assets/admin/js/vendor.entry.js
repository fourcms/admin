require('babel-polyfill');
window.$ = window.jQuery = require('jquery');
require('bootstrap');
require('admin-lte');

import {SENTRY_DSN} from 'helpers/env';

window.raven = require('raven-js');

if (SENTRY_DSN) {
    raven
        .config(SENTRY_DSN)
        .install();
}

