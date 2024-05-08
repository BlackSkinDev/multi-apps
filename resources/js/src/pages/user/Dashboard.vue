<template>
<h1 class="p-5">Welcome Back</h1>

<p class="p-5 text-red-500 cursor-pointer" @click="destroy">Logout</p>
</template>

<script>
import {mapActions} from "pinia/dist/pinia";
import {useAuthStore} from "../../store/AuthStore";
import {TriggerPiniaAction} from "../../util";

export default {
    name: "Dashboard",
    methods:{
        ...mapActions(useAuthStore,['logout']),

        async destroy() {
            const response = await TriggerPiniaAction(this.logout())
            if (response) this.$router.push({ name: "signin" })
        },

    },

}
</script>

<style scoped>

</style>
