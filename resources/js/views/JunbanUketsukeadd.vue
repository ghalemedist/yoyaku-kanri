<script setup>
import { useJunbanStore } from '../stores/junban';  

const myStore = useJunbanStore()
myStore.fetchJunbanUserList()
</script>
<template>


    <div class="page">

    <div class="management-title">【院内受付入力】</div>
    <div class="management-title text-left">診察を受けるペットの名前</div>
    <form method="post" @submit.prevent="myStore.addJunban">
    <ul class="management-number text-left">
        <li>{{ myStore.junban_form.junban_num }}番</li>
        <li>
        <input type="text" name="name" placeholder="名前" class="textbox" required v-model="myStore.junban_form.name">
        </li>
    </ul>
    <div class="management-title text-left">診察券No.下4桁</div>
    <div class="text">
        <input type="text" placeholder="診察券No.下4桁" 
        maxlength="4"  
        required
        pattern="\d{4}"
        title="4桁で入力ください"
        class="textbox textfield" v-model="myStore.junban_form.karute">
    </div>
    <div class="management-title text-left">事前予約はお済みですか？</div>
    <div class="text">
        <select class="textfield" v-model="myStore.junban_form.has_yoyaku">
            <option value="1">はい</option>
            <option value="0">いいえ</option>
        </select>
    </div>
    <!-- <div class="management-title text-left">カルテNo</div>
    <div class="text">
        <input type="text" placeholder="カルテNo" class="textbox textfield" required v-model="myStore.junban_form.karute">
    </div>
    <div class="management-title text-left">担当医の希望を選択ください</div>
    <div class="text">
        <select class="textfield" v-model="myStore.junban_form.tantou">
            <option value="院長">院長</option>
            <option value="代表">代表</option>
            <option value="どちらでも良い">どちらでも良い</option>
        </select>
    </div>
    <small class="text-info">担当医により呼出順番が変わります。</small>
    <div class="management-title text-left">本日の来院目的</div>
    <div class="text">
        <select class="textfield" v-model="myStore.junban_form.mokuteki">
            <option value="体調不良">体調不良</option>
            <option value="予防接種">予防接種</option>
            <option value="健康診断">健康診断</option>
            <option value="その他">その他</option>
        </select>
    </div>

    <div class="management-title text-left">上記の内容を簡単にお知らせください</div>
    <div class="text">
        <textarea name="" id="" cols="30" rows="10" class="textfield" v-model="myStore.junban_form.oshirase"></textarea>
    </div> -->

    <div class="management-btn"><button class="management-btn-btn" type="submit" name="btn" value="登録" style="width:150px;">登　録</button></div>
    </form>
    <br/>

    <div class="line-error" v-if="myStore.line_error.show">
        <h3>エーラが発射されました。</h3>
        <p>
            {{ myStore.line_error.message }}
        </p>
    </div>
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
</template>