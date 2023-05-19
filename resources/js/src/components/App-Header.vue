<template>
    <div class="bg-white w-full  py-3 border-b fixed top-0">

        <div class="md:flex md:justify-between relative md:px-6">

            <div class="flex justify-between items-center w-full md:w-auto">
                <h1 class="ml-2 font-bold text-lg ">{{app_name}}</h1>
                <button class="md:hidden ml-auto" @click="toggleMenu" >
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
            <div class="absolute md:static left-0 top-full md:left-[unset] md:top-[unset] h-max w-full bg-gray-300 md:bg-transparent md:flex md:items-center md:justify-between" :class="{ 'hidden': !showMenu }">
                <div class="md:flex md:items-center" >
                    <a href="#" :class="active_link === 'tasks'  ? 'text-blue-600' : '' "   @click="active_link='tasks'" class="block md:inline-block mt-4 md:mt-0 md:ml-6 px-3 py-2 border-b-2 border-transparent hover:bg-blue-100 hover:text-blue-600 hover:rounded transition-colors font-medium">
                       Your tasks
                    </a>
                    <a href="#" :class="active_link === 'dashboard'  ? 'text-blue-600' : '' " @click="active_link='dashboard'" class="block md:inline-block mt-4 md:mt-0 md:ml-6 px-3 py-2 border-b-2 border-transparent hover:bg-blue-100 hover:text-blue-600 hover:rounded transition-colors font-medium">
                        Projects
                    </a>
                    <a href="#" :class="active_link === 'projects'  ? 'text-blue-600' : '' " @click="active_link='projects'" class="block md:inline-block mt-4 md:mt-0 md:ml-6 px-3 py-2 border-b-2 border-transparent hover:bg-blue-100 hover:text-blue-600 hover:rounded transition-colors font-medium">
                        Dashboards
                    </a>
                </div>
                <div class="flex space-x-6  md:flex w-full md:w-auto">
                    <div class="w-full">
                        <input type="text" class="border border-gray-300 px-4 py-2 md:w-64 w-full rounded" placeholder="Search...">
                    </div>
                    <Menu as="div" class="z-50 relative hidden md:block" v-slot="{ close }">
                        <MenuButton>
                            <div class="w-10 h-10 cursor-pointer overflow-hidden relative" v-if="user.photo" :class="loading ? 'opacity-20' : ''">
                                <img :src="src || user.photo" alt="User Image" class="w-full h-full object-cover rounded-full" id="v-step-2">
                                <moon-loader :loading="loading" class="-mt-10" :size="'40px'"></moon-loader>
                                <div class="absolute inset-0 flex items-center justify-center transition duration-300">
                                    <div class="w-full h-full rounded-full border-4 border-transparent hover:border-blue-100"></div>
                                </div>
                            </div>
                        </MenuButton>
                        <transition
                            enter-active-class="transition transform duration-100 ease-out"
                            enter-from-class="opacity-0 scale-90"
                            enter-to-class="opacity-100 scale-100"
                            leave-active-class="transition transform duration-100 ease-in"
                            leave-from-class="opacity-100 scale-100"
                            leave-to-class="opacity-0 scale-90"
                        >
                            <MenuItems class="origin-top-left mt-1.5 focus:outline-none absolute -right-2 bg-white overflow-hidden  shadow border w-50">

                                <div class="px-4 mt-4 mb-3">
                                    <h1 class="font-bold text-sm text-gray-600">Account</h1>
                                    <div class="flex items-center justify-start space-x-1 mt-4">
                                        <div>
                                            <div class="w-8 h-8 cursor-pointer overflow-hidden relative" v-if="user.photo" >
                                                <img :src="src || user.photo" alt="User Image" class="w-full h-full object-cover rounded-full">
                                            </div>
                                        </div>
                                        <div class="">
                                            <h2 class="text-sm">{{user.name}}</h2>
                                            <p class="text-gray-500" :style="{fontSize:'12px'}">{{user.email}}</p>
                                        </div>
                                    </div>
                                </div>

                                <MenuItem v-slot="{active}">
                                    <a href="#" :class="{'bg-gray-100': active}" class="block px-4 py-3 text-sm text-gray-600 border-t-2" @click="browse">
                                        Upload Picture
                                        <input type="file" ref="profile_picuture" @change="handleFileChange" class="hidden">
                                    </a>
                                </MenuItem>
                                <router-link
                                    v-slot="{ isActive, href, navigate }"
                                    :to="{name:'dashboard'}">
                                    <MenuItem  v-slot="{active}">
                                        <a href="#" :class="{'bg-gray-100': active}" class="block px-4 py-3 text-sm text-gray-600">My Account</a>
                                    </MenuItem>
                                </router-link>
                                <router-link
                                    v-if="user.is_admin"
                                    v-slot="{ isActive, href, navigate }"
                                    :to="{name:'company'}">
                                    <MenuItem  v-slot="{active}">
                                        <a href="#" :class="{'bg-gray-100': active}" class="block px-4 py-3 text-sm text-gray-600">My Company</a>
                                    </MenuItem>
                                </router-link>
                                <MenuItem v-slot="{active}">
                                    <a href="#" :class="{'bg-gray-100': active}" class="block px-4 py-3 text-sm text-red-500 border-t-2" @click="logoutUser()">Log out</a>
                                </MenuItem>
                            </MenuItems>
                        </transition>
                    </Menu>
                </div>
            </div>

         </div>
    </div>
</template>

<script>
import {TriggerPiniaAction} from "../util";
import {useAuthStore} from "../store/AuthStore";
import {useUserStore} from "../store/UserStore";
import {mapActions,mapState} from "pinia";
import logo from "../assests/images/pro.png"
import {APP_NAME, PROFILE_PICTURE_UPLOAD_SUCCESS_MESSAGE} from "../constants/constants";
import {Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue'
import MoonLoader from 'vue-spinner/src/MoonLoader.vue';



export default {
    name: "App-Header",
    components: {
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        MoonLoader
    },
    data(){
        return{
            active_link:"dashboard",
            logo:logo,
            app_name:APP_NAME,
            showMenu: false,
            src:"",
        }
    },
    methods:{
        ...mapActions(useAuthStore,['logout']),
        ...mapActions(useUserStore,['uploadProfilePicture']),
        async logoutUser(){
            const res = await TriggerPiniaAction(this.logout());
            if (res) this.$router.push('/signin')
        },
        toggleMenu() {
            this.showMenu = !this.showMenu;
        },
        browse(){
            this.$refs.profile_picuture.click()
        },
        async handleFileChange(event) {
            let reader = new FileReader()
            reader.readAsDataURL(event.target.files[0]
        );
            reader.onload = (event) => {
                this.src = event.target.result
            }
            let formData = new FormData();
            formData.append('file', event.target.files[0]);
            await TriggerPiniaAction(this.uploadProfilePicture(formData), PROFILE_PICTURE_UPLOAD_SUCCESS_MESSAGE, true)
        },

    },
    computed:{
        ...mapState(useAuthStore,{
            user:(state)      => state.user
        }),
        ...mapState(useUserStore,{
            loading:(state)      => state.processingRequest
        })
    }

}
</script>

<style scoped>

</style>
