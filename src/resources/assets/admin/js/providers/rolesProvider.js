import mainProvider from './mainProvider';
import vueInstanceProvider from './vueInstanceProvider';
import http from 'helpers/http';
import _ from 'helpers/fp';

class rolesProvider extends mainProvider {
    async fetch() {
        const {data} = await http.get(`/@params.lang/admin/api/role`);
        return _.map(_.pickAllAs({display_name: 'name', id: 'id'}), data);
    }
}

export default new rolesProvider;
