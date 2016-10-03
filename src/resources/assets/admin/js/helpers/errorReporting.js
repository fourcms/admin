import configProvider from 'providers/configProvider';

export async function reportException(e) {
    const {environment} = await configProvider;
    console.error(e);

    if (environment == 'production') {
        window.raven.captureException(e);
    }
}

window.addEventListener('error', e => {
    reportException(e);
});
