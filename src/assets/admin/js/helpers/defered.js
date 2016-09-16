export default function defered() {
    var resolve = null;
    var reject = null;
    var promise = new Promise((_resolve, _reject) => {
        resolve = _resolve;
        reject = _reject;
    });
    return {resolve, reject, promise};
}
