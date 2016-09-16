import {curry, pickAll, keys} from 'ramda';
import {renameAll} from './renameAll';

export const pickAllAs = curry((names, obj) => renameAll(names, pickAll(keys(names), obj)));
