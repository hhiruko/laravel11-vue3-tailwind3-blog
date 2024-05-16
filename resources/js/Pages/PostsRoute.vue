<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";
import {useRoute} from "vue-router";
import moment from "moment";

const post = ref({});
const request = async () => {
    await axios
        .get('/api/posts/' + useRoute().params.id)
        .then(response => {
            post.value = response.data
        })
}

onMounted(request);
</script>

<template>
    <div class="flex">
        <div class="w-3/5">
            <div class="m-12 w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <img class="p-8 rounded-t-lg" src="https://smb.telkomuniversity.ac.id/wp-content/uploads/2023/09/spesifikasi-laptop.jpg" alt="" />
                <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">{{post.title}}</h5>
                <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">{{post.body}}</p>
                <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-600 float-end">{{post.user?.name}}</p>
                <p class="mb-10 text-base text-gray-500 sm:text-lg dark:text-gray-600">Last edited: {{moment(post.updated_at).format('lll')}}</p>

                <h5 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Comments:</h5>
                <div class="m-2" v-for="comment of post.comments">
                    <p class="dark:text-gray-400 float-right">Last edited: {{moment(comment.updated_at).format('lll')}}</p>
                    <p class="dark:text-gray-400">{{comment.user.name}}</p>
                    <p class=" text-xl dark:text-white">{{comment.comment}}</p>
                </div>
            </div>
        </div>
        <div class="w-2/5">

        </div>
    </div>
</template>
