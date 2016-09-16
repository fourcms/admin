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

window.raven = require('raven-js');

raven
    .config('https://c290e01959494176ab5d8bdd17e00b4c@app.getsentry.com/94616')
    .install();
