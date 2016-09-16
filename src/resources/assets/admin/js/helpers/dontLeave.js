import vueInstanceProvider from 'providers/vueInstanceProvider';

export async function hold() {
    const vm = await vueInstanceProvider;
    console.debug('dontLeave: hold');
    window.onbeforeunload = () => vm.t('dont_leave');
}

export function release() {
    console.debug('dontLeave: release');
    window.onbeforeunload = null;
}

export default module.exports;
