import Vue from 'vue'
import VueRouter from 'vue-router'

// ページコンポーネントをインポートする
import Login from "./pages/Login";
import KyouanListComponent from "./components/KyouanListComponent";
import KyouanDetailComponent from "./components/KyouanDetailComponent";
import KyouanCreateComponent from "./components/KyouanCreateComponent";
import KyouanEditComponent from "./components/KyouanEditComponent";
import TeacherProfileComponent from "./components/TeacherProfileComponent";

// VueRouterプラグインを使用する
// これによって<RouterView />コンポーネントなどを使うことができる
Vue.use(VueRouter)

// パスとコンポーネントのマッピング
const routes = [
    {
        path: '/login',
        component: Login
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