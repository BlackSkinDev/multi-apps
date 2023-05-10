

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
        component:()=>import('../components/Test.vue'),
    },

    {
        path:'/signin',
        name:"signin",
        component:()=>import('../pages/auth/login.vue'),
    },


    //
    // {
    //     path:'/kinban-app/projects',
    //     name:"manage-projects",
    //     component:()=>import('../pages/project'),
    // },
    // {
    //     path:'/kinban-app/projects/:ref/browse',
    //     name:"show-project",
    //     component:()=>import('../pages/project/Show.vue'),
    // },

]

const router = createRouter({
    history:createWebHistory(),
    routes
})



export default router
