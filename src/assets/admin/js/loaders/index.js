import Vue from 'vue';
import {basename} from 'path';

const context = require.context('./', true, /^((?!index).)*\.js$/);

var modules = context
    .keys()
    .reduce((obj, path, index) => {
        obj[basename(path, '.js')] = context(path);
        return obj;
    }, {});

for (let key in modules.globalMixins) {
    Vue.mixin(modules.globalMixins[key]);
}

for (let key in modules.directives) {
    Vue.directive(key, modules.directives[key]);
}

for (let key in modules.filters) {
    Vue.filter(key, modules.filters[key]);
}

for (let key in modules.components) {
    Vue.component(key, modules.components[key]);
}

export default modules;
