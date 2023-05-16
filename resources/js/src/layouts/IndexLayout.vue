<template>
    <div class="">
        <AppHeader/>
        <div>
            <router-view/>
        </div>
    </div>
</template>

<script>
import AppHeader from "../components/App-Header.vue";
import {TriggerPiniaAction} from "../util";
import {mapActions} from "pinia/dist/pinia";
import {useAuthStore} from "../store/AuthStore";
export default {
    name: "IndexLayout.vue",
    components:{AppHeader},
    async created() {
        const res = await TriggerPiniaAction(this.fetchAuthUser())
        if(!res)this.$router.push("/signin");
    },
    methods:{
        ...mapActions(useAuthStore,['fetchAuthUser']),
    },
}
</script>

<style scoped>

</style>
