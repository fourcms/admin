import {curry, mapObjIndexed, propOr, clone} from 'ramda';

export const setPropsBy = curry((names, obj) => mapObjIndexed((value, key, obj) => propOr(clone, key, names)(value), obj));
