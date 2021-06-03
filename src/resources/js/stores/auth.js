// https://www.hypertextcandy.com/vue-laravel-tutorial-authentication-part-3
// クッキーと HTTP ヘッダーを利用する方法
// クッキーからトークンを取り出して、HTTP ヘッダーに

import Axios from "axios"

// そのトークンを含めてリクエストを送信
const state = {
    user: null
}

const getters = {
    check: state => !!state.user, // ログインチェック用
    username: state => state.user ? state.user.name : ''
}

// ステートの値を更新
const mutations = {
    setUser(state, user) {
        state.user = user
    }
}

// 非同期
const actions = {
    // 第一引数 コンテキストオブジェクト
    async register(context, data) {
        // 会員登録APIを呼び出して返却データをsetUserミューテーションを実行
        // userステートを更新
        const response = await axios.post('/api/register', data)
        context.commit('setUser', response.data)
    },

    async login(context, data) {
        const response = await axios.post('/api/login', data)
        //失敗したときの処理
        context.commit('setUser', response.data)
    },

    async logout(context) {
        await axios.post('/api/logout')
        context.commit('setUser', null)
    }
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}
