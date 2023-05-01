<template>
    <div>
        <div class="flex items-center justify-between">
            <label  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{label}}</label>
        </div>
        <div class="relative">
            <UserCircleIcon class="w-7 h-7 absolute left-2 top-2"/>
            <div v-show="user.initial" class="absolute left-2 top-2 inline-flex items-center justify-center w-7 h-7 overflow-hidden bg-gray-100 rounded-full" :style="{ backgroundColor:selectedColor }">
                <span class="font-bold text-white text-sm">{{user.initial || '?'}}</span>
            </div>
            <input
                type="text"
                v-model="user.name"
                @keyup="handleInput"
                @keydown.backspace="handleBackspace"
                :placeholder="placeholder"
                :style="{color:'#1d4ed8'}"
                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 pl-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            />

            <div v-if="users.length > 0" class="absolute top-10 left-0 bg-white border border-gray-300  w-1/2 z-10 shadow-xl">
                <ul class="overflow-y-auto max-h-[30vh]">
                    <li
                        v-show="task?.user?.id"
                        @click="selectUser(null)"
                        class="cursor-pointer hover:bg-gray-200 hover:border-blue-500 border-l-4 border-transparent px-4 py-2.5 flex justify-start space-x-6"
                        tabindex="0">
                        <div class="relative inline-flex items-center justify-center w-7 h-7 overflow-hidden bg-gray-100 rounded-full" :style="{ backgroundColor:'#ccc'}">
                            <span class="font-bold text-white text-sm">UA</span>
                        </div>
                        <p>Unassigned</p>
                    </li>

                    <li
                        v-for="project_user in users"
                        @click="selectUser(project_user)"
                        class="cursor-pointer hover:bg-gray-200 hover:border-blue-500 border-l-4 border-transparent px-4 py-2.5 flex justify-start space-x-6"
                        tabindex="0"
                    >
                        <div class="relative inline-flex items-center justify-center w-7 h-7 overflow-hidden bg-gray-100 rounded-full" :style="{ backgroundColor:bg_colors[project_user?.id] }" :ref="project_user.initial">
                            <span class="font-bold text-white text-sm">{{project_user?.initial || '?'}}</span>
                        </div>
                        <p>{{ project_user.name }}</p>
                    </li>
                </ul>
            </div>

        </div>

    </div>
</template>

<script>
import {UserCircleIcon} from "@heroicons/vue/solid";
import {useUserStore} from "../../store/UserStore";
import {mapActions} from "pinia";
import {TriggerAction} from "../../helpers/TriggerAction";
import {useTaskStore} from "../../store/TaskStore";
import {TASK_UNASSIGN_SUCCESS_MESSAGE} from "../../../constants";

export default {
    name: "AutoCompleteInput",
    components:{UserCircleIcon},
    props:['label','placeholder','task'],
    data(){
        return{
            user:{
                id:null,
                name:this.task?.user?.name ? `@${this.task.user?.name}` : "Unassigned",
                initial:""
            },
            timeout: null,
            itemSelected:!!this.task?.user?.name,
            bg_colors:[],
            selectedColor:null
        }
    },
    methods:{
        ...mapActions(useUserStore,['fetchUsers']),
        ...mapActions(useTaskStore,['unassignTask']),
        async search() {
            const regex = /@/g;
            const match = this.user.name.match(regex);
            if (match) {
                const searchTerm = this.user.name.split("@")[1]?.trim();
                await TriggerAction(this.fetchUsers(searchTerm))
                this.generateBgColors()

            } else {
                this.users = [];
            }
        },
        handleInput() {
            this.itemSelected = false
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                this.search();
            }, 500);
        },
        selectUser(project_user) {
            const regex = /@/g;
            const match = this.user?.name.match(regex);
            if (match) {
                this.user.name = `@${project_user?.name}`;
                this.itemSelected = true
                this.user.initial = project_user?.initial
                this.$emit('item-selected',project_user?.id)
                this.selectedColor = this.bg_colors[project_user?.id]
                this.users = [];
            }
            if (project_user === null){
                this.user.name = `Unassigned`;
                this.itemSelected = true
                this.user.initial = 'UA'
                this.$emit('item-selected',null)
                this.selectedColor = '#ccc'
                this.users = [];
            }
        },
        handleBackspace() {
            if ( (this.user.name.length > 0 && this.itemSelected)  || this.user.name === 'Unassigned') {
                this.user.initial=""
                this.user.name = "@ "
            }
        },
        generateBgColors(){
            for (let i = 0; i < 500; i++) {
                const color = '#' + Math.floor(Math.random()*16777215).toString(16);
                this.bg_colors.push(color);
            }
        },

    },
    computed:{
        users:{
            get(){
                return useUserStore().users
            },
            set(value){
                useUserStore().users = value
            }
        },

    },

    async mounted() {
        this.users = []
    }
}
</script>

<style scoped>

</style>
