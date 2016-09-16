import {curry, zipObj, map, keys, values} from 'ramda';

// mapKeys :: (String -> String) -> {String: a} -> {String: a}
export const mapKeys = curry((fn, obj) => zipObj(map(fn, keys(obj)), values(obj)));
