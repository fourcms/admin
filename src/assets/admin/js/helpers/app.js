export function getMeta(name, type='string') {
    const elem = document.getElementsByName(name)[0];

    if (elem) {
        const content = elem.content;

        switch (type) {
            case 'boolean':
                return content === 'true';
            case 'array':
                return content.split(',');
            case 'string':
            default:
                return content;
        }
    } else {
        return null;
    }
}

export const langs = getMeta('app:langs', 'array');
export const defaultLang = getMeta('app:default_lang');
export const environment = getMeta('app:environment');
export const debug = getMeta('app:debug', 'boolean');
export const pusherKey = getMeta('app:pusher_key');

export default module.exports;
