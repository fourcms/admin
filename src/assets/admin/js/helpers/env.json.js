import {readFileSync} from 'fs';
import {parse} from 'ini';

const {APP_NODE_PORT} = parse(readFileSync('.env', 'utf-8'));

export default {APP_NODE_PORT};
