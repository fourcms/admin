import {curry} from 'ramda';
import {renameAll} from './renameAll';

export const rename = curry((name, newName, obj) => renameAll({[name]: newName}, obj));
