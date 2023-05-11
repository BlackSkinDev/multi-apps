<template>
    <div class="border-b p-6 ">
        <div class="flex justify-between">
            <h1 class="text-2xl font-bold -blue-500">ProjecktPilot</h1>

            <button
                type="button"
                class="inline-flex justify-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-sm font-medium text-white hover:bg-gray-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                @click="logoutUser"
            >
                Logout
            </button>

        </div>
    </div>
</template>

<script>
import {TriggerPiniaAction} from "../util";
import {useAuthStore} from "../store/AuthStore";
import {mapActions} from "pinia";

export default {
    name: "App-Header",
    data(){
        return{

        }
    },
    methods:{
        async logoutUser(){
            const res = await TriggerPiniaAction(this.logout());
            if (res) this.$router.push('/signin')
        },
        ...mapActions(useAuthStore,['logout'])
    }

}
</script>

<style scoped>

</style>
