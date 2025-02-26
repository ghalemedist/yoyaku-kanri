<script setup>
import { ref, onMounted } from "vue";
import { useJunbanStore } from '@/stores/junban';  
import { API_SITE_SETTING, API_SITE_SETTING_UPDATE } from "@/api";

import TimeslotComponent from "../../components/setting/TimeslotComponent.vue";

import DatePicker from "@vuepic/vue-datepicker";
import { JoditEditor } from "jodit-vue";

const myStore = useJunbanStore()

const yoyaku_form = ref({
  id: 0,
  yoyaku_title: '',
  yoyaku_date: '',
  yoyaku_content: '',
  yoyaku_title_premium: '',
  yoyaku_content_premium: '',
  yoyaku_content_email: '',
  yoyaku_content_line: '',
  formError: {},
});
const buttons = [
    'paragraph',
    'bold',
    'italic',
    'underline',
    'fontsize',
    'ol',
    'ul',
    'indent',
    'align',
    'link',
    '|',
    'undo',
    'redo',
    'source'
]
const showTimeslot = ref(false)
const isPremium = ref(0)


// window.scrollTo(0,0)
onMounted(async () => {
  await fetchData();
});

const fetchData = async () => {
    myStore.showLoader = true
    await axios
    .get(API_SITE_SETTING)
    .then((response) => {
      if (response.data.status == "success") {
        yoyaku_form.value.yoyaku_title = response.data.data.yoyaku_title;
        yoyaku_form.value.yoyaku_date = response.data.data.yoyaku_date;
        yoyaku_form.value.yoyaku_content = response.data.data.yoyaku_content;
        yoyaku_form.value.yoyaku_content_email = response.data.data.yoyaku_content_email;
        yoyaku_form.value.yoyaku_content_line = response.data.data.yoyaku_content_line;
        yoyaku_form.value.yoyaku_title_premium = response.data.data.yoyaku_title_premium?response.data.data.yoyaku_title_premium:'';
        yoyaku_form.value.yoyaku_content_premium = response.data.data.yoyaku_content_premium?response.data.data.yoyaku_content_premium:'';
      } 
    })
    .catch((error) => console.log(error))
    .finally(() => (myStore.showLoader = false));
}


const handleSubmit = async () => {
   
  myStore.showLoader = true;
  let payLoad = new FormData();
  payLoad.append("yoyaku_title", yoyaku_form.value.yoyaku_title);
  payLoad.append("yoyaku_date", yoyaku_form.value.yoyaku_date?yoyaku_form.value.yoyaku_date:'');
  payLoad.append("yoyaku_content", yoyaku_form.value.yoyaku_content);
  payLoad.append("yoyaku_content_email", yoyaku_form.value.yoyaku_content_email);
  payLoad.append("yoyaku_content_line", yoyaku_form.value.yoyaku_content_line);
  payLoad.append("yoyaku_title_premium", yoyaku_form.value.yoyaku_title_premium?yoyaku_form.value.yoyaku_title_premium:'');
  payLoad.append("yoyaku_content_premium", yoyaku_form.value.yoyaku_content_premium?yoyaku_form.value.yoyaku_content_premium:'');
  
  await axios
    .post(API_SITE_SETTING_UPDATE, payLoad)
    .then((response) => {
      if (response.data.status == "success") {
        alert(response.data.message)
      } 
    })
    .catch((error) => console.log(error))
    .finally(() => (myStore.showLoader = false));
};

</script>
<template>


    <div class="page">
        
        <timeslot-component
        v-if="showTimeslot"
        :yoyaku_date="yoyaku_form.yoyaku_date"
        :isPremium="isPremium"
        @toggleTimeslot="showTimeslot = !showTimeslot"></timeslot-component>
     
        <form method="post" @submit.prevent="handleSubmit()">

            <div class="management-title text-left">イベント日</div>
    <div class="text">
        <date-picker
            format="yyyy-MM-dd"
            locale="ja"
            model-type="yyyy-MM-dd"
            :enable-time-picker="false"
            :month-change-on-scroll="false"
            auto-apply
            placeholder="YYYY-MM-DD"
            v-model="yoyaku_form.yoyaku_date"
            week-start="0"
          >
          </date-picker>
          <a href="" @click.prevent="() => {
            isPremium = 0
            showTimeslot = true
          }">時間帯設定</a>
    </div>
    
    <div class="management-title text-left mt-4">タイトル</div>
    <div class="text">
        <input type="text" placeholder="" 
        required
        class="textbox textfield" v-model="yoyaku_form.yoyaku_title">
    </div>
    <div class="management-title text-left mt-4">表示文章 「予約画面内」</div>
    <div class="text">
        <jodit-editor 
              v-model="yoyaku_form.yoyaku_content"
              :buttons="buttons" 
              :height="450" 
              placeholder=""/>
    </div>
    <div class="management-title text-left mt-4">メール通知文章 </div>
    <div class="text">
        <jodit-editor 
              v-model="yoyaku_form.yoyaku_content_email"
              :buttons="buttons" 
              :height="450" 
              placeholder=""/>
    </div>
    <p>上記の文章は、ユーザーのメールアドレスに送信します</p>

    <div class="management-title text-left mt-4">LINE通知文章 </div>
    <div class="text">
        <jodit-editor 
              v-model="yoyaku_form.yoyaku_content_line"
              :buttons="buttons" 
              :height="450" 
              placeholder=""/>
    </div>
    <p>上記の文章は、ユーザーのLINEアカウントに送信します。
      <br/>
      文章タイプは「指定なし」のみご記入ください。<br/>
テキストが長すぎる場合は隠れてしまう可能性があるので
「ENTER」キーを押して新しい行を入力してください。
    </p>

      <div class="management-title text-left mt-4">プレミアムプランタイトル</div>
      <div class="text">
          <input type="text" placeholder="" 
          class="textbox textfield" v-model="yoyaku_form.yoyaku_title_premium">
          <a href="" @click.prevent="() => {
      isPremium = 1
      showTimeslot = true
    }">プレミアムプラン時間帯設定</a>
      </div>
      <div class="management-title text-left mt-4">表示文章 「予約画面内」</div>
      <div class="text">
          <jodit-editor 
                v-model="yoyaku_form.yoyaku_content_premium"
                :buttons="buttons" 
                :height="450" 
                placeholder=""/>
      </div>
    
    

    <div class="management-btn">
        <button class="management-btn-btn" type="submit" name="btn" value="登録" style="width:150px; margin: 30px 0;">保存する</button>
    </div>
    </form>
    <br/>


    
    </div>

    

</template>