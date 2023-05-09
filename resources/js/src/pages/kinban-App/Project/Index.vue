<template>
    <h1 class="border-b p-6 text-2xl font-bold">Project Management</h1>
    <div class="h-full  px-4 py-6">
        <div class="max-w-5xl mx-auto">
            <div class="px-3 flex items-center mb-8">
                <h3 class="font-black text-gray-700">My Projects</h3>
                <Popover v-slot="{ open }" class="relative">
                    <PopoverButton
                        :class="open ? 'bg-blue-50 text-blue-600' : ''"
                        class="inline-flex items-center ml-4 py-2 px-3 bg-gray-100 rounded font-medium hover:bg-gray-200 focus:outline-none"
                    >
                        <PlusIcon class="w-4 h-4"/>
                        <span class="ml-1">Create Project</span>
                    </PopoverButton>
                    <PopoverOverlay class=" z-10 bg-black opacity-30 fixed inset-0"/>
                    <transition
                        enter-active-class="transition duration-200 ease-out"
                        enter-from-class="translate-y-1 opacity-0"
                        enter-to-class="translate-y-0 opacity-100"
                        leave-active-class="transition duration-150 ease-in"
                        leave-from-class="translate-y-0 opacity-100"
                        leave-to-class="translate-y-1 opacity-0"
                    >
                        <PopoverPanel v-slot="{close}" class="p-3 absolute w-72  z-10  w-screen max-w-sm -translate-x-1/2  px-4 sm:px-0">
                            <div class="bg-white overflow-hidden rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 p-4">
                               <form action="" @submit.prevent="create(close)">
                                   <Input
                                       v-model="name"
                                       label="Project Name"
                                       type="text"
                                       placeholder="Project name"
                                   />
                                   <div class="flex justify-end mt-6">
                                       <Button :text="'Create Project'" :disabled="processingRequest"></Button>
                                   </div>
                               </form>
                            </div>
                        </PopoverPanel>
                    </transition>
                </Popover>
            </div>
            <div v-if="!processingRequest">
                <ul class="grid grid-cols-1 gap-4  sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4" v-if="projects.length">
                    <li v-for="project in projects" :key="project" class="bg-blue-600 hover:bg-blue-700 rounded-md min-h-[7rem] p-4 cursor-pointer">
                        <router-link :to="{name:'show-project',params:{ref:project.reference}}" class="text-white  text-md font-bold  inset-0">{{project.name}}</router-link>
                        <div class="mt-8 flex justify-between items-center absolute">
                            <p class="text-sm text-white">{{project.reference}}</p>
                        </div>
                    </li>
                </ul>
                <p v-else>You have not created any projects</p>
            </div>
            <clip-loader v-else  class="mt-3 mx-auto block" :loading="true" :color="'black'" :size="'20px'"></clip-loader>
        </div>
    </div>
</template>

<script>
import {PlusIcon} from "@heroicons/vue/solid"
import {useProjectStore} from "../../../store/kinban-app-store/ProjectStore";
import {mapActions,mapState} from "pinia";
import {TriggerAction} from "../../../helpers/TriggerAction";
import {Popover, PopoverButton, PopoverOverlay, PopoverPanel} from '@headlessui/vue'
import { ChevronDownIcon } from '@heroicons/vue/solid'
import Input from "../../../components/ui/input.vue";
import Button from "../../../components/ui/button.vue";
import {CREATE_PROJECT_SUCCESS_MESSAGE} from "../../../constants/kinban-app-constants";
import ClipLoader from 'vue-spinner/src/ClipLoader.vue';


export default {
    name: "Create",
    components:{Input, PopoverOverlay, PlusIcon,Popover, PopoverButton, PopoverPanel ,ChevronDownIcon,Button,ClipLoader},
    data(){
        return {
           name:""
        }
    },
    methods:{
        ...mapActions(useProjectStore,['fetchProjects','createProject']),
        async create(closePopover) {
            const response = await TriggerAction(this.createProject({name: this.name}),CREATE_PROJECT_SUCCESS_MESSAGE,true)
            if (response){
                this.name=""
                closePopover()
            }
            await this.fetchProjects()
        }
    },
    computed:{
        ...mapState(useProjectStore,{
            projects:(state)            => state.projects,
            processingRequest:(state)   =>state.processingRequest
        })
    },
    async mounted() {
        await TriggerAction(this.fetchProjects())
    }
}
</script>

<style scoped>

</style>
