<template>
    <div class="container mx-auto px-4">
        <p class="text-xl font-bold ">People and teams</p>
        <div class="mt-6 mb-2 relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                 <SearchIcon v-if="!loading" class="w-6 h-5 text-zinc-400"/>
                 <clip-loader v-if="loading"  class="mt-1 mx-auto block " :loading="true" :color="'gray'" :size="'18px'"></clip-loader>
            </span>
            <input
                v-model="searchedUser"
                @keyup="handleInput"
                @keydown.down.prevent="handleKeyDown"
                @keydown.up.prevent="handleKeyDown"
                @keydown.enter.prevent="handleKeyDown"
                type="text"
                class="focus:outline-none border-b-2 focus:border-blue-400 w-full text-lg pl-10 py-2"
                placeholder="Search for people"
            >
            <div class="fixed z-[50] inset-0" v-if="searching" @click="searching = false"></div>
            <div class="absolute top-10 left-0 bg-white border border-gray-300 w-full  z-[60] shadow-xl rounded-md" v-if="searching">
                <div v-if="searched_users.length" >
                    <p class="text-sm font-medium text-gray-400 mb-2 px-6 mt-3 uppercase">People</p>
                    <ul class="max-h-[25vh] mb-3">
                        <li
                            v-for="(user, index) in searched_users.slice(0, 4)"
                            :key="index"
                            :class="{ 'bg-gray-100': index === focusedIndex}"
                            class="cursor-pointer hover:bg-gray-100 border-transparent px-6 py-1.5"
                            ref="listItems"
                        >
                            <router-link :to="{name:'people-profile',params:{id:user.uuid}}" class="flex justify-start space-x-2">
                                <img :src="user.image" alt="User Avatar" class="rounded-full w-6 h-6" v-if="user.image">
                                <div v-else class="relative inline-flex items-center justify-center w-6 h-6 overflow-hidden bg-gray-100 rounded-full" :style="{ backgroundColor:bg_colors[user?.id] }" >
                                    <span class="font-bold text-white " :style="{fontSize:'11px'}">{{user?.initial || '?'}}</span>
                                </div>
                                <div class="text-sm">
                                    <span>{{user.name }}</span>
                                    <span class="text-gray-500"> | {{user.name}}</span>
                                    <span class="text-gray-500" v-if="user.role"> | {{user.role}}</span>
                                </div>
                            </router-link>
                        </li>
                    </ul>
                    <div class="px-6 border-t-2 mb-6" v-if="searched_users.length>4">
                        <div class="mt-4">
                            <a href="#"
                               @click="seeAllResults"
                               class="text-blue-700"
                               :class="{ 'bg-gray-100': index === focusedIndex}"
                            >
                                See all results for "{{searchedUser}}"
                            </a>
                        </div>
                    </div>
                </div>
                <p class="flex justify-center text-sm font-medium text-gray-400 mx-auto items-center p-4" v-else>No result found.</p>
            </div>
        </div>



        <h1 class="font-medium mt-8">You work with</h1>
            <div v-if="!isFetchingUsers">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
                    <div v-for="user in users" :key="user.id" class="p-4 bg-white rounded-lg mt-4 cursor-pointer  border hover:shadow-lg transition-shadow">
                        <router-link :to="{name:'people-profile',params:{id:user.uuid}}">
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
                        </router-link>
                    </div>
                </div>
            </div>
            <clip-loader v-else class="mt-1 mx-auto block " :loading="true" :color="'gray'" :size="'20px'"></clip-loader>
    </div>


</template>

<script>

import {SearchIcon} from "@heroicons/vue/solid";
import {useCompanyStore} from "../../store/CompanyStore";
import {mapActions,mapState} from "pinia";
import {getRandomBgColors, TriggerPiniaAction} from "../../util";
import ClipLoader from "vue-spinner/src/ClipLoader.vue";
import {APP_NAME} from "../../constants/constants";

export default {
    components: {
        SearchIcon,
        ClipLoader,
    },
    data() {
        return {
            searchedUser:"",
            loading:false,
            searching:false,
            focusedIndex: -1,
            bg_colors:getRandomBgColors()
        };
    },
    created() {
        document.title = `${APP_NAME} | People`;
    },
    async mounted() {
        await TriggerPiniaAction(this.fetchCompanyUsers(this.$route.query.q))
    },
    methods: {
        ...mapActions(useCompanyStore,['fetchCompanyUsers','searchCompanyUsers']),
        handleInput(event) {
            const isArrowKey = ['ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight','Enter'].includes(event.key);
            if(!isArrowKey){
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
            }
        },
        async search() {
            await TriggerPiniaAction(this.searchCompanyUsers(this.searchedUser))
            this.searching = true
            this.loading=false
        },
        async seeAllResults() {
            const query = {q: this.searchedUser};
            this.$router.push({name: 'people', query});
            setTimeout(async () => {
                await TriggerPiniaAction(this.fetchCompanyUsers(this.$route.query.q))
            }, 100);
            this.searchedUser = ""
            this.searching = false
        },
        handleKeyDown(event) {
            if (event.key === 'ArrowUp' || event.key === 'ArrowDown' || event.key === 'Enter') {
                const listItems = this.$refs.listItems;
                const lastIndex = listItems.length - 1;
                if (event.key === "ArrowUp") {
                    if (this.focusedIndex === 0) {
                        this.focusedIndex = lastIndex;
                    } else {
                        this.focusedIndex--;
                    }
                } else if (event.key === "ArrowDown") {
                    if (this.focusedIndex === lastIndex) {
                        this.focusedIndex = 0;
                    } else {
                        this.focusedIndex++;
                    }
                } else if (event.key === "Enter") {
                    if (this.focusedIndex >= 0 && this.focusedIndex <= lastIndex) {
                        const selectedUserId = this.searched_users[this.focusedIndex].uuid;
                        this.$router.push({name: 'people-profile', params: {id:selectedUserId}});
                    }
                }

            }
        }
    },
    computed:{
        ...mapState(useCompanyStore,{
            users:(state)            => state.users,
            isFetchingUsers:(state)  => state.processingRequest
        }),
        searched_users:{
            get(){
                return useCompanyStore().searched_users
            },
            set(value){
                useCompanyStore().searched_users = value
            }
        },
    },

};
</script>
