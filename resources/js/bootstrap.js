window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Content-Type'] = 'application/json';
axios.defaults.withCredentials = true;
axios.defaults.params = {};
if (process.env.MIX_APP_API_NAME_KEY) {
    axios.defaults.params['app'] = process.env.MIX_APP_API_NAME_KEY;
}

window.Pusher = require('pusher-js');
