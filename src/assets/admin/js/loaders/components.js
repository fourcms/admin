import {basename} from 'path';

const context = require.context('../', true, /\.vue$/);

var modules = context
    .keys()
    .reduce((obj, path, index) => {
        obj[basename(path, '.vue')] = context(path);
        return obj;
    }, {});

export default modules;
