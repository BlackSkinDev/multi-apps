<template>
    <div class="container mx-auto px-4">
        <p class="text-xl font-bold ">People and teams</p>
        <div class="mt-6 mb-2 relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
               <SearchIcon class="w-6 h-5 text-zinc-400"/>
            </span>
            <input type="text" class="focus:outline-none border-b-2 focus:border-blue-400 w-full text-lg pl-10" placeholder="Search for people">
        </div>

        <h1 class="font-medium mt-8">You work with</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
            <div v-for="user in users" :key="user.id" class="p-4 bg-white shadow rounded-lg mt-4 cursor-pointer">
                <div class="flex items-center justify-center">
                    <img :src="user.image" alt="User Avatar" class="rounded-full w-20 h-20" v-if="user.image">
                    <div  v-else class="relative inline-flex items-center justify-center rounded-full w-20 h-20 overflow-hidden bg-gray-100 " :style="{ backgroundColor:bg_colors[user?.id] }">
                        <span class="font-bold text-white text-2xl">{{user?.initial}}</span>
                    </div>
                </div>
                <div class="text-center mt-4 mb-8">
                    <h1 class="text-sm font-medium text-gray-600">{{ user.fullName }}</h1>
                    <p class="text-sm text-gray-500 mt-2">{{ user.role }}</p>
                </div>
            </div>
        </div>
    </div>


</template>

<script>

import {SearchIcon} from "@heroicons/vue/solid";
import RichEditor from "../../components/ui/RichEditor.vue";
import TextInput from "../../components/ui/TextInput.vue";
import Button from "../../components/ui/Button.vue";
import FileInput from "../../components/ui/FileInput.vue";
import {useUserStore} from "../../store/UserStore";
import {mapActions, mapState} from "pinia";
import {TriggerPiniaAction} from "../../util";
import {UPDATE_USER_ACCOUNT_SUCCESS_MESSAGE} from "../../constants/constants";
export default {
    components: {
        TextInput,
        RichEditor,
        FileInput,
        Button,
        SearchIcon
    },
    data() {
        return {
            userForm: {},
            src:"",
            isEditing:false,
            users: [
                {
                    id: 1,
                    fullName: "John Doe",
                    image: null,
                    role: "Software Engineer",
                    initial:"JD"
                },
                {
                    id: 2,
                    fullName: "Jane Smith",
                    image: null,
                    role: "Frontend Developer",
                    initial:"JS"
                },
                {
                    id: 3,
                    fullName: "Alex Johnson",
                    image: "http://chillingdev.test/storage/user-images/37d1e299f10ac2fbebd7a12ab274af69.jpg",
                    role: "Data Scientist",
                    initial:"AJ"
                },
                {
                    id: 4,
                    fullName: "John Doe",
                    image: "http://chillingdev.test/storage/user-images/37d1e299f10ac2fbebd7a12ab274af69.jpg",
                    role: "Software Engineer",
                    initial:"JD"
                },
                {
                    id: 5,
                    fullName: "Jane Smith",
                    image: "http://chillingdev.test/storage/user-images/37d1e299f10ac2fbebd7a12ab274af69.jpg",
                    role: "Frontend Developer",
                    initial:"JS"
                },
                {
                    id: 6,
                    fullName: "Alex Johnson",
                    image: null,
                    role: "Data Scientist",
                    initial:"AJ"
                },
                // Add more user objects here
            ]
        };
    },
    async created() {
        await TriggerPiniaAction(this.fetchUserAccountInfo())
        await this.$nextTick(() => {
            this.userForm = {...this.userInfo}
        });

    },
    methods: {
        ...mapActions(useUserStore,['fetchUserAccountInfo','updateUserInfo']),
        async submitForm() {
            await TriggerPiniaAction(this.updateUserInfo(this.userForm),UPDATE_USER_ACCOUNT_SUCCESS_MESSAGE,true)
        },
        setEditorValue(text) {
            this.isEditing = this.$refs.richEditor.isEditing
            this.userForm.bio = text;
        },
        handleLogoChange(file) {
            this.src = file;
        },

    },
    computed:{
        bg_colors(){
            let bg_colors = []
            for (let i = 0; i < 500; i++) {
                const color = '#' + Math.floor(Math.random()*16777215).toString(16);
                bg_colors.push(color);
            }
            return bg_colors;
        },
        ...mapState(useUserStore,{
            userInfo:(state)  => state.userAccountInfo,
            loading:(state)  => state.processingRequest
        }),
        disabled(){
            return this.userForm.name === '' ||
                this.userForm.username === ''

        }
    }
};
</script>
