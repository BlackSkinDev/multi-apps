<template>
    <router-view/>
</template>

<script>
import AppHeader from "../components/App-Header.vue";
import {useAuthStore} from "../store/AuthStore";
import {mapActions, mapState} from "pinia/dist/pinia";
import {authCheck, TriggerPiniaAction} from "../util";
export default {
    name: "IndexLayout.vue",
    components:{AppHeader},
    async mounted() {
        if (authCheck()){
            const res = await TriggerPiniaAction(this.fetchAuthUser())
            if(!res)this.$router.push("/signin");
        }
    },
    methods:{
        ...mapActions(useAuthStore,['fetchAuthUser']),
    },
    computed:{
        ...mapState(useAuthStore,{
            user:(state)        => state.user,
        })
    }
}
</script>

<style scoped>

</style>
