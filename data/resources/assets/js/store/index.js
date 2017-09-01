import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
  state: {
    successMessageStatus: false,
    successMessage: []
  },
  mutations: {
    setSuccessMessage (state, msg) {
      state.successMessage = msg;
    },
    setSuccessMessageStatus (state) {
      state.successMessageStatus = !state.successMessageStatus;
    }
  },
  actions: {
    setSuccessMessage ({commit}, msg) {
      commit('setSuccessMessage', msg);
      commit('setSuccessMessageStatus');
    }
  },
  getters: {
    getSuccessMessage: state => state.successMessage,
    getSuccessMessageStatus: state => state.successMessageStatus
  }
});
