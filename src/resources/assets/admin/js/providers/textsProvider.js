import mainProvider from './mainProvider';
import http from 'helpers/http';

class textsProvider extends mainProvider {
    async fetch() {
        return http.get(`/@params.lang/admin/api/text/translations`);
    }
}

export default new textsProvider;
