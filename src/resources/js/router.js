import Vue from 'vue'
import VueRouter from 'vue-router'
import store from './stores'

// ページコンポーネントをインポートする
import Login from "./pages/Login";
import KyouanListComponent from "./components/KyouanListComponent";
import KyouanDetailComponent from "./components/KyouanDetailComponent";
import KyouanCreateComponent from "./components/KyouanCreateComponent";
import KyouanEditComponent from "./components/KyouanEditComponent";
import TeacherProfileComponent from "./components/TeacherProfileComponent";
import SystemError from "./pages/System"

// VueRouterプラグインを使用する
// これによって<RouterView />コンポーネントなどを使うことができる
Vue.use(VueRouter)

// パスとコンポーネントのマッピング
const routes = [
    {
        path: '/login',
        component: Login,
        // ルートにアクセスされてコンポーネントが切り替わる直前に呼び出す
        beforeEnter(to, from, next) {
            if (store.getters['auth/check']) {
                // ログイン状態なら一覧画面へ遷移
                next('/kyouan/list')
            } else {
                next() // 引数なしならそのままloginコンポーネントを表示
            }
        }
    },
    {
        path: '/kyouan/list',
        name: 'kyouan.list',
        component: KyouanListComponent
    },
    {
        path: '/kyouan/create',
        name: 'kyouan.create',
        component: KyouanCreateComponent
    },
    {
        path: '/kyouan/:kyouanId',
        name: 'kyouan.show',
        component: KyouanDetailComponent,
        props: true

    },
    {
        path: '/kyouan/:kyouanId/edit',
        name: 'kyouan.edit',
        component: KyouanEditComponent,
        props: true
    },
    {
        path: '/teacher/:teacherId/profile',
        name: 'teacher.profile',
        component: TeacherProfileComponent,
        props: true
    },
    {
        path: '/500',
        component: SystemError
    }
]

// VueRouterインスタンスを作成する
const router = new VueRouter({
    mode: 'history',
    routes
})

// VueRouterインスタンスをエクスポートする
// app.jsでインポートするため
export default router