

import {createRouter, createWebHistory}  from 'vue-router'


const routes = [

    {
        path:'/',
        name:"homepage",
        component:()=>import('../pages/Index.vue'),
    },

    {
        path:'/kinban-app',
        name:"kinban",
        component:()=>import('../pages/Kinban-App/Index.vue'),
    },

    {
        path:'/kinban-app/tasks',
        name:"kinban-tasks",
        component:()=>import('../pages/Kinban-App/Tickets.vue'),
    }
]

const router = createRouter({
    history:createWebHistory(),
    routes
})



export default router
