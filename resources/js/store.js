import { createStore } from 'vuex';
import createPersistedState from 'vuex-persistedstate';

export default createStore({
    state: {
        session: false,
        // status_code: null,
        userInfo: {}
    },
    actions: {},
    mutations: {
        login(state, payload){
            state.session = true
            // state.status_code = null
            state.userInfo = payload
        },
        logout(state){
            state.session = false
            // state.status_code = null
            state.userInfo = {}
        },
        setStatusCode(state, payload){
            state.status_code = payload
        }
    },
    getters: {},
    plugins: [createPersistedState({key: 'vuex'})]
});
