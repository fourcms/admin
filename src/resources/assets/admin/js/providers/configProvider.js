import mainProvider from './mainProvider';
import http from 'helpers/http';

class configProvider extends mainProvider {
    async fetch() {
        const config = await http.get(`/en/admin/api/config/public`);

        config.debug = config.debug === 'true';
        config.langs = config.langs.split(',');

        return config;
    }
}

export default new configProvider;
