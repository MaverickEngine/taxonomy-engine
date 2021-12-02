import Axios from 'axios';

const axios = Axios.create({
    headers: {
        'Content-Type': 'application/json',
        'X-WP-Nonce': taxonomyengine_wpnonce
    }
});

export {axios};