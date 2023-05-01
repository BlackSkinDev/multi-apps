

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
        name:"kinban",
        component:()=>import('../pages/Kinban-App/Index.vue'),
    },

    {
        path:'/kinban-app/projects',
        name:"manage-projects",
        component:()=>import('../pages/Kinban-App/Project/Index.vue'),
    },
    {
        path:'/kinban-app/projects/:reference',
        name:"show-project",
        component:()=>import('../pages/Kinban-App/Project/Show.vue'),
    },

]

const router = createRouter({
    history:createWebHistory(),
    routes
})



export default router
