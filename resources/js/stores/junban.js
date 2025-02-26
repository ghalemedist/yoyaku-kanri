import { defineStore } from "pinia";
import axios from "axios";
import { API_JUNBANUSER_LIST, API_JUNBANUSER_STORE, API_JUNBANUSER_STATUS_UPDATE, API_JUNBAN_STATUS_LIST, API_JUNBAN_STATUS_ADD, API_JUNBAN_STATUS_DELETE } from '../api';

export const useJunbanStore = defineStore({
    id: "junban",
    state: () => ({
      message: {
        status: '',
        message: '',
        show: false
      },
      line_error: {
        show: false,
        message: ''
      },
        showLoader: false,
        junban_form: {
            error: '',
            success: '',
            line_userId: '',
            name: '',
            karute: '',
            mokuteki: '体調不良',
            tantou: '院長',
            oshirase: '',
            date: '',
            junban_num: '',
            has_yoyaku: '0'
          },
          junban_user_list: {
            'status':'',
            'message': '',
            'data': [],
            'next_num': '1',
            'date': '',
            'time': ''
          },
          junban_user_id: "",
          junban_status_list: [],
          junban_status_form: {
            error: '',
            success: '',
            id: 0,
            title: '',
            send_message: false,
            message: '',
            category: '1',
            ordering: '',
            showModal: false
          },
    }),
    getters: {
        waitingUsers: (state) => {
          return state.junban_user_list.data.filter((list) => list.status_category == '1')
        },
        currentExamineUser: (state) => {
          return state.junban_user_list.data.filter((list) => list.status_category == '2')
        },
        finishUsers: (state) => {
          return state.junban_user_list.data.filter((list) => list.status_category == '3')
      },
        waitingInsideHospital: (state) => {
          return state.junban_user_list.data.filter((list) => list.junbanstatus_id == '2')
        },
        countWaitingUsers: (getters) => {
          return getters.waitingUsers.length
        },
      },
    actions: {
        async fetchJunbanUserList() {
            // this.showLoader = true;
            try {
              let junban_users = this.junban_user_list = await fetch(API_JUNBANUSER_LIST)
                .then(response => response.json())
              this.junban_form.junban_num = junban_users.next_junban_num
              this.junban_form.date = junban_users.date
              
            } catch (error) {
              console.log(error)
            }
            this.showLoader = false;
          },
        async addJunban() {
            this.showLoader = true;
            let payLoad = new FormData()
            payLoad.append('name', this.junban_form.name)
            payLoad.append('karute', this.junban_form.karute)
            payLoad.append('has_yoyaku', this.junban_form.has_yoyaku)
            payLoad.append('tantou', this.junban_form.tantou)
            payLoad.append('mokuteki', this.junban_form.mokuteki)
            payLoad.append('oshirase', this.junban_form.oshirase)
            payLoad.append('junban_num', this.junban_form.junban_num)
            payLoad.append('date', this.junban_form.date)
  
            await axios.post(API_JUNBANUSER_STORE, payLoad)
            .then((response) => {
              let { data } = response
              if (data.status == 'success'){
                  this.junban_form.name = ''
                  this.junban_form.karute = ''
                  this.junban_form.oshirase = ''
                  this.junban_form.success = data.message
                  this.junban_form.error = ''
                  this.message = {
                    status: 'success',
                    message: data.message,
                    show: true
                  }
                  this.resetMessage()
                  
                  this.fetchJunbanUserList()
              }else{
                  this.fetchJunbanUserList()
                  this.junban_form.success = ''
                  this.junban_form.error = data.message
                  this.message = {
                    status: 'error',
                    message: data.message,
                    show: true
                  }
                  this.resetMessage()
              }
            })
            .catch(error => console.log(error))
            .finally(() => this.showLoader = false)
        },
        async changeStatus(junbanstatus_id, id) {
            this.showLoader = true;
            let payLoad = new FormData()
            payLoad.append('id', id)
            payLoad.append('junbanstatus_id', junbanstatus_id)
            await axios.post(API_JUNBANUSER_STATUS_UPDATE, payLoad)
            .then((response) => {
              let { data } = response
              if (data.status == 'success'){
                  this.fetchJunbanUserList()
                  this.message = {
                    status: 'success',
                    message: data.message,
                    show: true
                  }
                  this.line_error = {
                    show: false
                  }
                  this.resetMessage()
              }else{
                this.message = {
                  status: 'error',
                  message: data.message,
                  show: true
                }
                this.line_error = {
                  show: true,
                  message: data.line_error_message
                }
                this.resetMessage()
              }
            })
            .catch(error => console.log(error))
            .finally(() => this.showLoader = false)
        },
        resetMessage() {
          setTimeout(() => {
            this.message = {
              status: '',
              message: '',
              show: false
            }
          }, 3000)
        },
        async fetchJunbanStatusList() {
          this.showLoader = true;
          try {
            this.junban_status_list = await fetch(API_JUNBAN_STATUS_LIST)
              .then(response => response.json())
          } catch (error) {
            console.log(error)
          }
          this.showLoader = false;
        },
        async addStatus() {
          this.showLoader = true;
          let payLoad = new FormData()
          payLoad.append('id',this.junban_status_form.id)
          payLoad.append('title',this.junban_status_form.title)
          payLoad.append('send_message', (this.junban_status_form.send_message == true)?1:0)
          payLoad.append('message',this.junban_status_form.message)
          payLoad.append('category',this.junban_status_form.category)
          payLoad.append('ordering',this.junban_status_form.ordering)
          await axios.post(API_JUNBAN_STATUS_ADD, payLoad)
          .then((response) => {
            let { data } = response
            if (data.status == 'success'){
                this.message = {
                  status: 'success',
                  message: data.message,
                  show: true
                }
                this.line_error = {
                  show: false
                }
                this.resetMessage()
            }else{
              this.message = {
                status: 'error',
                message: data.message,
                show: true
              }
              this.line_error = {
                show: true,
                message: data.line_error_message
              }
              this.resetMessage()
            }
          })
          .catch(error => console.log(error))
          .finally(() => {
            this.showLoader = false
            this.junban_status_form.showModal = false
            this.fetchJunbanStatusList()
          })
          
      },
      async deleteStatus() {
        this.showLoader = true;
        let payLoad = new FormData()
        payLoad.append('id',this.junban_status_form.id)
        await axios.post(API_JUNBAN_STATUS_DELETE, payLoad)
        .then((response) => {
          let { data } = response
          if (data.status == 'success'){
              this.message = {
                status: 'success',
                message: data.message,
                show: true
              }
              this.line_error = {
                show: false
              }
              this.resetMessage()
          }else{
            this.message = {
              status: 'error',
              message: data.message,
              show: true
            }
            this.line_error = {
              show: true,
              message: data.line_error_message
            }
            this.resetMessage()
          }
          this.fetchJunbanStatusList()
        })
        .catch(error => console.log(error))
        .finally(() => this.showLoader = false)
    },
        
        
    }
})