<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";
import moment from "moment";

const params = new URL(document.location.toString()).searchParams;
const posts = ref([]);
const name = ref([]);
const request = async () => {
    await axios
        .get('/api/posts?' + params.toString())
        .then(response => {
            posts.value = response.data
        })
    await axios
        .get('/api/user')
        .then(response => {
            name.value = response.data
        })
}

const prev = (page) => {
    if (page !== 1) {
        page--;
        params.set('page', page);
        request();
    }
}

const next = (page, last) => {
    if (page !== last) {
        page++;
        params.set('page', page);
        request();
    }
}

onMounted(request);
</script>

<template>
    <div class="flex">
        <div class="w-2/5 m-12 ">
            <h1 class="mb-3 text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Imitating: {{name.name}}</h1>
            <a href="/posts/create" type="button" class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 shadow-lg shadow-cyan-500/50 dark:shadow-lg dark:shadow-cyan-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Create post</a>
        </div>
        <div class="w-3/5">
            <div class="mt-12 flex flex-col items-center">
                <span class="text-sm text-gray-700 dark:text-gray-400">
                    Showing <span class="font-semibold text-gray-900 dark:text-white">{{posts.from}}</span> to <span class="font-semibold text-gray-900 dark:text-white">{{posts.to}}</span> of <span class="font-semibold text-gray-900 dark:text-white">{{posts.total}}</span> Posts
                </span>
                <div class="inline-flex mt-2 xs:mt-0">
                    <button @click="prev(posts.current_page)" class="flex items-center justify-center px-4 h-10 text-base font-medium text-white bg-gray-800 rounded-s hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        Prev
                    </button>
                    <button @click="next(posts.current_page, posts.last_page)" class="flex items-center justify-center px-4 h-10 text-base font-medium text-white bg-gray-800 border-0 border-s border-gray-700 rounded-e hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        Next
                    </button>
                </div>
            </div>
            <a v-for="post of posts.data" :href="'/posts/' + post.id" class="m-12 flex flex-col mx-auto bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                <img class="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-s-lg" src="https://smb.telkomuniversity.ac.id/wp-content/uploads/2023/09/spesifikasi-laptop.jpg" alt="">
                <div class="flex flex-col justify-between p-4 leading-normal">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{post.title}}</h5>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{post.user.name}}</p>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{moment(post.created_at).format('L')}}</p>
                </div>
            </a>
        </div>
    </div>
</template>
