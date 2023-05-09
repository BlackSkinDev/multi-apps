<template>
    <div>
        <label  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{label}}</label>
        <Editor
            :api-key="api_key"
            :init="init"
            v-model="editorData"
        />
    </div>
</template>

<script>
import Editor from '@tinymce/tinymce-vue'
import {TINYMCE_MEDIA_UPLOAD_URL} from "../../constants/kinban-app-constants";

export default {
    name: 'app',
    components:{Editor},
    props:{
        label:String,
        defaultValue:String
    },
    data() {
        return {
            init:{
                height: 250,
                menubar: true,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar:
                    'undo redo | formatselect | bold italic backcolor underline image code| \
                    alignleft aligncenter alignright alignjustify | \
                    bullist numlist outdent indent | removeformat | help |fontselect|fontsizeselect ',
                images_upload_url: TINYMCE_MEDIA_UPLOAD_URL,
                automatic_uploads: true,
                images_upload_credentials: true
            },
            api_key:import.meta.env.VITE_TINY_MCE_KEY,
            editorData:this.defaultValue
        };
    },
    watch:{
        editorData(newVal){
            this.$emit('editor-text',newVal)
        }
    }
}
</script>
