import {curry, propOr} from 'ramda';
import {mapKeys} from './mapKeys';

export const renameAll = curry((names, obj) => mapKeys((key) => propOr(key, key, names), obj));
