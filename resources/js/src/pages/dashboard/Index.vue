<template>
    <div class="container mx-auto">
        <div class="flex flex-wrap justify-center -mx-4 mt-32">
            <div v-for="(app, index) in apps" :key="index" class="w-full md:w-1/3 px-4 mb-4 mx-auto">
                <router-link :to="{name:app.route}">
                    <div class="bg-gray-200 h-40 w-30 flex flex-col justify-center items-center rounded-md cursor-pointer ">
                        <span class="text-xl mt-4 mb-4">{{ app.name }}</span>
                    </div>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
import {APP_NAME} from "../../constants/constants";

export default {
    data() {
        return {
            apps: [
                { name: 'Manage Projects',route:'homepage'},
                { name: 'Manage Project Stages',route:'homepage' },
                { name: 'Other',route:'homepage'},
            ],
            app_name:APP_NAME
        };
    },
    mounted() {
        document.title = `${this.app_name} | Dashboard`;
    },
};
</script>

<style scoped>
/* Add any additional styles here */
.app-card > svg{
    width: 100%;
    height: 100%;
}
</style>
