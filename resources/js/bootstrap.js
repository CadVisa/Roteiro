import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import $ from 'jquery';
window.$ = $;
window.jQuery = $;

import 'bootstrap';
import 'jquery-mask-plugin';
import autosize from 'autosize';

window.autosize = autosize;

