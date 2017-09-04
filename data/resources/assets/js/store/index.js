import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
  state: {
    tweet: "",
    successMessageStatus: false,
    successMessage: [],
    mentionBoxStatus: false
  },
  mutations: {
    setTweet (state, tweet) {
      state.tweet = tweet;
    },
    setSuccessMessage (state, msg) {
      state.successMessage = msg;
    },
    setSuccessMessageStatus (state) {
      state.successMessageStatus = !state.successMessageStatus;
    },
    showMentionBox (state) {
      state.mentionBoxStatus = true;
    },
    hideMentionBox (state) {
      state.mentionBoxStatus = false;
    }
  },
  actions: {
    setTweet ({commit}, tweet) {
      commit('setTweet', tweet);
    },
    setSuccessMessage ({commit}, msg) {
      commit('setSuccessMessage', msg);
      commit('setSuccessMessageStatus');
    },
    showMentionBox ({commit}) {
      commit('showMentionBox')
    },
    hideMentionBox ({commit}) {
      commit('hideMentionBox')
    }
  },
  getters: {
    getTweet: state => state.tweet,
    getSuccessMessage: state => state.successMessage,
    getSuccessMessageStatus: state => state.successMessageStatus,
    getMentionBoxStatus: state => state.mentionBoxStatus,
  }
});
