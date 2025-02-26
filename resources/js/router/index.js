import { createRouter, createWebHistory } from "vue-router";
let path = '/kanri/public/kanri/junban-uketsuke'
let base_path = '/kanri/public/kanri'
if(window.location.host == 'localhost:8000'){
  path = '/kanri/junban-uketsuke'
  base_path = '/kanri'
}
const routes = [
  {
    path: path,
    name: "junban-uketsuke",
    component: () => import('../views/JunbanUketsuke.vue'),
  },
  {
    path: path+'-add',
    name: "junban-uketsuke-add",
    component: () => import('../views/JunbanUketsukeadd.vue'),
  },
  {
    path: path+'-status',
    name: "junban-status",
    component: () => import('../views/JunbanStatus.vue'),
  },
  {
    path: base_path + '/site-setting/yoyaku',
    name: "yoyaku-setting",
    component: () => import('../views/setting/Yoyaku.vue'),
  },
  {
    path: base_path + '/line-friends',
    name: "yoyaku-setting",
    component: () => import('../views/line/Friends.vue'),
  },

];

const router = createRouter({
  mode: 'history',
  history: createWebHistory(),
  routes,
});

export default router;