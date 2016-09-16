import {environment} from 'helpers/app';

export function reportException(e) {
    console.error(e);

    if (environment == 'production') {
        window.raven.captureException(e);
    }
}

window.addEventListener('error', e => {
    reportException(e);
});
