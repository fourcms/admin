import {basename} from 'path';

const context = require.context('../filters/', true, /\.js$/);

var modules = context
    .keys()
    .reduce((obj, path, index) => {
        obj[basename(path, '.js')] = context(path);
        return obj;
    }, {});

export default modules;
