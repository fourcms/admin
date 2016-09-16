import R from 'ramda';

// Number -> [Number]
export const binToArray = R.pipe(
    num => num.toString(2),
    R.split(''),
    R.reverse,
    R.toPairs,
    R.filter(R.propEq(1, '1')),
    R.pluck(0),
    R.map(val => parseInt(`1${'0'.repeat(parseInt(val))}`, 2))
);
