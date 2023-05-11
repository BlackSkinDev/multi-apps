<template>
    <div class="border-b p-6 ">
        <div class="flex justify-between">
            <h1 class="text-2xl font-bold -blue-500">ProjecktPilot</h1>
            <div class="flex justify-start space-x-4" v-show="!unauthenticated">
                <router-link :to="{name:'signin'}" v-show="showLoginButton">
                    <button
                        type="button"
                        class="inline-flex justify-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-sm font-medium text-white hover:bg-gray-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                    >
                        Login
                    </button>
                </router-link>
                <router-link :to="{name:'homepage'}"  v-show="showRegisterButton">
                    <button
                        type="button"
                        class="inline-flex justify-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-sm font-medium text-white hover:bg-gray-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                    >
                        Get started
                    </button>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
import {LOGIN_ROUTE_NAME,REGISTER_ROUTE_NAME} from "../constants/constants";

export default {
    name: "App-Header",
    data(){
        return{
            authenticated:false
        }
    },
    computed:{
        showRegisterButton(){
            return this.$route.name !== LOGIN_ROUTE_NAME
        },
        showLoginButton(){

            return this.$route.name !== REGISTER_ROUTE_NAME
        },
    }
}
</script>

<style scoped>

</style>
