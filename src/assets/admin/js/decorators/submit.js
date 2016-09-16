import _ from 'helpers/fp';
import Vue from 'vue';

/**
 * submit decorator - set submitting status and prevent from submitting twice
 * @param   {Number} [index]      index of submitted object in decorated function parameters (-1 means this)
 */
export default function submit(...args) {
    function decorator(index, targetClass, methodName, methodDescriptor) {
        var fn = methodDescriptor.value;
        methodDescriptor.value = function(...args) {
            var data = index === -1 ? this : args[index];
            return loading(data, 'submitting', false, async () => {
                return await Reflect.apply(fn, this, args);
            });
        };
    }

    if (args.length == 3) {
        decorator(0, ...args);
    } else {
        return _.partial(decorator, [args[0]]);
    }
}

export async function loading(data, key, finishStatus, fn) {
    if (! data[key]) {
        Vue.set(data, key, ! finishStatus);
        let response;

        try {
            response = await fn();
        } catch(err) {
            console.log(err);
        }

        Vue.set(data, key, finishStatus);
        return response;
    }
}
