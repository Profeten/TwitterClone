
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import Vuex from 'vuex';

import store from './store'

Vue.use(VueRouter);
Vue.use(Vuex);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('newtweet', require('./components/NewTweet.vue'));
Vue.component('tweets', require('./components/Tweets.vue'));
Vue.component('channel', require('./components/Channel.vue'));
Vue.component('mention', require('./components/Mention.vue'));
Vue.component('message', require('./components/Message.vue'));

const FrontPage = { template: '<div><message></message><newtweet></newtweet><tweets></tweets></div>' }
const Channel = { template: '<div><message></message><newtweet></newtweet><channel></channel></div>' }
const Mention = { template: '<div><message></message><newtweet></newtweet><mention></mention></div>' }

const routes = [
  { path: '/', component: FrontPage },
  { path: '/channel/:channel', component: Channel },
  { path: '/user/:user', component: Mention }
]

const router = new VueRouter({
  routes,
})


const app = new Vue({
    el: '#app',
    router,
    store
});
