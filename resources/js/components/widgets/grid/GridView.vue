<template>
    <div>
        <div>Items: {{rows.length}}</div>
        <div class="table-wrap container">
            <div class="div-table">
                <div class="div-table-row row">
                    <template v-for="column in columns">
                        <div v-if="column.type === 'action'" class="div-table-cell" :class="getColClass()"></div>
                        <div v-else class="div-table-cell" :class="getColClass()">{{column.label}}</div>
                    </template>
                </div>
                <draggable :list="rowsForSorting" @end="endDragging">
                    <div class="div-table-row row" v-for="(row, index) in rowsForSorting" :key="row.id">
                        <template v-for="column in columns">
                            <div v-if="column.type === 'action' && action" class="div-table-cell" :class="getColClass()">
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
                            <div v-else-if="column.type === 'expandable'" class="word-limit div-table-cell"
                                 :class="getColClass()">
                                <div class="limit-div" v-if="canExpandData(index)">{{row[column.field]}}</div>
                                <div v-else><a href="#" @click.prevent="setExpandDataItem(index)">Show</a></div>
                            </div>
                            <div v-else class="div-table-cell" :class="getColClass()">{{row[column.field]}}</div>
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
            maxGridCols: {
                type: Number,
                default: 12,
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
            getColClass() {
                const columnsLength = this.columns.length;
                let colClass = 'col-md-';
                let index = '1';

                if (columnsLength > this.maxGridCols) {
                    index = this.maxGridCols;
                } else if (columnsLength < 1) {
                    index = 1;
                } else {
                    index = this.maxGridCols / columnsLength;
                }

                colClass += parseInt(index);

                return colClass;
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

    .div-table-cell {
        border: 1px solid;
    }

</style>