<template>
    <div class="bg-white  border-2  p-4 cursor-pointer mt-4">
        <h2 class="text-lg font-semibold mb-2">{{task?.name}}</h2>
        <p class="text-sm text-gray-500">Date Created: {{task?.created_at}}</p>
        <p class="mt-4 font-bold">Priority : {{task?.priority}}</p>
        <div class="flex justify-between">
            <router-link :to="{name:'edit',params:{id:task.id}}" class="text-blue-500 hover:underline">Edit</router-link>
            <p class="text-red-500 hover:underline" @click="destroy(task.id)">Delete</p>
        </div>
    </div>
</template>

<script>
import {useTaskStore} from "../../store/TaskStore";
import {mapActions} from "pinia";
export default {
    name: "TaskCard",
    data() {

    },
    props:{
      task:Object
    },
    methods: {
        ...mapActions(useTaskStore,['deleteTask']),
        async destroy(task_id) {
            if (confirm("Delete task?")){
                await this.deleteTask(task_id)
            }
        }
    },
}
</script>

<style scoped>

</style>
