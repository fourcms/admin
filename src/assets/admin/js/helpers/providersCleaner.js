import eventBus from 'helpers/eventBus';
import providers from 'loaders/providers';
import _ from 'helpers/fp';

const keys = _.pipe(
    _.keys,
    _.reject,
    _.contains(_.__, ['mainProvider', 'vueInstanceProvider'])
)(providers);

eventBus.on('user', async user => {
    if (user === null) {
        for (const i in  keys) {
            providers[i].reset();
        }
    }
});
