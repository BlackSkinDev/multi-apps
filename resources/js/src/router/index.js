

import {createRouter, createWebHistory}  from 'vue-router'


const routes = [

    {
        path:'/',
        name:"homepage",
        component:()=>import('../pages/Index.vue'),
        meta: {
            redirectIfAuthenticated: true
        }
    },

    {
        path:'/test',
        name:"test",
        component:()=>import('../components/Test.vue'),
    },

    {
        path:'/signin',
        name:"signin",
        component:()=>import('../pages/auth/login.vue'),
        meta: {
            redirectIfAuthenticated: true
        }
    },

    {
        path:'/dashboard',
        name:"dashboard",
        component:()=>import('../pages/dashboard/Index.vue'),
        meta: {
            requiresAuth: true
        }
    },



]

const router = createRouter({
    history:createWebHistory(),
    routes
})

router.beforeEach(async (to, from, next) => {
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
    const redirectIfAuthenticated = to.matched.some(record => record.meta.redirectIfAuthenticated);
    const user_is_logged_in =  localStorage.getItem('logged_in')
    if (requiresAuth) {
        if (!user_is_logged_in) {
            next({ name: 'signin' });
        } else {
            next();
        }
    } else if (redirectIfAuthenticated) {
        if (user_is_logged_in) {
            next({ name: 'dashboard' });
        } else {
            next();
        }
    } else {
        next();
    }
});




export default router
