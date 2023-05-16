<template>
    <div>
        <h2 class="text-2xl font-bold mb-4">Create Company</h2>
        <form @submit.prevent="submitForm" class="max-w-md mx-auto">
            <div class="mb-4">
                <label for="name" class="block mb-2 text-sm font-medium">Company Name</label>
                <input v-model="company.name" type="text" id="name" name="name" placeholder="Enter company name"
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="description" class="block mb-2 text-sm font-medium">Description</label>
                <textarea v-model="company.description" id="description" name="description" rows="4" placeholder="Enter company description"
                          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
            <div class="mb-4">
                <label for="logo" class="block mb-2 text-sm font-medium">Logo</label>
                <input type="file" id="logo" name="logo" accept="image/*" @change="handleLogoChange"
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600">Create</button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            company: {
                name: '',
                description: '',
                logo: null
            }
        };
    },
    methods: {
        submitForm() {
            // Handle form submission
            // Access form data via 'this.company'
            // Send data to backend or perform necessary actions
        },
        handleLogoChange(event) {
            const file = event.target.files[0];
            // Handle file upload
            // Assign 'file' to 'this.company.logo'
        }
    }
};
</script>
