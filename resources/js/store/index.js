import Vue from 'vue';
import Vuex from 'vuex';


Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
  state: {
    campaigns: [],
  },

  actions: {
    async getAll({ commit }) {
      return commit('setCampaigns', await api.get('api/campaigns'))
    },
  },

  mutations: {
    setCampaigns(state, response) {
      state.campaigns = response.data.data;
    },
  },
  strict: debug
});