import {readFileSync} from 'fs';
import {parse} from 'ini';

const {APP_NODE_PORT, SENTRY_DSN} = parse(readFileSync('.env', 'utf-8'));

export default {
    APP_NODE_PORT,
    SENTRY_DSN: sentryUrl(SENTRY_DSN)
};

function sentryUrl (url) {
	try {
	    const [http, part1, part2] = url.split(':');
	    const [part2_1, part2_2] = part2.split('@');

	    return `${http}:${part1}@${part2_2}`;
	} catch(err) {
		return '';
	}
}
