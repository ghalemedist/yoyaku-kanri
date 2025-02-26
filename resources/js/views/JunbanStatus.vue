<script setup>
import { ref } from 'vue';
import { storeToRefs } from 'pinia';
import { useJunbanStore } from '../stores/junban'; 
import JunbanStatusList from '../components/JunbanStatusList.vue';

const myStore = useJunbanStore()
myStore.fetchJunbanStatusList()

const editStatus = (junban_status) => {
    myStore.junban_status_form = { ...junban_status }
    myStore.junban_status_form.showModal = ! myStore.junban_status_form.showModal
}
const deleteStatus = (junban_status) => {
    myStore.junban_status_form = { ...junban_status }
    const res = confirm('削除しますか？')
    if (res == true){
        myStore.deleteStatus()
    }
}

const loadModal = () => {
    myStore.junban_status_form.showModal = ! myStore.junban_status_form.showModal
    myStore.junban_status_form.ordering = myStore.junban_status_list.length + 1
    myStore.junban_status_form.id = 0
    myStore.junban_status_form.title = ''
    myStore.junban_status_form.category = '1'
    myStore.junban_status_form.send_message = false
    myStore.junban_status_form.message = ''
}
const hideModal = () => {
    myStore.junban_status_form.showModal = ! myStore.junban_status_form.showModal
    // myStore.fetchJunbanStatusList()
}

</script>
<template>
    <div class="page">
        <br/>
        <div class="management-title">【順番ステータス】<button class="management-btn-btn update-btn" @click="loadModal()">追加する</button></div>
        <br/>
        <table class="table2">
        <tbody>
            <tr>
                <th>順番</th>
                <th>タイトル</th>
                <th>カテゴリー</th>
                <th>更新</th>
            </tr>
            <tr v-for="junban_status in myStore.junban_status_list" 
                >
                <JunbanStatusList
                    :junban_status="junban_status" 
                    @editStatus="editStatus"
                    @deleteStatus="deleteStatus"
                    ></JunbanStatusList>
            </tr>
            
        </tbody>
    </table>
    <div class="alert alert-success" role="alert" data-mdb-color="success"
        :class="myStore.message.show && myStore.message.status == 'success'?'fadeOut':''">
        {{ myStore.message.message }}
    </div>
    </div>

    <div id="myModal" class="modal" v-if="myStore.junban_status_form.showModal">
        <form method="post" @submit.prevent="myStore.addStatus">
            <div class="modal-content">
                <span class="close" @click="hideModal">&times;</span>
                <h2>順番を追加する</h2>
                <h3>順番表示：</h3>
                <input type="number" v-model="myStore.junban_status_form.ordering" required>
                <h2>カテゴリー</h2>
                <select class="textfield" v-model="myStore.junban_status_form.category">
                    <option value="1">待機人</option>
                    <option value="2">診察中</option>
                    <option value="3">診察終了</option>
                </select>
                <h3>タイトル：</h3>
                <input type="text" v-model="myStore.junban_status_form.title" required>
                <h3>LINEで通知する：</h3>
                <label for="yes">
                    <input type="radio" id="yes" value="1" name="send_message"
                    v-model="myStore.junban_status_form.send_message">はい
                </label>
                <label for="no">
                    <input type="radio" id="no" value="0" name="send_message"
                    v-model="myStore.junban_status_form.send_message">いいえ
                </label>
                <!-- <input type="checkbox" 
                true-value="1"
                false-value="0" v-model="myStore.junban_status_form.send_message"> <label for="" style="font-size: 14px;">はい</label>  -->
                <h3>通知メッセージ</h3>
                <textarea v-model="myStore.junban_status_form.message"></textarea>
                <input type="hidden" v-model="myStore.junban_status_form.id">
                <div class="management-btn"><button class="management-btn-btn" type="submit" name="btn" value="登録" style="width:150px;">登　録</button>
                </div>

            </div>
        </form>
    </div>
</template>