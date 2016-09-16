import {curry, assoc, prop} from 'ramda';

export const setPropBy = curry((name, fn, obj) => assoc(name, fn(prop(name, obj)), obj));
