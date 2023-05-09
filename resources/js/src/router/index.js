

import {createRouter, createWebHistory}  from 'vue-router'


const routes = [

    {
        path:'/',
        name:"homepage",
        component:()=>import('../pages/Index.vue'),
    },

    {
        path:'/test',
        name:"test",
        component:()=>import('../components/Kinban-App/Test.vue'),
    },

    {
        path:'/kinban-app',
        name:"kinban-login",
        component:()=>import('../pages/auth/login.vue'),
    },

    {
        path:'/kinban-app/register',
        name:"kinban-register",
        component:()=>import('../pages/auth/register.vue'),
    },

    {
        path:'/kinban-app/projects',
        name:"manage-projects",
        component:()=>import('../pages/kinban-App/Project/Index.vue'),
    },
    {
        path:'/kinban-app/projects/:ref/browse',
        name:"show-project",
        component:()=>import('../pages/kinban-App/Project/Show.vue'),
    },

]

const router = createRouter({
    history:createWebHistory(),
    routes
})



export default router
