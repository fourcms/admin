import R from 'ramda';

const context = require.context('./', true, /^((?!index).)*\.js$/);

var modules = context
    .keys()
    .reduce((obj, path, index) => {
        return Object.assign(obj, context(path));
    }, {});

export default Object.assign({}, R, modules);
