import {curry, prop, contains} from 'ramda';

export const propInArray = curry((name, arr, obj) => contains(prop(name, obj), arr));
