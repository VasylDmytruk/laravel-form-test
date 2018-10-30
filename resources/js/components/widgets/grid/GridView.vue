<template>
    <div>
        <div>Items: {{rows.length}}</div>
        <div class="loading" v-if="rows.length === 0">Loading...</div>
        <div class="table-wrap" v-else>
            <table class="table table-bordered grid-table-fixed">
                <tr>
                    <template v-for="column in columns">
                        <th v-if="column.type === 'action'"></th>
                        <th v-else>{{column.label}}</th>
                    </template>
                </tr>
                <tr v-for="(row, index) in rows" :key="row.id">
                    <template v-for="column in columns">
                        <td v-if="column.type === 'action' && action">
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
                        </td>
                        <td v-else-if="column.type === 'expandable'" class="word-limit">
                            <div class="limit-div" v-if="canExpandData(index)">{{row[column.field]}}</div>
                            <div v-else><a href="#" @click.prevent="setExpandDataItem(index)">Show</a></div>
                        </td>
                        <td v-else>{{row[column.field]}}</td>
                    </template>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';

    export default {
        name: 'GridView',
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
</style>