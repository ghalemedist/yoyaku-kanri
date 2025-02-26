//local
let base_url = 'https://appointment.happyplace.pet/kanri/public';

if(window.location.host == 'localhost:8000'){
    base_url = 'http://localhost:8000'
  }
export const API_JUNBANUSER_LIST = `${base_url}/waiting/junban-uketsuke`;
export const API_JUNBANUSER_STORE = `${base_url}/waiting/junban-store`;
export const API_JUNBANUSER_STATUS_UPDATE = `${base_url}/waiting/junban-status-update`;
export const API_JUNBAN_STATUS_LIST = `${base_url}/waiting/junban-status-list`;
export const API_JUNBAN_STATUS_ADD = `${base_url}/waiting/junban-status-add`;
export const API_JUNBAN_STATUS_DELETE = `${base_url}/waiting/junban-status-delete`;
export const API_SITE_SETTING = `${base_url}/api/site-setting`;
export const API_SITE_SETTING_UPDATE = `${base_url}/api/site-setting/update`;
export const API_YOUYAKUBI_BYDATE = `${base_url}/api/yoyakubi_bydate`;
export const API_YOUYAKUBI_TSUPDATE = `${base_url}/api/yoyakubi_tsupdate`;
export const API_YOUYAKUBI_TSDELETE = `${base_url}/api/yoyakubi_tsdelete`;
export const API_YOUYAKUBI_TSCREATE = `${base_url}/api/yoyakubi_tscreate`;

export const API_LINE_FRIENDS = `${base_url}/api/line_friends`;

