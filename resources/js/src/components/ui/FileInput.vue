<template>
    <div class="relative">
        <label :for="forValue" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{label}}</label>
        <input
            type="file"
            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            @change="onFileInputChange"
        />

    </div>

</template>

<script>

export default {
    name: "input",
    props:['label','forValue','modelValue'],
    data(){
        return{

        }
    },
    methods:{
        onFileInputChange(event) {
            const file = event.target.files[0];
            this.$emit('file-selected', file);
        }
    }
}
</script>

<style scoped>

</style>
