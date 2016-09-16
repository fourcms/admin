import defered from 'helpers/defered';
import mainProvider from './mainProvider';

class vueInstanceProvider extends mainProvider {
    constructor() {
        super();
        this.reset();
    }
    get() {
        return this.data.promise;
    }
    reset() {
        this.data = defered();
    }
    set(data) {
        this.data.resolve(data);
    }
}

export default new vueInstanceProvider;
