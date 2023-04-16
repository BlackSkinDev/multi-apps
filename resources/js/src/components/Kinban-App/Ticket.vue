<template>
    <div class="mt-2 bg-white rounded-lg p-4 cursor-pointer inline-block w-full shadow"  @mouseover="showIcon = true" @mouseleave="showIcon = false" ref="ticket-div">
        <div class="flex relative">
            <h2 class="w-5/6 text-gray-800">{{ticket?.name}}</h2>
            <div class="absolute right-0 cursor-pointer bg-gray-100 p-2 h-10 rounded" v-show="showIcon" @click="showDropdown=!showDropdown" >
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="2"></circle>
                    <circle cx="6" cy="12" r="2"></circle>
                    <circle cx="18" cy="12" r="2"></circle>
                </svg>
            </div>
            <div class="absolute right-0 " v-if="showDropdown">
                <div class="fixed z-50 w-full h-full top-0 left-0" @click="showDropdown=false,showIcon=false"></div>
                <ul class="absolute bg-white border shadow-xl rounded right-0  z-10 py-2 w-32 z-50" :style="{fontSize:'12px'}" :class="atLastTicket ? 'bottom-2' : 'top-11' " v-if="showDropdown">
                    <h1 class="px-4 border-b text-gray-500 font-bold py-1">Actions</h1>
                    <li class="px-3 py-2 hover:bg-gray-100 whitespace-nowrap font-medium" @click.stop="">Home</li>
                    <li class="px-3 py-2 hover:bg-gray-100 whitespace-nowrap font-medium " @click.stop="">About</li>
                    <li class="px-3 py-2 hover:bg-gray-100 whitespace-nowrap font-medium " @click.stop="">Contact Us</li>
                    <li class="px-3 py-2 hover:bg-gray-100 whitespace-nowrap font-medium " @click.stop="">Bottom of Column</li>
                </ul>
            </div>

        </div>
        <div class="mt-10 flex justify-between items-center">
            <p class="">{{ticket?.ref}}</p>
            <div class="relative inline-flex items-center justify-center w-8 h-8 overflow-hidden bg-gray-100 rounded-full bg-red-500">
                <span class="font-bold text-white text-sm">{{ticket?.assignee?.initial}}</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Ticket.vue",
    props:{
        ticket:Object,
        lastTicketId:Number
    },
    data(){
        return{
            showIcon:false,
            showDropdown:false
        }
    },
    computed:{
        atLastTicket(){
            return this.ticket.id === this.lastTicketId
        }
    }
}
</script>

<style scoped>

</style>
