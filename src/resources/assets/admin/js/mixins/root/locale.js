import locale from 'mixins/global/locale';
import textsProvider from 'providers/textsProvider';
import moment from 'moment';

export default {
    mixins: [locale],
    data() {
        return {
            locale: undefined,
            lang: null,
        };
    },
    watch: {
        'params.lang': {
            async handler(lang) {
                if (lang != this.lang) {
                    this.lang = lang;

                    document.documentElement.setAttribute('lang', lang);

                    moment.locale(lang === 'ge' ? 'ka' : lang);

                    textsProvider.reset();

                    this.locale = await textsProvider.get();
                }
            },
            immediate: true,
        }
    },
};
