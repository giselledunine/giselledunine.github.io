import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        name: 'Home',
        // component: Home
        components: {
            default: () => import(/* webpackChunkName: "home" */ '../components/Home'),
        },
    },
    {
        path: '/informations',
        name: 'Informations',
        components: {
            default: () => import(/* webpackChunkName: "home" */ '../views/Informations'),
        },
    },

]

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})
export default router