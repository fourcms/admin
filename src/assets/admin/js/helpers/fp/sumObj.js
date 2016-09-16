import {values, pipe, sum, map, reject} from 'ramda';

export const sumObj = pipe(values, map(parseFloat), reject(isNaN), sum);
