import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
  state: {
    successMessageStatus: false,
    successMessage: [],
    mentionBoxStatus: false
  },
  mutations: {
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
    getSuccessMessage: state => state.successMessage,
    getSuccessMessageStatus: state => state.successMessageStatus,
    getMentionBoxStatus: state => state.mentionBoxStatus,
  }
});
