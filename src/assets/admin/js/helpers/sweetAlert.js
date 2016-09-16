import swal from 'swal';
import vueInstanceProvider from 'providers/vueInstanceProvider';

export default async function sweetAlert(title, text, type='warning') {
    const vm = await vueInstanceProvider;
    return new Promise((resolve, reject) => {
        swal({
            title,
            text,
            type,
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: vm.t('yes'),
            cancelButtonText: vm.t('no'),
        }, resolve);
    });
}
