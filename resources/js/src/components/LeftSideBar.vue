<template>
    <div class="hidden md:block bg-white w-64 py-8 border-r bg-zinc-50 mt-16">
        <div class="flex items-center justify-start space-x-1 px-2">
            <div>
                <img :src="company.image" alt="Company Logo" class="h-10 w-14">
            </div>
            <div class="space-y-1">
                <h2 class="text-lg font-bold">{{company.name}}</h2>
                <p class="text-gray-500" :style="{fontSize:'12px'}" v-html="company.description"></p>
            </div>
        </div>

        <nav class="mt-12 px-6">
            <ul class="space-y-8">
                <li v-for="link in sidebarLinks" :key="link.id">
                    <a :href="link.url" class="flex items-center space-x-2 text-gray-600 hover:text-gray-900">
                        <div v-html="link.svg"></div>
                        <span>{{ link.title }}</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>

export default {
    props:{
        company:Object
    },
    data() {
        return {
            sidebarLinks: [
                {
                    id: 2,
                    title: 'Projects',
                    url: '#',
                    svg:` <svg width="24" height="24" viewBox="0 0 24 24" role="presentation"><path d="M6 2h10a3 3 0 010 6H6a3 3 0 110-6zm0 2a1 1 0 100 2h10a1 1 0 000-2H6zm4 5h8a3 3 0 010 6h-8a3 3 0 010-6zm0 2a1 1 0 000 2h8a1 1 0 000-2h-8zm-4 5h6a3 3 0 010 6H6a3 3 0 010-6zm0 2a1 1 0 000 2h6a1 1 0 000-2H6z" fill="currentColor" fill-rule="evenodd"></path></svg>`,
                },
                {
                    id: 3,
                    title: 'Backlog',
                    url: '#',
                    svg:`<svg width="24" height="24" viewBox="0 0 24 24" role="presentation"><g fill="currentColor"><path d="M5 19.002C5 19 17 19 17 19v-2.002C17 17 5 17 5 17v2.002zm-2-2.004C3 15.894 3.895 15 4.994 15h12.012c1.101 0 1.994.898 1.994 1.998v2.004A1.997 1.997 0 0117.006 21H4.994A1.998 1.998 0 013 19.002v-2.004z"></path><path d="M5 15h12v-2H5v2zm-2-4h16v6H3v-6z"></path><path d="M7 11.002C7 11 19 11 19 11V8.998C19 9 7 9 7 9v2.002zM5 8.998C5 7.894 5.895 7 6.994 7h12.012C20.107 7 21 7.898 21 8.998v2.004A1.997 1.997 0 0119.006 13H6.994A1.998 1.998 0 015 11.002V8.998z"></path><path d="M5 5v2h12V5H5zm-2-.002C3 3.894 3.895 3 4.994 3h12.012C18.107 3 19 3.898 19 4.998V9H3V4.998z"></path></g></svg>`,
                },
            ],
        };
    },

};
</script>

<style>
/* Add your custom styles for the Jira sidebar here */
</style>
