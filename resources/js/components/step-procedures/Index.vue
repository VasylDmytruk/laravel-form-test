<template>
    <div>
        <table class="table table-bordered table-striped">
            <tr>
                <th>ID</th>
                <th>User Name</th>
                <th>Spent Time</th>
                <th></th>
            </tr>
            <tr v-for="(item, index) in allItems">
                <td>{{item.id}}</td>
                <td>{{item.user.name}}</td>
                <td>{{getFormattedTime(item.total_spent_time)}}</td>
                <td>
                    <router-link :to="'/step-procedure/view/' + item.id">View</router-link>
                    <br>
                    <a href="#" @click.prevent="deleteStepProcedure(item.id, index)">Delete</a>
                </td>
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

            deleteStepProcedure(id, index) {
                this.deleteItem({id, index})
                    .then(response => {
                        console.log('delete', response);
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
        },
    };
</script>

<style scoped>

</style>