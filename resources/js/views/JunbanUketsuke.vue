<script setup>
import { ref } from 'vue';
import { storeToRefs } from 'pinia';
import { useJunbanStore } from '../stores/junban';  
import JunbanStatus from '../components/JunbanStatus.vue';

const myStore = useJunbanStore()
myStore.fetchJunbanUserList()
const { countWaitingUsers, currentExamineUser, activeUsers, waitingUsers, waitingInsideHospital, finishUsers } = storeToRefs(myStore)
const userType = ref(1)
const switchType = (val) => {
    userType.value = val
}
const changeStatus = (event, user_id) => {
    myStore.changeStatus(event.target.value, user_id)
}
const update = () => {
    myStore.showLoader = true
    myStore.fetchJunbanUserList()
}
const modalUser = ref({
    name: ''
})
const loadModal = (user) => {
    modalUser.value = user
}
const hideModal = () => {
    modalUser.value = {
        name: ''
    }
}
setInterval(function(){
    myStore.fetchJunbanUserList(false)
}, 10000)
const getClassByTantou = (user) => {
    if(user.tantou == '院長')
        return 'trbgcolor-1'
    else if(user.tantou == '代表')
        return 'trbgcolor-2'
    else 
        return 'trbgcolor-3'
}
</script>
<template>


    <div class="page">
        <h2>順番待ち受付
    </h2>
    <div class="date">
    <h3>
        {{ myStore.junban_user_list.date }} ({{ myStore.junban_user_list.day }}) {{ myStore.junban_user_list.time }} 現在
    </h3>
    </div>
    <table class="table0">
    <tbody>
        <tr>
        <td valign="top">
            <div class="waku">
                <h2>診察中</h2>
                <div class="item-box-current">
                    <h3 v-for="currentUser in currentExamineUser"
                        :class="getClassByTantou(currentUser)">{{ currentUser.junban_num }}番</h3>
                </div>
            </div>
        </td>
        <td valign="top">
            <div class="waku">
            <h2>待機人数</h2>
            <h3>{{ countWaitingUsers }}人</h3>
            </div>
        </td>
        </tr>
    </tbody>
    </table>
    <br/>
    <div class="management-title">【受付状況】<button class="management-btn-btn update-btn" @click="update()">更新</button></div>
    <div class="line-error" v-if="myStore.line_error.show">
        <h3>エーラが発射されました。</h3>
        <p>
            {{ myStore.line_error.message }}
        </p>
    </div>
    <div class="junban-status-link">
        <a href="" :class="userType == 1?'active':''" @click.prevent="switchType(1)">待機人</a>
        <a href="" :class="userType == 2?'active':''" @click.prevent="switchType(2)">診察中</a>
        <a href="" :class="userType == 3?'active':''" @click.prevent="switchType(3)">診察終了</a>
    </div>
        <table class="table2">
        <tbody>
            <tr>
                <th>更新</th>
                <th>受付時間</th>
                <th>順番</th>
                <th>呼出名前</th>
                <th>診察券No.下4桁</th>
                <th>事前予約</th>
            </tr>
            <tr 
                v-if="userType == '1'" 
                v-for="user in waitingUsers" 
                :class="getClassByTantou(user)">
                <JunbanStatus 
                    :user="user" 
                    :junban_status="myStore.junban_user_list.junban_status"
                    @changeStatus="changeStatus"
                    @loadModal="loadModal"
                    ></JunbanStatus>
            </tr>
            <tr 
                v-if="userType == '2'" 
                v-for="user in currentExamineUser" 
                :class="getClassByTantou(user)">
                <JunbanStatus 
                    :user="user" 
                    :junban_status="myStore.junban_user_list.junban_status"
                    @changeStatus="changeStatus"
                    @loadModal="loadModal"
                    ></JunbanStatus>
            </tr>
            <tr 
                v-if="userType == '3'" 
                v-for="user in finishUsers" 
                :class="getClassByTantou(user)">
                <JunbanStatus 
                    :user="user" 
                    :junban_status="myStore.junban_user_list.junban_status"
                    @changeStatus="changeStatus"
                    @loadModal="loadModal"
                    ></JunbanStatus>
            </tr>
        </tbody>
    </table>
    <div class="alert alert-success" role="alert" data-mdb-color="success"
        :class="myStore.message.show && myStore.message.status == 'success'?'fadeOut':''">
        {{ myStore.message.message }}
    </div>

    <div class="alert alert-danger" role="alert" data-mdb-color="danger"
    :class="myStore.message.show && myStore.message.status == 'error'?'fadeOut':''"
    >
        {{ myStore.message.message }}
    </div>

    </div>
    <br/>    
    <div id="myModal" class="modal" v-if="modalUser.name != ''">

        <div class="modal-content">
            <span class="close" @click="hideModal">&times;</span>
            <h2>内容</h2>
            <h3>呼出名前：　{{ modalUser.name }}</h3>
            <h3>担当医の希望：　{{ modalUser.tantou }}</h3>
            <h3>来院目的：　{{ modalUser.mokuteki }}</h3>
            <h3>上記の内容を簡単：</h3>
            <p>{{ modalUser.oshirase }}</p>
            
        </div>

    </div>

</template>