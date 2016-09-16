import {curry} from 'ramda';

export const inRange = curry((num, min, max) => num >= min && num <= max);
