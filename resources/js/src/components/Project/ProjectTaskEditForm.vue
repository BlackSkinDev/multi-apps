<template>
    <Modal  :isOpen="isOpen" :title="'Edit Task'" :width="700" @close-modal="close" :classes="'mt-6'">
        <div class="mt-2 space-y-6">
            <TextInput label="Title" placeholder="Title" v-model="taskForm.title"/>
            <AutoCompleteInput
                label="Assignee (hit the @ key to being search)"
                placeholder="Assignee"
                @item-selected="setAssignee"
                :task="task"
            />
            <RichEditor label="Description"  @editor-text="setEditorValue" :defaultValue="taskForm.description"/>
        </div>
        <div class="mt-6">
            <button
                type="button"
                class="inline-flex justify-center rounded-md border border-transparent bg-blue-500 px-4 py-2 text-sm font-medium text-white hover:bg-blue-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                @click="updateTask"
                :disabled="processingRequest"
            >
                Update Task
            </button>
        </div>
    </Modal>
</template>

<script>

import {useProjectStore} from "../../store/ProjectStore";
import {mapState,mapActions} from "pinia";
import Modal from "../ui/Modal.vue";
import RichEditor from "../ui/RichEditor.vue";
import TextInput from "../ui/TextInput.vue";
import AutoCompleteInput from "../ui/AutoCompleteInput.vue";

export default {
    name: "ProjectTaskEditForm",
    components:{Modal,RichEditor,TextInput,AutoCompleteInput},
    props:{
        isOpen:Boolean,
        task:Object
    },
    data(){
        return{
            taskForm:{
                title:this.task?.title,
                user_id:this.task?.user_id,
                description:this.task?.description
            }
        }
    },
    methods:{
        ...mapActions(useProjectStore,['fetchUsers']),
        setEditorValue(value){
            this.taskForm.description = value
        },
        setAssignee(value){
            this.taskForm.user_id = value
        },
        resetForm(){
            this.taskForm = {
                title:"",
                assignee:"",
                description:""
            }
        },
        updateTask(){
            this.$emit('update',this.taskForm,this.task.id)
        },
        close(){
            this.$emit('close-modal')
        },

    },
    computed:{
        ...mapState(useProjectStore,{
            processingRequest:(state) => state.processingRequest
        }),

    },

}
</script>

<style scoped>

</style>
