<template>
    <Modal  :isOpen="isOpen" :title="'Delete Confirmation'" :width="400" @close-modal="close" :classes="'mt-20'">
        <div class="mt-3 text-center sm:mt-0 sm:text-left">
            <div class="mt-2">
                <p class="text-sm leading-5 text-gray-500">
                    Are you sure you want to delete this {{item_type}}? This action cannot be undone.
                </p>
            </div>
        </div>

        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
          <button @click="deleteItem" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
            Delete
          </button>
        </span>
            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
          <button @click="close" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5" >
            Cancel
          </button>
        </span>
        </div>
    </Modal>
</template>

<script>

import Modal from "../ui/Modal.vue";
export default {
    name: "DeleteConfirmation",
    components:{Modal},
    props:{
        isOpen:Boolean,
        item_id:Number,
        item_type:String

    },
    data(){
        return{

        }
    },
    methods:{

        close(){
            this.$emit('close-modal')
        },

        deleteItem(){
            this.$emit('deleteSelectedItem',this. item_id)
        }

    },


}
</script>

<style scoped>

</style>
