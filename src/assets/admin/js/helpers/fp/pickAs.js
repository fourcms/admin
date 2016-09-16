import {curry, pick, keys} from 'ramda';
import {renameAll} from './renameAll';

export const pickAs = curry((names, obj) => renameAll(names, pick(keys(names), obj)));
