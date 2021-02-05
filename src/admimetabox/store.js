import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        address: '',
        refresh: false,
        infogeneral: [],
    },
    mutations: {
        GET_ADDRESS(state, value) {
            state.address = value
        },
        GET_INFOADRESS(state, value) {
            state.infogeneral = value;
        },
        GET_REFRESH(state, value){
            state.refresh = value
        }
    },

})

export default store
