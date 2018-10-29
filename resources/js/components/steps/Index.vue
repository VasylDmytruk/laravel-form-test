<template>
    <div>
        <grid-view :columns="columns" :rows="allItems" :delete-item-func="deleteItem" :action="action"></grid-view>
    </div>
</template>

<script>
    import {mapState, mapActions} from 'vuex';
    import GridView from '../widgets/grid/GridView';
    
    export default {
        name: 'Index',
        components: {GridView},
        computed: mapState({
            allItems: state => state.steps.allItems,
        }),
        data() {
            return {
                columns: [
                    {field: 'id', label: 'ID'},
                    {field: 'title', label: 'Title'},
                    {field: 'healing_methods', label: 'Healing Methods'},
                    {type: 'action'},
                ],
                action: 'steps',
            };
        },
        created() {
            this.getItems();
        },
        methods: {
            ...mapActions({
                getItems: 'steps/getItems',
                deleteItem: 'steps/deleteItem',
            }),
        },
    };
</script>

<style scoped>

</style>