<template>
    <div>
        <div class="flex items-center justify-between px-3 py-2">
            <h3 class="text-sm font-semibold text-gray-700">{{stage.name}}</h3>
            <Menu as="div" class="relative z-10" >
                <MenuButton class="hover:bg-gray-300 w-8 h-8 rounded-md grid place-content-center">
                    <DotsHorizontalIcon class="w-5 h-5"/>
                </MenuButton>
                <transition
                    enter-active-class="transition transform duration-100 ease-out"
                    enter-from-class="opacity-0 scale-90"
                    enter-to-class="opacity-100 scale-100"
                    leave-active-class="transition transform duration-100 ease-in"
                    leave-from-class="opacity-100 scale-100"
                    leave-to-class="opacity-0 scale-90"
                >
                    <MenuItems class="origin-top-left mt-2 focus:outline-none absolute left-0 bg-white overflow-hidden rounded-md shadow-lg border w-32">
                        <MenuItem v-slot="{active}">
                            <a href="#" :class="{'bg-gray-100': active}" class="block px-4 py-2 text-sm text-g-700">Edit</a>
                        </MenuItem>
                        <MenuItem v-slot="{active}">
                            <a href="#" :class="{'bg-gray-100': active}" class="block px-4 py-2 text-sm text-red-500">Delete</a>
                        </MenuItem>
                    </MenuItems>
                </transition>
            </Menu>
        </div>
        <div class="px-3 pb-3 overflow-y-auto">
            <Draggable
                v-model="tasks"
                group="tasks"
                item-key="id"
                class="space-y-3"
                tag="ul"
                drag-class="drag"
                ghost-class="ghost"
                @change="onChange"
            >
                <template #item="{element}">
                    <Task :task="element" @deleteTask="deleteTask" @updateTask="updateTask"/>
                </template>
            </Draggable>

        </div>
    </div>
</template>

<script>
import {DotsHorizontalIcon,PencilIcon} from "@heroicons/vue/solid"
import {Menu,MenuButton,MenuItem,MenuItems} from '@headlessui/vue'
import Task from "./Task.vue";
import Draggable from 'vuedraggable'
import {TriggerAction} from "../../helpers/TriggerAction";
import {useTaskStore} from "../../store/kinban-app-store/TaskStore";
import {mapActions, mapState} from "pinia";
import {TASK_DELETE_SUCCESS_MESSAGE, TASK_UPDATE_SUCCESS_MESSAGE} from "../../constants/constants";
import {useUserStore} from "../../store/kinban-app-store/UserStore";

export default {
    name: "StageTasks",
    components: {
        DotsHorizontalIcon,
        PencilIcon,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        Task,
        Draggable
    },
    props:{
        stage:Object
    },
    data(){
        return{

        }
    },
    methods:{
        ...mapActions(useTaskStore,['moveTask','deleteProjectTask','updateProjectTask']),
        ...mapActions(useUserStore,['fetchUser']),
        async onChange(e) {
            let item = e.added || e.moved;
            if(!item) return
            let index = item.newIndex;
            let prevTask = this.tasks[index-1]
            let nextTask = this.tasks[index+1]
            let task =     this.tasks[index]
            let position = task.position
            if (prevTask && nextTask){
                position = (prevTask.position + nextTask.position)/2;
            } else if(prevTask){
                position = prevTask.position + (prevTask.position/2);
            } else if(nextTask){
                position = nextTask.position/2
            }
           await TriggerAction(this.moveTask(task.id, {project_dev_stage_id: this.stage.id,position}))

        },
        async deleteTask(id){
             const res = await TriggerAction(this.deleteProjectTask(id), TASK_DELETE_SUCCESS_MESSAGE, true)
             if (res){
                 this.tasks = this.tasks.filter(task => task.id !== id);
             }
        },
        async updateTask(data,task_id){
            const res = await TriggerAction(this.updateProjectTask(task_id,data),TASK_UPDATE_SUCCESS_MESSAGE,true)
            if(res){
                await this.fetchUser(data.user_id);
                const { title, description } = data;
                const updatedTask = { title, description, user: { ...this.user } };

                this.tasks = this.tasks.map(task => {
                    if (task.id === task_id) {
                        return {
                            ...task,
                            ...updatedTask,
                        };
                    }
                    return task;
                });
            }
        }
    },
    computed:{
        ...mapState(useUserStore,['user']),
        tasks:{
            get(){
                return this.stage.tasks
            },
            set(value){
                this.stage.tasks = value
            }
        }
    }
}
</script>

<style scoped>

</style>
