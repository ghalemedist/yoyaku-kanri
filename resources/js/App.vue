<script setup>
import { RouterView } from 'vue-router'
import { useJunbanStore } from './stores/junban'; 
import "jodit/build/jodit.min.css";
import "@vuepic/vue-datepicker/dist/main.css";
const myStore = useJunbanStore()
    
</script>

<template>
  <div id="cover-spin" v-if="myStore.showLoader"></div>
  <RouterView />
</template>
<style>
#cover-spin {
    position:fixed;
    width:100%;
    left:0;right:0;top:0;bottom:0;
    background-color: rgba(255,255,255,0.7);
    z-index:9999;
}

@-webkit-keyframes spin {
	from {-webkit-transform:rotate(0deg);}
	to {-webkit-transform:rotate(360deg);}
}

@keyframes spin {
	from {transform:rotate(0deg);}
	to {transform:rotate(360deg);}
}

#cover-spin::after {
    content:'';
    display:block;
    position:absolute;
    left:48%;top:40%;
    width:40px;height:40px;
    border-style:solid;
    border-color:black;
    border-top-color:transparent;
    border-width: 4px;
    border-radius:50%;
    -webkit-animation: spin .8s linear infinite;
    animation: spin .8s linear infinite;
}
</style>