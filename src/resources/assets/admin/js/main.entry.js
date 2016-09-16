import 'admin/helpers/disableConsole';
import 'helpers/errorReporting';
import Vue from 'vue';
import 'routes';
import vueInstanceProvider from 'providers/vueInstanceProvider';

// import 'helpers/notification';
// import 'helpers/providersCleaner';

Vue.config.debug = true;
Vue.config.silent = false;
// Vue.config.strict = false;

import app from 'views/app';

var root = new Vue(app);

vueInstanceProvider.set(root);
