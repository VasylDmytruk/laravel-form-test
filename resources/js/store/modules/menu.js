import defaultMenuItems from '../../menu/defaultMenuItems';

export default  {
    namespaced: true,
    state: {
        menuItems: defaultMenuItems,
    },
    mutations: {
        addMenuItem(state, {url, label}) {
            const newItem = {
                url: url,
                label: label,
            };

            state.addItem(newItem);
        },
        addItem(state, newItem) {
            state.menuItems.push(newItem);
        },
        removeItem(state, menuItem) {
            state.menuItems.forEach(function (item, index, array) {
                if (item.url === menuItem.url && item.label === menuItem.label) {
                    array.splice(index, 1);
                }
            });
        },
    },
    actions: {},
    getters: {},
}
