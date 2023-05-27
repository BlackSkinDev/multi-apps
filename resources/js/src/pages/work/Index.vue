<template>
    <div class="px-16 mt-28">
        <h1>Your Work</h1>
    </div>
</template>

<script>
import {APP_NAME} from "../../constants/constants";

export default {
    name: "Index",
    created() {
        document.title = `${APP_NAME} | Your Work`;
    }
}
</script>

<style scoped>

</style>
