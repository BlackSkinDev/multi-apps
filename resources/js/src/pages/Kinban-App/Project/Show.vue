<template>
    <div class="flex flex-col h-screen bg-blue-600">
        <main class="flex-1 overflow-hidden">
            <div class="flex flex-col h-full">
                <Modal :isOpen="isOpen" :title="'Create Task'" :width="700" @close-modal="isOpen=false">
                    <div class="mt-2 space-y-6">
                        <Input label="Title" placeholder="Title"/>
                        <Select label="Assignee" :options="users"/>
                    </div>
                    <div class="mt-4">
                        <button
                            type="button"
                            class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                            @click="isOpen = false"
                        >
                            Got it, thanks!
                        </button>
                    </div>
                </Modal>
                <div class="shrink-0 flex flex-wrap justify-between items-center p-4">
                    <div class="flex flex-col items-start max-w-full relative">
                        <h1
                            ref="heading"
                            class="break-all px-3 py-1.5 text-xl font-bold text-white hover:bg-white/20 rounded-md cursor-pointer border border-none whitespace-pre w-full overflow-hidden text-ellipsis"
                            :class="[isEditing ? 'invisible' : '']"
                            @click="edit"
                        >
                            {{name ? name : '  '}}
                        </h1>
                        <form  v-show="isEditing"  @submit.prevent  class="w-full">
                            <input
                                :style="{width:'300px'}"
                                ref="input"
                                v-model="name"
                                type="text"
                                placeholder="Project name"
                                class="absolute inset-0 max-w-full text-2xl font-bold placeholder-gray-400 px-3 py-1.5 rounded-md focus:ring-2 focus:ring-blue-900"
                                v-on:blur="saveProjectname"
                                v-on:keyup.enter="$event.target.blur()"

                            >
                        </form>
                    </div>
                    <div>
                        <Menu as="div" class="relative z-10">
                            <MenuButton class="bg-white/10 hover:bg-white/20 px-3 py-2 font-medium text-sm text-white rounded-md inline-flex items-center">
                                    <DotsHorizontalIcon class="w-5 h-5"/>
                                    <span class="ml-1">Actions</span>
                            </MenuButton>
                            <transition
                                enter-active-class="transition transform duration-100 ease-out"
                                enter-from-class="opacity-0 scale-90"
                                enter-to-class="opacity-100 scale-100"
                                leave-active-class="transition transform duration-100 ease-in"
                                leave-from-class="opacity-100 scale-100"
                                leave-to-class="opacity-0 scale-90"
                            >
                                <MenuItems class="origin-top-right mt-2 focus:outline-none absolute right-0 bg-white overflow-hidden  shadow-lg border w-32">
                                    <MenuItem v-slot="{active}" class="border-b">
                                        <a href="#" :class="{'bg-gray-100': active}" class="block px-4 py-2 text-sm text-g-700" @click="isOpen=true">Create Task</a>
                                    </MenuItem>
                                    <MenuItem v-slot="{active}" class="border-b">
                                        <a href="#" :class="{'bg-gray-100': active}" class="block px-4 py-2 text-sm text-red-500">Delete</a>
                                    </MenuItem>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                </div>
                <div class="flex-1 p-4 overflow-x-auto">
                    <div class="inline-flex h-full space-x-4">
                        <StageTaskList
                            v-for="(stage,idx) in stages_tasks"
                            :key="idx" class="w-72 bg-gray-200 max-h-full flex flex-col rounded-md"
                            :stage="stage"
                        />
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
<script>
import Draggable from "vuedraggable"
import {DotsHorizontalIcon,PencilIcon} from "@heroicons/vue/solid"
import {Menu,MenuButton,MenuItem,MenuItems,Dialog,DialogPanel,DialogDescription,DialogTitle,TransitionRoot} from '@headlessui/vue'
import {toast} from "../../../plugins/Toast";
import {useProjectStore} from "../../../store/ProjectStore";
import {mapState,mapActions} from "pinia";
import {TriggerAction} from "../../../helpers/TriggerAction";
import StageTaskList from "../../../components/Kinban-App/StageTaskList.vue";
import Modal from "../../../components/ui/Modal.vue";
import Input from "../../../components/ui/input.vue";
import Select from "../../../components/ui/Select.vue";

export default{
    components: {
        Input,
        Draggable,
        DotsHorizontalIcon,
        PencilIcon,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        StageTaskList,
        Dialog,
        DialogPanel,
        DialogDescription,
        DialogTitle,
        TransitionRoot,
        Modal,
        Select
    },
    data() {
        return {
            isEditing:false,
            isOpen:false
        }
    },
    methods: {
        ...mapActions(useProjectStore,['fetchProject','updateProject','fetchTasks','fetchUsers']),
        hey(){
            toast.success("Edit")
        },
        edit(){
            this.isEditing = true
            this.$nextTick(() => {
                this.$refs.input.select();
            });
        },
        async saveProjectname() {
            if (this.name !== ''){
                this.isEditing = false
                const response = await TriggerAction(this.updateProject({name:this.name}))
                if (!response){
                    this.isEditing = true
                    await this.$nextTick(() => {
                        this.$refs.input.select();
                    });
                }
            }
        }
    },
    async mounted() {
           await  TriggerAction(this.fetchProject(this.$route.params.reference)),
           await  TriggerAction(this.fetchTasks())
           await  TriggerAction(this.fetchUsers())
    },
    computed:{
        ...mapState(useProjectStore,{
            project:(state)         => state.project,
            stages_tasks:(state)    => state.project_stages_tasks,
            users:(state)    => state.users
        }),

        name:{
            get(){
                return useProjectStore().project.name;
            },
            set(value){
                return useProjectStore().project.name = value
            }
        }
    },

}
</script>
