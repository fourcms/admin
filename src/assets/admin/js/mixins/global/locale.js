import _ from 'helpers/fp';
import http from 'helpers/http';
import vueInstanceProvider from 'providers/vueInstanceProvider';
import Rx from 'rx';
import eventBus from 'helpers/eventBus';
import {sprintf} from 'sprintf-js';

var userStream = Rx.Observable.fromEvent(eventBus, 'user').filter(x => x);

var subject = new Rx.Subject();

var texts = subject
    .buffer(Rx.Observable.combineLatest(userStream, subject.debounce(500)))
    .map(_.uniq);

Rx.Observable.combineLatest(userStream, texts)
    .filter(_.pipe(_.prop(0), Boolean))
    .filter(_.pipe(_.prop(1), _.length))
    .map(_.prop(1))
    .forEach(async texts => {
        const vm = await vueInstanceProvider;

        if (vm.user) {
            await http.post(`/@params.lang/admin/api/text/autosave`, {
                scope: 'admin',
                lang: vm.params.lang,
                data: texts,
            });
        }
    });


export default {
    methods: {
        keyToText(key) {
            if (this.$root.locale) {
                if (typeof this.$root.locale[key] === 'undefined') {
                    this.$root.locale[key] = key;
                    subject.onNext(key);
                }
                return this.$root.locale[key];
            } else {
                return key;
            }
        },
        t(key, ...vars) {
            const text = this.keyToText(key);

            return sprintf(text, ...vars);
        },
    },
};
