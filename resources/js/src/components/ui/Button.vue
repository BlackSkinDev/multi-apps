<template>
    <button :disabled="disabled"
            :class="[(disabled || loading) ? 'opacity-50 cursor-not-allowed' : '', 'w-full bg-blue-700 hover:bg-blue-600', bgClass]"
            class="text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center"
            style="box-shadow: none; border-color: transparent;"
    >
        <div class="flex items-center justify-center gap-5">
            <p>{{!loading ? text : 'Processing...'}}</p>
            <sync-loader :loading="loading" :color="'white'"></sync-loader>
        </div>
    </button>



</template>

<script>
import SyncLoader from 'vue-spinner/src/SyncLoader.vue';


export default {
    name: "Button.vue",
    components:{
        SyncLoader
    },
    props: {
        disabled: Boolean,
        text: String,
        loading:Boolean,
        bgClass:String
    },
    methods:{

    }
}
</script>

<style scoped>

</style>
