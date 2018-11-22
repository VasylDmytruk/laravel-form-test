<template>
    <div>
        <table class="table table-bordered table-striped">
            <tr>
                <th>ID</th>
                <th>User Name</th>
                <th>Spent Time</th>
            </tr>
            <tr v-for="(item, index) in allItems">
                <td>{{item.id}}</td>
                <td>{{item.user.name}}</td>
                <td>{{getFormattedTime(item.total_spent_time)}}</td>
            </tr>
        </table>
    </div>
</template>

<script>
    import {mapState, mapActions} from 'vuex';
    import DateTimeHelper from '../../helpers/DateTimeHelper';
    
    export default {
        name: 'Index',
        computed: mapState({
            allItems: state => state.stepProcedures.allItems,
        }),
        created() {
            this.getItems();
        },
        methods: {
            ...mapActions({
                getItems: 'stepProcedures/getItems',
                deleteItem: 'stepProcedures/deleteItem',
            }),

            getFormattedTime(spentTime) {
                return DateTimeHelper.getFormattedTime(spentTime);
            },
        },
    };
</script>

<style scoped>

</style>