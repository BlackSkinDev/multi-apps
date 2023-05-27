<template>
    <div class="h-44" :style="{ backgroundColor:lighter_bg_color}"></div>
    <div class="container mx-auto px-16">
        <div class="flex justify-start space-x-12 -mt-14">
            <div class="w-1/3">
                <img :src="user.image" alt="User Avatar" class="rounded-full" v-if="user.image" :style="{width:'120px',height:'120px'}">
                <div v-else class="relative inline-flex items-center justify-center rounded-full w-20 h-20 overflow-hidden bg-gray-100" :style="{ backgroundColor:bg_color }">
                    <span class="font-bold text-white text-2xl">{{user?.initial}}</span>
                </div>
                <h1 class="mt-4 font-medium text-xl">{{user.name}}</h1>
                <div class="mt-10 border rounded text-gray-600">
                    <h1 class="px-4 py-2 font-medium text-gray-600">About</h1>
                    <p  class="px-4 py-2" >{{user.email}}</p>
                    <p  class="px-4 py-2" >@{{user.username}}</p>
                    <p  class="px-4 py-2" >{{user.linkedin}}</p>
                    <p  class="px-4 py-2" >{{user.phone}}</p>
                    <p  class="px-4 py-2 text-sm text-gray-600 text-center text-justify" v-html="user?.bio "/>
                </div>
            </div>
            <div class="w-2/3 mt-32">
                <h1 class="font-medium">Worked on</h1>
                <div class="mt-2 border rounded text-gray-600">
                    <h1 class="px-4 py-2 font-medium text-gray-600">About</h1>
                    <p  class="px-4 py-2" >{{user.email}}</p>
                    <p  class="px-4 py-2" >@{{user.username}}</p>
                    <p  class="px-4 py-2" >{{user.linkedin}}</p>
                    <p  class="px-4 py-2" >{{user.phone}}</p>
                    <p  class="px-4 py-2 text-sm text-gray-600 text-center text-justify" v-html="user?.bio "/>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import {useCompanyStore} from "../../store/CompanyStore";
import {mapActions, mapState} from "pinia";
import { getLighterColor,getRandomBgColors, TriggerPiniaAction} from "../../util";
import {APP_NAME} from "../../constants/constants";

export default {
    components: {

    },
    data() {
        return {
            bg_color:getRandomBgColors(),
            lighter_bg_color:getLighterColor(this.bg_color,10),
        };
    },
    async created() {
        console.log(this.bg_color,this.y)
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
