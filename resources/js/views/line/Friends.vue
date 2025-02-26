<script setup>
import { ref, onMounted } from "vue";
import { useJunbanStore } from '@/stores/junban';  
import { API_LINE_FRIENDS } from "@/api";

const myStore = useJunbanStore()

const users = ref([]);
const next = ref('');
const current = ref('');
const followersCount = ref(0)

onMounted(async () => {
  await fetchData();
});

const fetchData = async () => {
    window.scrollTo(0,0)
    const fetchUrl = `${API_LINE_FRIENDS}/?next=${next.value}`
    myStore.showLoader = true
    await axios
    .get(fetchUrl)
    .then((response) => {
      if (response.data.status == "success") {
        users.value = response.data.data;
        next.value = response.data.next;
        current.value = response.data.current;
        followersCount.value = response.data.followersCount;
        } 
    })
    .catch((error) => console.log(error))
    .finally(() => (myStore.showLoader = false));
}

const resetUser = () => {
    next.value = ''
    fetchData()
}

const exportList = async () => {
    const fetchUrl = `${API_LINE_FRIENDS}/?next=${current.value}&&action=export`
    window.open(fetchUrl)
}
</script>
<template>
<div class="person pt-2">
    <p>Friends: {{ users.length }} of {{ followersCount }} <button class="btn btn-primary float-right" @click="exportList()">エクスポート</button></p>
    <div class="d-block">
        <p>
            
        </p>
    </div>
    <div class="table-responsive">
        <table class="table line-table">
            <thead>
                <tr>
                    <th class="text-center">プロフィール写真</th>
                    <th class="text-center">ユーザー名</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users">
                    <td>
                        <div class="line-picture">
                            <img :src="user.pictureUrl" alt="">
                        </div>
                    </td>
                    <td>{{ user.displayName }}</td>
                </tr>
            </tbody>
        </table>
        <button class="btn btn-warning mr-1" @click.prevent="resetUser()" >リセット</button>
        <button class="btn btn-primary" @click.prevent="fetchData()" v-if="next != ''">次へ</button>
    </div>
</div>
</template>

<style>
    .line-table td{
        padding: 5px 10px;
    }
    .line-picture {
        height: 50px;
        width: 50px;
        display: inline-block;
    }
    .mr-1 {
        margin-right: 10px;
    }
    .float-right {
        float: right;
    }
</style>