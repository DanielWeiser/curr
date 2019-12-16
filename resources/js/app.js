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

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('response-component', require('./components/ResponseComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const app = new Vue({
    el: '.add_class',
    data: {
        add_seen: [],
        delete_seen: [],
        res: null,
        curr_num: null,
        flag_from: 'flags/us.png',
        flag_to: 'flags/eur.png',
        code_from: 'USD',
        code_to: 'EUR',
        rate_from: 1,
        rate_to: 1.136221,
        inf_flag: false,
        username: '',
        email: '',
        user_inf: [],
        new_username: '',
        new_email: '',
    },
    created() {
        this.pusher();
    },
    methods: {
        pusher: function() {
            window.axios.get('get_id').then(response => {
                var channel = Echo.private(`user.${response.data}`);
                channel.listen('ResponseToRequest', function(data) {
                    console.log(data.response.message);
                });
            }).catch(function(){
                console.log("Unauthorized");
            })
        },
        /**
         * get with curr_id and hide element if success
         */
        add: function(id) {
            window.axios.get(`/newcurr/${id}`).then(() => {
                this.add_seen += id;
            });
        },
        /**
         * get with user_id and curr_id and hide element if success
         */
        del: function(user_id, curr_id, email, code) {
            window.axios.get(`/admin/${user_id}&${curr_id}`).then(() => {
                window.axios.get(`/send/email/${email}&${code}&1&${user_id}`)
                this.delete_seen += curr_id;
            });
        },
        del_mail: function(user_id, curr_id, email, code) {
            window.axios.get(`/mail/${user_id}&${curr_id}`).then(() => {
                window.axios.get(`/send/email/${email}&${code}&0&${user_id}`)
                this.delete_seen += curr_id;
            });
        },
        /**
         * Conversion (num - rate)
         */
        conv_in: function() {
            this.res = (this.curr_num * this.rate_from / this.rate_to).toFixed(2);
            if(this.curr_num == 0) {
                this.res = null;
            }
        },
        /**
         * Set new rate, flag and code 
         */
        change_curr_from: function(code, flag, rate) {
            this.flag_from = 'flags/' + flag;
            this.code_from = code;
            this.rate_from = rate;
            this.conv_in();
        },
        change_curr_to: function(code, flag, rate) {
            this.flag_to = 'flags/' + flag;
            this.code_to = code;
            this.rate_to = rate;
            this.conv_in();
        },
        /**
         * Set user information
         */
        user_information: function(username, user_inf) {
            this.email = user_inf[0].email;
            this.username = username;
            this.user_inf = user_inf;
        },
        /**
         * Update username and email
         */
        edit_name: function(user_id){
            if(this.new_username != '') {
                window.axios.get(`/username/${user_id}&${this.new_username}`);
                this.username = this.new_username;
            }
            else
                console.log('wrong string');
        },
        edit_email: function(user_id){
            if(this.new_email != '') {
                window.axios.get(`/email/${user_id}&${this.new_email}`);
                this.email = this.new_email;
            }
            else
                console.log('wrong string');
        },
        /**
         * on/off currencies
         */
        off_curr: function(user_id, curr_id){
            window.axios.get(`/off_curr/${user_id}&${curr_id}`);
            this.user_inf[curr_id - 1].curr_state = 0;
        },
        on_curr: function(user_id, curr_id){
            window.axios.get(`/on_curr/${user_id}&${curr_id}`);
            this.user_inf[curr_id - 1].curr_state = 1;
        },
    }
});


