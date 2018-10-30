import Vue from 'vue';

export default {
    namespaced: true,
    state: {
        crudApi: {},
        allItems: [],
        lastItem: null,
        cachedItems: [],
        lastError: null,

        hasCachedItem(id) {
            return this.cachedItems[id] !== undefined;
        },
        getCachedItem(id) {
            return this.cachedItems[id] ? this.cachedItems[id] : null;
        },
        setCachedItem(item) {
            Vue.set(this.cachedItems, item.id, item);
        },
        getDefaultItem() {
            return {
                name: '',
                data: null,
            };
        },
    },
    mutations: {
        setItems(state, items) {
            state.allItems = items;
        },
        setError(state, error) {
            state.lastError = error;
        },
        seItem(state, item) {
            state.lastItem = item;

            // TODO change this to work only for form item
            if (item.data) {
                try {
                    state.lastItem.data = JSON.parse(item.data);
                } catch (e) {
                }
            }

            state.setCachedItem(state.lastItem);
        },
        resetItem(state) {
            state.lastItem = null;
            state.lastItem = state.getDefaultItem();
        },
        setItemFromCache(state, id) {
            state.lastItem = state.getCachedItem(id);
        },
        deleteItem(state, {response, index}) {
            if (response.success) {
                state.allItems.splice(index, 1);
            }
        },
    },
    actions: {
        getItems({commit, state}) {
            state.crudApi.getItems(
                items => {
                    commit('setItems', items);
                },
                error => {
                    commit('setError', error);
                },
            );
        },
        getItem({commit, state}, id) {
            commit('resetItem');

            if (state.hasCachedItem(id)) {
                commit('setItemFromCache', id);
            } else {
                state.crudApi.getItem(
                    item => {
                        commit('seItem', item);
                    },
                    error => {
                        commit('setError', error);
                    },
                    id,
                );
            }
        },
        deleteItem({commit, state}, {id, index}) {
            if (!confirm('Do you really want to delete this item')) {
                return;
            }

            return new Promise((resolve, reject) => {
                state.crudApi.deleteItem(
                    response => {
                        commit('deleteItem', {response, index});
                        resolve(response);
                    },
                    error => {
                        commit('setError', error);
                        reject(error);
                    },
                    id,
                );
            });
        },
        createItem({commit, state}, data) {
            return new Promise((resolve, reject) => {
                state.crudApi.createItem(
                    response => {
                        resolve(response);
                    },
                    error => {
                        reject(error);
                    },
                    data
                );
            });
        },
        updateItem({commit, state}, {id, data}) {
            return new Promise((resolve, reject) => {
                state.crudApi.updateItem(
                    response => {
                        resolve(response);
                    },
                    error => {
                        reject(error);
                    },
                    {id, data}
                );
            });
        },
    },
    getters: {},
};
