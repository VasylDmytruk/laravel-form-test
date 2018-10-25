<template>
    <div>
        <div>Forms number: {{allForms.length}}</div>
        <div class="loading" v-if="allForms.length === 0">Loading...</div>
        <div class="table-wrap" v-else>
            <table class="table table-bordered grid-table-fixed">
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Data</th>
                    <th></th>
                </tr>
                <tr v-for="(form, index) in allForms" :key="form.id">
                    <td>{{form.id}}</td>
                    <td>{{form.name}}</td>
                    <td class="word-limit">
                        <div class="limit-div" v-if="canShowData(index)">{{form.data}}</div>
                        <div v-else><a href="#" @click.prevent="setShowDataItem(index)">Show</a></div>
                    </td>
                    <td>
                        <router-link :to="'/forms/edit/' + form.id">Edit</router-link>
                        <br>
                        <router-link :to="'/forms/view/' + form.id">View</router-link>
                        <br>
                        <a href="#" v-on:click.prevent="deleteItem(index, form.id)">Delete</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</template>
<script>
    import Vue from 'vue';
    import {mapState, mapActions} from 'vuex';

    export default {
        name: "FormsIndex",
        data() {
            return {
                loading: true,
                errored: false,
                dataFormsServer: [],
                showData: {},
            }
        },
        computed: mapState({
            allForms: state => state.forms.allForms,
        }),
        created() {
            console.log('created*************************');
            this.getForms();
        },
        methods: {
            ...mapActions({
                getForms: 'forms/getForms',
                deleteForm: 'forms/deleteForm',
            }),
            canShowData(index) {
                return this.showData[index] !== undefined;
            },
            setShowDataItem(index) {
                Vue.set(this.showData, index, true);
            },
            deleteItem(index, id) {
                if (confirm('Do you really want to delete this item')) {
                    this.deleteForm({id, index})
                        .then(response => {
                            this.$notify({type: 'success', title: 'Deleted', text: 'Item deleted successfully!'});
                        })
                        .catch(error => {
                            this.$notify({type: 'error', title: 'Not deleted', text: 'Can not delete item!'});
                        });
                }
            },
        },
    }
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