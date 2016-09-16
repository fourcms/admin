import vueInstanceProvider from 'providers/vueInstanceProvider';
import _ from 'helpers/fp';

export async function bubble(opts) {
    const vm = await vueInstanceProvider;
    // debugger;
    vm.$root.$refs.bubble.show(opts);
}

export const error = errors => {
    bubble({
        title: 'შეცდომა',
        errors,
        class: 'danger',
    });
};

export const message = _.curryN(2, (className, text1, text2=null) => {
    bubble({
        title: text2 !== null ? text1 : null,
        message: text2 !== null ? text2 : text1,
        class: className,
    });
});

export const success    = message('success');
export const info       = message('info');
export const warning    = message('warning');
export const danger     = message('danger');

export default module.exports;
