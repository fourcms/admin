import {v4 as id} from 'uuid';

export default function hotKeyMixin(fn) {
    return {
        data() {
            return {
                id: id(),
            };
        },
        created() {
            $('body').off(`keyup.id-${this.id}`).on(`keyup.id-${this.id}`, e => {
                if (   e.target.tagName !== 'INPUT'
                    && e.target.tagName !== 'TEXTAREA'
                    && ! e.ctrlKey) {
                    Reflect.apply(fn, this, [e]);
                }
            });
        },
        beforeDestroy() {
            $('body').off(`keyup.id-${this.id}`);
        },
    };
}
