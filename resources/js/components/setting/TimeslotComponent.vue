<script setup>
import { ref, onMounted } from "vue";
import { useJunbanStore } from '@/stores/junban';  
import { API_YOUYAKUBI_BYDATE, API_YOUYAKUBI_TSUPDATE, API_YOUYAKUBI_TSDELETE, API_YOUYAKUBI_TSCREATE } from "@/api";



const emit = defineEmits(["toggleTimeslot"]);
const props = defineProps(["yoyaku_date", "isPremium"]);

const myStore = useJunbanStore()

onMounted(async () => {
  await fetchData();
});

const yoyakubi = ref({
    id: '',
    title: '',
    yoyakujikan: '',
})

const ts_form = ref({
    start_time: '',
})
const fetchData = async () => {
    myStore.showLoader = true
    let payLoad = new FormData();
    payLoad.append("yoyaku_date", props.yoyaku_date);
  
    await axios
    .post(API_YOUYAKUBI_BYDATE, payLoad)
    .then((response) => {
      if (response.data.status == "success") {
        yoyakubi.value = response.data.data
      } 
    })
    .catch((error) => console.log(error))
    .finally(() => (myStore.showLoader = false));
}

const updateTs = async (id, start_time) => {
    myStore.showLoader = true
    let payLoad = new FormData();
    payLoad.append("id", id);
    payLoad.append("start_time", start_time);
  
    await axios
    .post(API_YOUYAKUBI_TSUPDATE, payLoad)
    .then((response) => {
      if (response.data.status == "success") {
         alert(response.data.message)
      }
    })
    .catch((error) => {
        alert('エラー')
        console.log(error)
})
    .finally(() => (myStore.showLoader = false));
}

const deleteTs = async (id) => {
    const res = confirm('本当に削除しますか？')
    if(res) {
        myStore.showLoader = true
        let payLoad = new FormData();
        payLoad.append("id", id);
    
        await axios
        .post(API_YOUYAKUBI_TSDELETE, payLoad)
        .then((response) => {
        if (response.data.status == "success") {
            alert(response.data.message)
            fetchData()
        } 
        })
        .catch((error) => console.log(error))
        .finally(() => (myStore.showLoader = false));
    }
    return 
}


const handleSubmit = async () => {
   
   myStore.showLoader = true;
   let payLoad = new FormData();
   payLoad.append("start_time", ts_form.value.start_time);
   payLoad.append("yoyakubi_id", yoyakubi.value.id);
   payLoad.append("is_premium", props.isPremium);
   
   await axios
     .post(API_YOUYAKUBI_TSCREATE, payLoad)
     .then((response) => {
       if (response.data.status == "success") {
         alert(response.data.message)
         fetchData()
         ts_form.value.start_time = ''
        } 
     })
     .catch((error) => {
        console.log(error)
        alert('イラー')
    })
     .finally(() => (myStore.showLoader = false));
 };

</script>
<template>
    <div id="myModal" class="modal" >
            <div class="modal-content">
                <div class="mh">
                    <span class="close" @click="$emit('toggleTimeslot')">&times;</span>
                    <h3>{{ yoyakubi.title }}時間帯</h3>
                </div>
                <p>スタート時間 {{ isPremium == 1 ?'「プレミアムプラン」':'' }}</p>
                <table>
                    <tr v-for="ts in yoyakubi.yoyakujikan">
                        <template v-if="ts.is_premium == isPremium">
                            <td>
                            <input type="text" v-model="ts.format_start_time">
                        </td>
                        <td>
                            <a href="" class="ts-edit" @click.prevent="updateTs(ts.id, ts.format_start_time)">編集</a>
                            <a href="" class="ts-del" @click.prevent="deleteTs(ts.id)">削除</a>
                        </td>
                        </template>
                        
                    </tr>
          
                </table>
        <form method="post" @submit.prevent="handleSubmit" class="mt-4">
                
                <p >スタート時間：</p>
                <input type="text" v-model="ts_form.start_time" required placeholder="09:00">
                <div class="management-btn"><button class="management-btn-btn" type="submit" name="btn" value="登録" 
                    style="width:150px; 
                    margin: 10px 0;
                    padding: 5px;
                    font-size: 15px;
                    ">追加する</button>
                </div>
            </form>

            </div>
    </div>
</template>