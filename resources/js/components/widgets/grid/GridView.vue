<template>
    <div>
        <div>Items: {{rows.length}}</div>
        <div class="table-wrap">
            <!--<table class="table table-bordered grid-table-fixed">-->
                <!--<draggable v-model="rowsForSorting">-->
                    <!--<tr slot="header">-->
                        <!--<template v-for="column in columns">-->
                            <!--<th v-if="column.type === 'action'"></th>-->
                            <!--<th v-else>{{column.label}}</th>-->
                        <!--</template>-->
                    <!--</tr>-->
                    <!--<tr v-for="(row, index) in rows" :key="row.id">-->
                        <!--<template v-for="column in columns">-->
                            <!--<td v-if="column.type === 'action' && action">-->
                                <!--&lt;!&ndash; TODO refactor to allow customisation &ndash;&gt;-->
                                <!--<router-link :to="'/' + action + '/edit/' + row.id">Edit</router-link>-->
                                <!--<br>-->
                                <!--<router-link :to="'/' + action + '/view/' + row.id">View</router-link>-->
                                <!--<br>-->
                                <!--&lt;!&ndash; TODO need change notification way &ndash;&gt;-->
                                <!--<a href="#" v-if="deleteItemFunc" v-on:click.prevent="-->
                                    <!--deleteItemFunc({id: row.id, index}).then(response => {-->
                                        <!--$notify({type: 'success', title: 'Deleted', text: 'Item deleted successfully!'});-->
                                    <!--})-->
                                    <!--.catch(error => {-->
                                        <!--$notify({type: 'error', title: 'Not deleted', text: 'Can not delete item!'});-->
                                    <!--});-->
                                <!--">Delete</a>-->
                            <!--</td>-->
                            <!--<td v-else-if="column.type === 'expandable'" class="word-limit">-->
                                <!--<div class="limit-div" v-if="canExpandData(index)">{{row[column.field]}}</div>-->
                                <!--<div v-else><a href="#" @click.prevent="setExpandDataItem(index)">Show</a></div>-->
                            <!--</td>-->
                            <!--<td v-else>{{row[column.field]}}</td>-->
                        <!--</template>-->
                    <!--</tr>-->
                <!--</draggable>-->
            <!--</table>-->

            <div class="div-table">
                <div class="div-table-row">
                    <template v-for="column in columns">
                        <div v-if="column.type === 'action'" class="div-table-cell"></div>
                        <div v-else class="div-table-cell">{{column.label}}</div>
                    </template>
                </div>
                <draggable :list="rowsForSorting" @end="endDragging">
                    <div class="div-table-row" v-for="(row, index) in rowsForSorting" :key="row.id">
                        <template v-for="column in columns">
                            <div v-if="column.type === 'action' && action" class="div-table-cell">
                                <!-- TODO refactor to allow customisation -->
                                <router-link :to="'/' + action + '/edit/' + row.id">Edit</router-link>
                                <br>
                                <router-link :to="'/' + action + '/view/' + row.id">View</router-link>
                                <br>
                                <!-- TODO need change notification way -->
                                <a href="#" v-if="deleteItemFunc" v-on:click.prevent="
                                            deleteItemFunc({id: row.id, index}).then(response => {
                                                $notify({type: 'success', title: 'Deleted', text: 'Item deleted successfully!'});
                                            })
                                            .catch(error => {
                                                $notify({type: 'error', title: 'Not deleted', text: 'Can not delete item!'});
                                            });
                                        ">Delete</a>
                            </div>
                            <div v-else-if="column.type === 'expandable'" class="word-limit div-table-cell">
                                <div class="limit-div" v-if="canExpandData(index)">{{row[column.field]}}</div>
                                <div v-else><a href="#" @click.prevent="setExpandDataItem(index)">Show</a></div>
                            </div>
                            <div v-else class="div-table-cell">{{row[column.field]}}</div>
                        </template>
                    </div>
                </draggable>
            </div>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import Draggable from 'vuedraggable'

    export default {
        name: 'GridView',
        components: {Draggable},
        props: {
            columns: {
                type: Array,
                required: true,
            },
            rows: {
                type: Array,
                required: true,
            },
            action: {
                type: String,
            },
            deleteItemFunc: {
                type: Function,
            },
        },
        computed: {
            rowsForSorting() {
                return this.rows;
            },
        },
        data() {
            return {
                expandData: {},
            };
        },
        methods: {
            canExpandData(index) {
                return this.expandData[index] !== undefined;
            },
            setExpandDataItem(index) {
                Vue.set(this.expandData, index, true);
            },
            endDragging(e) {
                this.$emit('rows-update', this.rowsForSorting);
            },
        },
    };
</script>

<style scoped>
    .grid-table-fixed {
        table-layout: fixed;
        width: 100%
    }

    .word-limit {
        word-wrap: break-word;
        width: 100%;
    }

    .limit-div {
        overflow: scroll;
        width: 100%;
        max-height: 100px;
    }

    .div-table {
        display: table;
    }

    .div-table-row {
        display: table-row;
    }

    .div-table-cell {
        display: table-cell;
    }
</style>