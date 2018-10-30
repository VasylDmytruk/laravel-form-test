<template>
    <div>
        <h1>FormsView: {{form ? form.name : ''}}</h1>


        <div v-if="!form">Loading...</div>
        <div v-else>
            <form-builder v-if="form.data" type="gui" :form="form.data"></form-builder>
        </div>
    </div>
</template>

<script>
    import {mapState, mapActions, mapMutations} from 'vuex';
    import editMenuItemProp from '../../menu/editMenuItemProp';

    export default {
        name: "FormsView",
        props: {
            menuItem: editMenuItemProp,
        },
        computed: mapState({
            form: state => state.forms.lastItem,
        }),
        methods: {
            ...mapActions({
                getForm: 'forms/getItem',
            }),
            ...mapMutations({
                addMenuItem: 'menu/addItem',
                removeMenuItem: 'menu/removeItem',
            }),
        },
        created() {
            this.addMenuItem(this.menuItem);
            this.getForm(this.$route.params.id);
        },
        beforeDestroy() {
            this.removeMenuItem(this.menuItem);
        },
    }
</script>

<style scoped>

</style>