<template>
    <div>
        <div v-show="loading" class="h-1 bg-gray-200">
            <div :style="{ width: progress + '%' }" class="h-1 bg-red-500"></div>
        </div>
        <p v-if="loading"></p>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            progress: 0,
        };
    },
    mounted() {
        this.simulateLoading();
        window.addEventListener('load', () => {
            this.loading = false;
        });
    },
    methods: {
        simulateLoading() {
            this.loading = true;
            this.progress = 0;

            // get the total page load time from performance.timing
            const pageLoadTime = window.performance.timing.loadEventEnd - window.performance.timing.navigationStart;

            // set the interval time based on the total page load time
            const intervalTime = Math.floor(pageLoadTime / 100);

            const interval = setInterval(() => {
                this.progress += 1;
                if (this.progress >= 100) {
                    clearInterval(interval);
                    this.progress = 100;
                    this.loading = false;
                }
            }, intervalTime);

        },
    },
};
</script>
