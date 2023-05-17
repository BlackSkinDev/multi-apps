<template>
    <div class="relative">
        <!-- Render the target elements -->
        <div v-for="(step, index) in tourSteps" :key="index" :id="'target-' + index" class="w-16 h-16 bg-red-500 m-4 absolute">
            <!-- Target element content -->
        </div>

        <!-- Render the tour content -->
        <div v-if="currentStep !== null" class="absolute top-8 left-8 bg-white shadow p-4">
            <h3 class="text-xl font-bold">{{ tourSteps[currentStep].title }}</h3>
            <p class="">{{ tourSteps[currentStep].content }}</p>

            <!-- Navigation buttons -->
            <div class="mt-4">
                <button @click="prevStep" :disabled="currentStep === 0" class="px-4 py-2 bg-black text-white mr-2 cursor-pointer">Previous</button>
                <button @click="nextStep" :disabled="currentStep === tourSteps.length - 1" class="px-4 py-2 bg-black text-white mr-2 cursor-pointer">Next</button>
                <button @click="endTour" class="px-4 py-2 bg-black text-white cursor-pointer">End Tour</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            currentStep: null,
            tourSteps: [
                {
                    title: 'Step 1',
                    content: 'This is the first step of the tour.',
                },
                {
                    title: 'Step 2',
                    content: 'This is the second step of the tour.',
                },
                {
                    title: 'Step 3',
                    content: 'This is the third step of the tour.',
                },
            ],
        };
    },
    methods: {
        nextStep() {
            this.currentStep++;
        },
        prevStep() {
            this.currentStep--;
        },
        endTour() {
            this.currentStep = null;
        },
    },
    mounted() {
        this.currentStep = 0;

        // Randomly position the target elements
        this.tourSteps.forEach((step, index) => {
            const targetElement = document.getElementById(`target-${index}`);
            if (targetElement) {
                const top = Math.random() * (window.innerHeight - 100);
                const left = Math.random() * (window.innerWidth - 100);
                targetElement.style.top = `${top}px`;
                targetElement.style.left = `${left}px`;
            }
        });
    },
};
</script>
