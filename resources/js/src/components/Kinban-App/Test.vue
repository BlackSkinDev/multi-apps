<template>
    <div class="relative p-10">
        <h1
            class="text-4xl font-bold cursor-pointer inline-block"
            @click="editing = true, newHeading = heading"
            v-show="!editing"
        >
            {{ heading }}
        </h1>
        <input
            class="text-4xl font-bold  w-full absolute top-0 left-0"
            v-show="editing"
            v-model="newHeading"
            v-on:keyup.enter="$event.target.blur()"
            @blur="updateHeading"
        />
    </div>
</template>

<script>
export default {
    data() {
        return {
            heading: "Editable Heading",
            newHeading: "",
            editing: false,
        };
    },
    methods: {
        updateHeading() {
            // Make API call to update the heading
            // For example, using Axios:

            this.heading = this.newHeading;
            this.editing = false;
            this.newHeading = "";


            // axios.put("/api/update-heading", { newHeading: this.newHeading })
            //     .then(response => {
            //         this.heading = this.newHeading;
            //         this.editing = false;
            //         this.newHeading = "";
            //     })
            //     .catch(error => {
            //         console.error(error);
            //     });
        },
    },
};
</script>
