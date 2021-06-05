import { getCookieValue } from './util'
window._ = require('lodash');

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) { }



window.axios = require('axios');

// Ajaxリクエストであることを示すヘッダーを付与する
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.axios.interceptors.request.use(config => {
    // クッキーからトークンを取り出してヘッダーに添付する
    // トークンをX-XSRF-TOKENヘッダーに入れることでCSRF トークンチェックを行う
    config.headers['X-XSRF-TOKEN'] = getCookieValue('XSRF-TOKEN')

    return config
})

// レスポンスを受けた後の処理
window.axios.interceptors.response.use(
    response => response, //成功時はそのまま
    error => error.response || error // await/catchパターンの重複をなくすため
)
