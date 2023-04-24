<template>
    <TransitionRoot appear :show="isOpen" as="template">
        <Dialog as="div" @close="close" class="relative z-10">
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black bg-opacity-40" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto"  >
                <div class="flex mt-32 items-center justify-center p-4 text-center">
                    <DialogPanel
                        class="transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all "
                        :style="{width:`${width}px`}"
                    >
                        <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                            {{ title }}
                        </DialogTitle>
                        <div class="py-4">
                            <slot />
                        </div>
                    </DialogPanel>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import {
    Dialog,
    DialogTitle,
    DialogPanel,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue';

export default {
    components: {
        Dialog,
        DialogTitle,
        DialogPanel,
        TransitionChild,
        TransitionRoot,
    },
    props: {
        isOpen: {
            type: Boolean,
            default: false,
        },
        title: {
            type: String,
            default: '',
        },
        width: {
            type: Number,
            default: '500',
        },
    },
    methods:{
        close(){
            this.$emit('close-modal')
        }
    }
};
</script>
