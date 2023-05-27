<template>
<h1>Your work</h1>
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
