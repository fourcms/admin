require('babel-polyfill');
window.$ = window.jQuery = require('jquery');
// require('jquery-ui');
require('bootstrap');
require('admin-lte');
// require('select2');
// require('bootbox');
// require('maskedinput');
// window.moment = require('moment/moment.js');
// require('imports?define=>false&exports=>false&require=>false!eonasdan-bootstrap-datetimepicker');
// require('imports?define=>false&exports=>false&require=>false!daterangepicker');
// import 'helpers/app';

import {SENTRY_DSN} from 'helpers/env';


window.raven = require('raven-js');

if (SENTRY_DSN) {
    raven
        .config(SENTRY_DSN)
        .install();
}

