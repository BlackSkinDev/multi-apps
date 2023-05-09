<template>
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0 mt-32">
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Welcome back <span class="ml-4">&#128075;</span>
                </h1>
                <form class="space-y-4 md:space-y-6" action="#" @submit.prevent="create">
                    <Input
                        label="Email"
                    />
                    <Input
                        label="Password"
                    />
                    <Button :text="'Login'" :disabled="false"></Button>
                </form>
            </div>
        </div>
    </div>


</template>

<script>

import Input from "../../components/ui/input.vue";
import Button from "../../components/ui/button.vue";
export default {
    name: "login.vue",
    components:{Input,Button}
}
</script>

<style scoped>

</style>
