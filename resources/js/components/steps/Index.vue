<template>
    <div>
        <grid-view :columns="columns" :rows="allSteps" :delete-item-func="deleteStep" :action="action"></grid-view>
    </div>
</template>

<script>
    import {mapState, mapActions} from 'vuex';
    import GridView from '../widgets/grid/GridView';
    
    export default {
        name: 'Index',
        components: {GridView},
        computed: mapState({
            allSteps: state => state.steps.allSteps,
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
            this.getSteps();
        },
        methods: {
            ...mapActions({
                getSteps: 'steps/getSteps',
                deleteStep: 'steps/deleteStep',
            }),
        },
    };
</script>

<style scoped>

</style>