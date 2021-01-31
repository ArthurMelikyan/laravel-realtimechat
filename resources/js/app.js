/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('chat-component', require('./components/ChatComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */




const app = new Vue({
    el: '#app',

    data: {
        // messages: [],
        // tuser: '',
        // typing: false
    },

    created() {
        // let _this = this;
        // this.fetchMessages();
        // Echo.private('messages').listen('MessageCreated', (e) => {

        //     // alert('a')
        //     this.messages.push(e.message);
        //     // console.log(e);
        // })


    },

    methods: {

        // fetchMessages() {
        //     axios.get('/fetchmessages').then(response => {
        //         this.messages = response.data;
        //     });
        // },

        // addMessage(message) {
        //     axios.post('/sendmessage', message).then(response => {
        //         // this.messages.push(response.data.message);
        //         // alert('a')
        //         // console.log(response.data.message);
        //     });
        // }
    }
});
