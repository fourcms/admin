import minimatch from 'minimatch';
import {curry} from 'ramda';

export const glob = curry((pattern, key) => minimatch(key, pattern));

