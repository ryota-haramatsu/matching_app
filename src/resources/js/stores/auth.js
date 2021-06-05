// https://www.hypertextcandy.com/vue-laravel-tutorial-authentication-part-3
// クッキーと HTTP ヘッダーを利用する方法
// クッキーからトークンを取り出して、HTTP ヘッダーに

// import Axios from "axios"

// そのトークンを含めてリクエストを送信
import { OK, UNPROCESSABLE_ENTITY } from '../util'
const state = {
    user: null,
    apiStatus: null,
    loginErrorMessages: null,
    registerErrorMessages: null
}

const getters = {
    check: state => !!state.user, // ログインチェック用
    username: state => state.user ? state.user.name : '',
}

// ステートの値を更新
const mutations = {
    setUser(state, user) {
        state.user = user
    },
    setApiStatus(state, status) {
        state.apiStatus = status
    },
    setLoginErrorMessages(state, messages) {
        state.loginErrorMessages = messages
    },
    setRegisterErrorMessages(state, messages) {
        state.registerErrorMessages = messages
    }
}

// 非同期
const actions = {
    // 第一引数 コンテキストオブジェクト
    // 会員登録
    async register(context, data) {
        context.commit('setApiStatus', null)

        // 会員登録APIを呼び出して返却データをsetUserミューテーションを実行
        // userステートを更新
        const response = await axios.post('/api/register', data)

        if (response.status === OK) {
            context.commit('setApiStatus', true)
            context.commit('setUser', response.data)
            return false
        }

        context.commit('setApiStatus', false)

        if (response.status === UNPROCESSABLE_ENTITY) {
            context.commit('setRegisterErrorMessages', response.data.errors)
        } else {
            context.commit('error/setCode', response.status, { root: true })
        }
    },

    // ログイン
    async login(context, data) {
        context.commit('setApiStatus', null)

        const response = await axios.post('/api/login', data)

        if (response.status === OK) {
            context.commit('setApiStatus', true)
            context.commit('setUser', response);
            return false
        }

        context.commit('setApiStatus', false)
        // バリデーションエラー422
        if (response.status === UNPROCESSABLE_ENTITY) {
            context.commit('setLoginErrorMessages', response.data.errors)
        } else {
            // あるモジュールから別のモジュールにミューテーションをcommitするときは{root:true}追加
            context.commit('error/setCode', response.status, { root: true })
        }
    },

    // ログアウト
    async logout(context) {
        context.commit('setApiStatus', null)

        const response = await axios.post('/api/logout')

        if (response.status === OK) {
            context.commit('setApiStatus', true)
            context.commit('setUser', null)
            return false
        }

        context.commit('setApiStatus', false)
        context.commit('error/setCode', response.status, { root: true })
    },

    // ログインチェック
    async currentUser(context) {
        context.commit('setApiStatus', null)

        const response = await axios.get('/api/user')
        const user = response.data || null

        if (response.status === OK) {
            context.commit('setApiStatus', true)
            context.commit('setUser', user)
            return false
        }

        context.commit('setApiStatus', false)
        context.commit('error/setCode', response.status, { root: true })
    }
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}
