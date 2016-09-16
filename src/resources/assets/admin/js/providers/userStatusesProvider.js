import mainProvider from './mainProvider';
import vueInstanceProvider from './vueInstanceProvider';
import http from 'helpers/http';

class userStatusesProvider extends mainProvider {
    async fetch() {
        let vm = await vueInstanceProvider;

        return http.get(`/@params.lang/admin/api/user/statuses`);
    }
}

export default new userStatusesProvider;
