import { createRouter, createWebHistory } from 'vue-router';
import Home from './component/Home.vue';
import Account from './component/Account.vue'; 
import Users from './component/Users.vue'; 
import Login from './template/Login.vue'; 
import store from './store';

const routes = [
    {
        path: '/login',
        name: 'login',
        component: Login,
        beforeEnter: (to,from,next) => {
            !store.state.session ? next() : next({name: 'users'})
        }
    },
    {
        path: '/home',
        name: 'home',
        component: Home
    },
    {
        path: '/account',
        name: 'account',
        component: Account
    },
    {
        path: '/users',
        name: 'users',
        component: Users
    },
    // Add other routes here
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// router.beforeEach((to, from,next) => {
//     if(!$store.state.session && to.name !=='login'){
//         next({name: 'login'})
//     }else {
//         next()
//     }
// })

export default router;