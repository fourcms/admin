import {pipe, prepend, toPairs, map, fromPairs} from 'ramda';

export const providerToKeyValue = pipe(
    prepend({id: 0, name: 'არ აქვს'}),
    toPairs,
    map(([key, val]) => [val.id, val.name]),
    fromPairs
);
