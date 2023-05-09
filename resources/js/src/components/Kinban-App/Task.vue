<template>
        <li>
            <div class="cursor-pointer group relative bg-white p-3 shadow rounded-md border-b border-gray-300 hover:bg-gray-50">
                <p href="#" class="text-sm w-5/6 break-all">{{task.title}}</p>
                <Menu as="div" class="relative z-50">
                    <MenuButton class="hidden absolute -top-7 right-1 w-8 h-8 bg-gray-50 group-hover:grid place-content-center rounded-md text-gray-600 hover:text-black hover:bg-gray-200">
                        <PencilIcon class="w-5 h-5"/>
                    </MenuButton>
                    <transition
                        enter-active-class="transition transform duration-100 ease-out"
                        enter-from-class="opacity-0 scale-90"
                        enter-to-class="opacity-100 scale-100"
                        leave-active-class="transition transform duration-100 ease-in"
                        leave-from-class="opacity-100 scale-100"
                        leave-to-class="opacity-0 scale-90"
                    >
                        <MenuItems class="origin-top-left mt-2 focus:outline-none absolute -right-5 bg-white overflow-hidden rounded-md shadow-lg border w-32">
                            <MenuItem v-slot="{active}">
                                <a href="#" :class="{'bg-gray-100': active}" class="block px-4 py-2 text-sm text-g-700" @click="isEditFormOpen=true">Edit</a>
                            </MenuItem>
                            <MenuItem v-slot="{active}">
                                <a href="#" :class="{'bg-gray-100': active}" class="block px-4 py-2 text-sm text-red-500" @click="showDeleteModal(task.id)">Delete</a>
                            </MenuItem>
                        </MenuItems>
                    </transition>
                </Menu>
                <div class="mt-10 flex justify-between items-center">
                    <p class="text-sm text-gray-800 break-all  w-5/6">{{task.reference}}</p>
                    <div class="relative inline-flex items-center justify-center w-8 h-8 overflow-hidden bg-gray-100 rounded-full" :style="{backgroundColor:'#' + Math.floor(Math.random()*16777215).toString(16)}">
                        <span class="font-bold text-white text-sm">{{task.user?.initial || '?'}}</span>
                    </div>
                </div>
                <ProjectTaskEditForm
                    :isOpen="isEditFormOpen"
                    @update="updateTask"
                    @close-modal="isEditFormOpen=false"
                    ref="editTaskForm"
                    :task="task"
                />
                <DeleteConfirmation
                    :isOpen="isDeleteModalOpen"
                    :item_id="deleteId"
                    @close-modal="isDeleteModalOpen=false"
                    item_type="task"
                    @deleteSelectedItem="deleteSelectedItem"
                />
            </div>
        </li>


</template>

<script>
import {DotsHorizontalIcon, PencilIcon} from "@heroicons/vue/solid"
import {Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue'
import {useProjectStore} from "../../store/kinban-app-store/ProjectStore";
import {mapActions} from "pinia";
import ProjectTaskEditForm from "./ProjectTaskEditForm.vue";
import DeleteConfirmation from "../ui/DeleteConfirmation.vue";
import {useTaskStore} from "../../store/kinban-app-store/TaskStore";

export default {
    name: "Task",
    components: {
        DotsHorizontalIcon,
        PencilIcon,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        ProjectTaskEditForm,
        DeleteConfirmation
    },
    props:{
        task:Object,
    },
    data(){
        return{
            isDeleteModalOpen:false,
            isEditFormOpen:false,
            deleteId:null,
        }
    },
    methods:{
        ...mapActions(useProjectStore,['fetchTasks']),
        ...mapActions(useTaskStore,['deleteProjectTask','updateProjectTask']),
        async showDeleteModal(id) {
            this.isDeleteModalOpen = true
            this.deleteId = id
        },
        async deleteSelectedItem(id) {
            this.$emit('deleteTask',id)
            this.isDeleteModalOpen = false
        },
        async updateTask(data,task_id){
             this.$emit('updateTask',data,task_id)
             this.isEditFormOpen = false
        },

    },
    computed:{
        stages_tasks:{
            get(){
                return useProjectStore().project_stages_tasks;
            },
            set(value){
                return useProjectStore().project_stages_tasks = value
            }
        },
    }

}
</script>

<style scoped>
.drag > div{
    transform:rotate(4deg) ;
}
.ghost{
    background: lightgray;
    border-radius: 6px;
}
.ghost > div{
    visibility: hidden;
}
</style>
