<template>
    <div>
        <table class="table table-bordered table-striped">
            <tr>
                <th>ID</th>
                <th>Step Title</th>
                <th>User Name</th>
                <th>Spent Time</th>
            </tr>
            <tr v-for="(item, index) in allItems">
                <td>{{item.id}}</td>
                <td>{{item.step.title}}</td>
                <td>{{item.user.name}}</td>
                <td>{{getFormattedTime(item.spent_time)}}</td>
            </tr>
        </table>
    </div>
</template>

<script>
    import {mapState, mapActions} from 'vuex';
    import GridView from '../widgets/grid/GridView';
    import DateTimeHelper from '../../helpers/DateTimeHelper';
    
    export default {
        name: 'Index',
        components: {GridView},
        computed: mapState({
            allItems: state => state.stepTimes.allItems,
        }),
        created() {
            this.getItems();
        },
        methods: {
            ...mapActions({
                getItems: 'stepTimes/getItems',
                deleteItem: 'stepTimes/deleteItem',
            }),

            getFormattedTime(spentTime) {
                return DateTimeHelper.getFormattedTime(spentTime);
            },
        },
    };
</script>

<style scoped>

</style>