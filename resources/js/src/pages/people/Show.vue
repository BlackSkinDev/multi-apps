<template>
    <div class="flex justify-center container mx-auto px-4 text-center">
        <div class="w-1/3">
            <img :src="user.image" alt="User Avatar" class="rounded-full" v-if="user.image" :style="{width:'120px',height:'120px'}">
            <div v-else class="relative inline-flex items-center justify-center rounded-full w-20 h-20 overflow-hidden bg-gray-100" :style="{ backgroundColor:bg_colors[user?.id] }">
                <span class="font-bold text-white text-2xl">{{user?.initial}}</span>
            </div>
        </div>
        <div class="w-2/3">
            <!-- Content for the right section of the container -->
        </div>
    </div>

</template>

<script>
import {useCompanyStore} from "../../store/CompanyStore";
import {mapActions, mapState} from "pinia";
import {getRandomBgColors, TriggerPiniaAction} from "../../util";
import {APP_NAME} from "../../constants/constants";
export default {
    components: {

    },
    data() {
        return {
            bg_colors:getRandomBgColors()
        };
    },
    async created() {
        await TriggerPiniaAction(this.fetchCompanyUser(this.$route.params.id))
        document.title = `${APP_NAME} | Profile | ${this.user.name}`;
    },
    methods: {
        ...mapActions(useCompanyStore,['fetchCompanyUser']),
    },
    computed:{
        ...mapState(useCompanyStore,{
            user:(state)  => state.user,
        }),
    }
};
</script>
