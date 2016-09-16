import {curry, pluck, pipe, sum} from 'ramda';

export const sumOf = curry((name, arr) => pipe(pluck(name), sum)(arr));
