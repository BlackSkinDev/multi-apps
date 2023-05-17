<template>
    <div class="relative">
        <label :for="forValue" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{label}}</label>
        <input
            :type="input_type"
            :placeholder="placeholder"
            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
        />
        <span class="text-red-600" :style="{fontSize:'12px'}" v-show="error">{{error}}</span>
        <div class="absolute right-2 top-9 cursor-pointer" @mousedown.prevent="togglePassword" v-show="input_type === 'text' && isPassword"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></div>
        <div class="absolute right-2 top-9 cursor-pointer" @mousedown.prevent="togglePassword" v-show="input_type === 'password' && isPassword "><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg></div>


    </div>

</template>

<script>
import {ValidateEmail, ValidatePassword, ValidateUsername} from "../../util";


export default {
    name: "input",
    props:['label','forValue','type','placeholder','modelValue','isPassword','name'],
    data(){
        return{
            input_type:this.type ?? "password",
            error:"",
        }
    },
    methods:{
        togglePassword(){
            if (this.input_type === 'password') {
                this.input_type = 'text'
            }
            else{
                this.input_type = 'password'
            }
        },
        validate(){
            if (this.input_type === 'email'){
                if(!ValidateEmail(this.modelValue) && this.modelValue !== '')this.error = "Please enter a valid email address"
                else this.error = ""
            }

            if (this.name === 'password' || this.isPassword){
                if(!ValidatePassword(this.modelValue) && this.modelValue !== '')this.error = "Password cannot be less than 6 characters"
                else this.error = ""
            }

            if (this.name === 'username'){
                if(!ValidateUsername(this.modelValue) && this.modelValue !== '')this.error = "Username cannot be less than 6 characters"
                else this.error = ""
            }
        },
        clearError(){
            this.error = ''
        }

    },


    watch:{
        modelValue(val){
            if (val!=='') {
                if (this.validateTimeout) {
                    clearTimeout(this.validateTimeout)
                }
                this.validateTimeout= setTimeout( ()=>{
                    this.validate();
                },1000)

            }
        }

    }


}
</script>

<style scoped>

</style>
