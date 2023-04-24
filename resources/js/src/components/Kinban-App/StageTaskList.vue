<template>
    <div>
        <div class="flex items-center justify-between px-3 py-2">
            <h3 class="text-sm font-semibold ~text-gray-700">{{stage.name}}</h3>
            <Menu as="div" class="relative z-10">
                <MenuButton class="hover:bg-gray-300 w-8 h-8 rounded-md grid place-content-center">
                    <DotsHorizontalIcon class="w-5 h-5"/>
                </MenuButton>
                <transition
                    enter-active-class="transition transform duration-100 ease-out"
                    enter-from-class="opacity-0 scale-90"
                    enter-to-class="opacity-100 scale-100"
                    leave-active-class="transition transform duration-100 ease-in"
                    leave-from-class="opacity-100 scale-100"
                    leave-to-class="opacity-0 scale-90"
                >
                    <MenuItems class="origin-top-left mt-2 focus:outline-none absolute left-0 bg-white overflow-hidden rounded-md shadow-lg border w-32">
                        <MenuItem v-slot="{active}">
                            <a href="#" :class="{'bg-gray-100': active}" class="block px-4 py-2 text-sm text-g-700">Edit</a>
                        </MenuItem>
                        <MenuItem v-slot="{active}">
                            <a href="#" :class="{'bg-gray-100': active}" class="block px-4 py-2 text-sm text-red-500">Delete</a>
                        </MenuItem>
                    </MenuItems>
                </transition>
            </Menu>
        </div>
        <div class="px-3 pb-3 overflow-y-auto">
            <ul class="space-y-3">
                <li
                    v-for="(task,idx) in stage.tasks"
                    :key="idx"
                    class="cursor-pointer group relative bg-white p-3 shadow rounded-md border-b border-gray-300 hover:bg-gray-50"
                >
                    <p href="#" class="text-sm w-5/6 break-all">{{task.title}}</p>
                    <Menu as="div" class="relative z-50">
                        <MenuButton class="hidden absolute -top-7 right-1 w-8 h-8 bg-gray-50 group-hover:grid place-content-center rounded-md text-gray-600 hover:text-black hover:bg-gray-200">
                            <PencilIcon class="w-5 h-5"/>
                        </MenuButton>
                        <transition
                            enter-active-class="transition transform duration-100 ease-out"
                            enter-from-class="opacity-0 scale-90"
                            enter-to-class="opacity-100 scale-100"
                            leave-active-class="transition transform duration-100 ease-in"
                            leave-from-class="opacity-100 scale-100"
                            leave-to-class="opacity-0 scale-90"
                        >
                            <MenuItems class="origin-top-left mt-2 focus:outline-none absolute -right-5 bg-white overflow-hidden rounded-md shadow-lg border w-32">
                                <MenuItem v-slot="{active}">
                                    <a href="#" :class="{'bg-gray-100': active}" class="block px-4 py-2 text-sm text-g-700" @click="hey">Edit</a>
                                </MenuItem>
                                <MenuItem v-slot="{active}">
                                    <a href="#" :class="{'bg-gray-100': active}" class="block px-4 py-2 text-sm text-red-500">Delete</a>
                                </MenuItem>
                            </MenuItems>
                        </transition>
                    </Menu>
                    <div class="mt-10 flex justify-between items-center">
                        <p class="text-sm text-gray-800 break-all  w-5/6">{{task.reference}}</p>
                        <div class="relative inline-flex items-center justify-center w-8 h-8 overflow-hidden bg-gray-100 rounded-full bg-red-500">
                            <span class="font-bold text-white text-sm">{{task.user?.initial || '?'}}</span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import {DotsHorizontalIcon,PencilIcon} from "@heroicons/vue/solid"
import {Menu,MenuButton,MenuItem,MenuItems} from '@headlessui/vue'
export default {
    name: "Task",
    components: {
        DotsHorizontalIcon,
        PencilIcon,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems

    },
    props:{
        stage:Object
    }
}
</script>

<style scoped>

</style>
