<template>
    <div>
        <grid-view :columns="columns" :rows="allItems" :action="action" :delete-item-func="deleteItem"></grid-view>
    </div>
</template>

<script>
    import {mapState, mapActions} from 'vuex';
    import GridView from '../widgets/grid/GridView';

    export default {
        name: "FormsIndex",
        components: {GridView},
        data() {
            return {
                columns: [
                    {label: 'ID', field: 'id'},
                    {label: 'Title', field: 'title'},
                    {label: 'Data', field: 'data', type: 'expandable'},
                    {type: 'action'},
                ],
                action: 'forms',
            }
        },
        computed: mapState({
            allItems: state => state.forms.allItems,
        }),
        created() {
            this.getItems();
        },
        methods: {
            ...mapActions({
                getItems: 'forms/getItems',
                deleteItem: 'forms/deleteItem',
            }),
        },
    }
</script>

<style scoped>

</style>