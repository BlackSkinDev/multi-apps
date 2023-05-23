<template>
    <div class="container mx-auto px-4">
        <p class="text-xl font-bold ">People and teams</p>
        <div class="mt-6 mb-2 relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                 <SearchIcon v-if="!loading" class="w-6 h-5 text-zinc-400"/>
                 <clip-loader v-if="loading"  class="mt-1 mx-auto block " :loading="true" :color="'gray'" :size="'18px'"></clip-loader>
            </span>
            <input v-model="searchedUser" @keyup="handleInput"   type="text" class="focus:outline-none border-b-2 focus:border-blue-400 w-full text-lg pl-10 py-2" placeholder="Search for people" >

            <div class="absolute top-10 left-0 bg-white border border-gray-300 w-full z-10 shadow-xl rounded-md" v-if="searching">
                <!-- Overlay mask -->
                <div class="fixed z-[100] w-full h-full top-0 left-0" @click="searching = false" />
                <div v-if="searched_users.length">
                    <p class="text-sm font-medium text-gray-400 mb-2 px-6 mt-3 uppercase">People</p>
                    <ul class="max-h-[25vh] mb-3">
                        <li
                            v-for="user in searched_users.slice(0,4)"
                            class="cursor-pointer hover:bg-gray-100  border-transparent flex justify-start space-x-2 px-6  py-1.5 "
                            tabindex="0"
                        >
                            <img :src="user.image" alt="User Avatar" class="rounded-full w-6 h-6" v-if="user.image">
                            <div v-else class="relative inline-flex items-center justify-center w-6 h-6 overflow-hidden bg-gray-100 rounded-full" :style="{ backgroundColor:bg_colors[user?.id] }" >
                                <span class="font-bold text-white " :style="{fontSize:'11px'}">{{user?.initial || '?'}}</span>
                            </div>
                            <p>{{user.name }}</p>
                        </li>
                    </ul>
                    <div class="px-6 border-t-2 mb-6" v-if="searched_users.length>4">
                        <div class="mt-4"><router-link :to="{name:'people',query:{q:searchedUser}}" class="text-blue-700">See all results for "{{searchedUser}}"</router-link></div>
                    </div>
                </div>
                <p class="flex justify-center text-sm font-medium text-gray-400 mx-auto items-center p-4" v-else>No result found.</p>
            </div>


        </div>

        <h1 class="font-medium mt-8">You work with</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
            <div v-for="user in users" :key="user.id" class="p-4 bg-white rounded-lg mt-4 cursor-pointer  border hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-center">
                    <img :src="user.image" alt="User Avatar" class="rounded-full w-20 h-20" v-if="user.image">
                    <div v-else class="relative inline-flex items-center justify-center rounded-full w-20 h-20 overflow-hidden bg-gray-100" :style="{ backgroundColor:bg_colors[user?.id] }">
                        <span class="font-bold text-white text-2xl">{{user?.initial}}</span>
                    </div>
                </div>
                <div class="text-center mt-4 mb-2">
                    <h1 class="text-sm font-medium text-gray-600">{{ user?.name }}</h1>
                    <p class="text-sm text-gray-500 mt-2">{{ user?.role }}</p>
                </div>
            </div>


        </div>
    </div>


</template>

<script>

import {SearchIcon} from "@heroicons/vue/solid";
import {useCompanyStore} from "../../store/CompanyStore";
import {mapActions,mapState} from "pinia";
import {TriggerPiniaAction} from "../../util";
import ClipLoader from "vue-spinner/src/ClipLoader.vue";

export default {
    components: {
        SearchIcon,
        ClipLoader
    },
    data() {
        return {
            searchedUser:"",
            loading:false,
            searching:false
        };
    },
    async mounted() {
        await TriggerPiniaAction(this.fetchCompanyUsers(this.$route.query.q))
    },
    methods: {
        ...mapActions(useCompanyStore,['fetchCompanyUsers','searchCompanyUsers']),
        handleInput() {
            if (this.searchedUser!==''){
                this.loading = true
                clearTimeout(this.searchTimeout);
                this.searchTimeout = setTimeout(() => {
                    this.search();
                }, 500);
            }
            else{
                this.searching = false;
            }
        },
        async search() {
            await TriggerPiniaAction(this.searchCompanyUsers(this.searchedUser))
            this.searching = true
            this.loading=false
        },
    },
    computed:{
        ...mapState(useCompanyStore,{
            users:(state)     => state.users
        }),
        bg_colors(){
            let bg_colors = []
            for (let i = 0; i < 500; i++) {
                const color = '#' + Math.floor(Math.random()*16777215).toString(16);
                bg_colors.push(color);
            }
            return bg_colors;
        },
        searched_users:{
            get(){
                return useCompanyStore().searched_users
            },
            set(value){
                useCompanyStore().searched_users = value
            }
        },
    }
};
</script>
