<template xmlns="http://www.w3.org/1999/html">
    <div>
        <label  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{label}}</label>
        <select
            v-model="selectedOption"
            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            required="">
            <option value="">Select Project</option>
            <option v-for="option in options" :value="option.id">{{ option.name }}</option>
        </select>

    </div>

</template>

<script>
export default {
    name: "input",
    props:['label','options'],
    data() {
        return {
            selectedOption: ""
        };
    },
    watch: {
        selectedOption(newValue) {
            this.$emit("option-selected", newValue);
        }
    }
}
</script>

<style scoped>

</style>
