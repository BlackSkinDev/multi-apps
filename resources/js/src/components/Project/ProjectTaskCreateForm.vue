<template>
    <Modal  :isOpen="isOpen" :title="'Create Task'" :width="700" @close-modal="close" :classes="'mt-6'">
        <div class="mt-2 space-y-6">
            <TextInput label="Title" placeholder="Title" v-model="taskForm.title"/>
            <AutoCompleteInput label="Assignee (hit the @ key to being search)" placeholder="Assign" @item-selected="setAssignee"/>
            <RichEditor label="Description" @editor-text="setEditorValue"/>
        </div>
        <div class="mt-6">
            <button
                type="button"
                class="inline-flex justify-center rounded-md border border-transparent bg-blue-500 px-4 py-2 text-sm font-medium text-white hover:bg-blue-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                @click="saveTask"
                :disabled="processingRequest"
            >
                Create Task
            </button>
        </div>
    </Modal>
</template>
<script>

import {useProjectStore} from "../../store/ProjectStore";
import {mapState} from "pinia";
import Modal from "../ui/Modal.vue";
import RichEditor from "../ui/RichEditor.vue";
import TextInput from "../ui/input.vue";
import Select from "../ui/Select.vue";
import {UserCircleIcon} from "@heroicons/vue/solid"
import AutoCompleteInput from "../ui/AutoCompleteInput.vue";
export default {
    name: "ProjectTaskCreateForm",
    components:{Modal,RichEditor,TextInput,Select,UserCircleIcon,AutoCompleteInput},
    props:{
        isOpen:Boolean
    },
    data(){
        return{
            taskForm:{
                title:"",
                user_id:"",
                description:""
            },
        }
    },
    methods:{
        setEditorValue(value){
            this.taskForm.description = value
        },
        resetForm(){
            this.taskForm = {
                title:"",
                description:"",
                user_id:"",
            }
        },
        saveTask(){
            this.$emit('save',this.taskForm)
        },
        close(){
            this.$emit('close-modal')
        },
        setAssignee(user_id){
            this.taskForm.user_id = user_id
        }

    },
    computed:{
        ...mapState(useProjectStore,{
            processingRequest:(state) => state.processingRequest
        }),
        users:{
            get(){
                return useProjectStore().users
            },
            set(value){
                useProjectStore().users = value
            }
        }

    },



}
</script>

<style scoped>

</style>
