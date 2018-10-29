<template>
    <div>
        <grid-view :columns="columns" :rows="allForms" :action="action" :delete-item-func="deleteForm"></grid-view>
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
                loading: true,
                errored: false,
                dataFormsServer: [],
                showData: {},
                columns: [
                    {label: 'ID', field: 'id',},
                    {label: 'Name', field: 'name',},
                    {label: 'Data', field: 'data', type: 'expandable',},
                    {type: 'action'},
                ],
                action: 'forms',
            }
        },
        computed: mapState({
            allForms: state => state.forms.allForms,
        }),
        created() {
            this.getForms();
        },
        methods: {
            ...mapActions({
                getForms: 'forms/getForms',
                deleteForm: 'forms/deleteForm',
            }),
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