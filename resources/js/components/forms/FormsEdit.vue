<template>
    <div>
        <h1>FormsEdit</h1>
        <button class="btn btn-success" @click="save">Save</button>

        <form-form :form="form"></form-form>
    </div>
</template>

<script>
    import {mapState, mapActions, mapMutations} from 'vuex';
    import Form from './Form';
    import viewMenuItemProp from '../../menu/viewMenuItemProp';

    export default {
        name: "FormsEdit",
        components: {
            'form-form': Form,
        },
        props: {
            menuItem: viewMenuItemProp,
        },
        computed: mapState({
            form: state => state.forms.lastItem,
        }),
        created() {
            this.addMenuItem(this.menuItem);
            this.getForm(this.$route.params.id);
        },
        beforeDestroy() {
            this.removeMenuItem(this.menuItem);
        },
        methods: {
            ...mapActions({
                getForm: 'forms/getItem',
                updateForm: 'forms/updateItem',
            }),
            ...mapMutations({
                addMenuItem: 'menu/addItem',
                removeMenuItem: 'menu/removeItem',
            }),
            save() {
                this.updateForm({
                    id: this.$route.params.id,
                    data: this.form,
                })
                    .then(response => {
                        console.log('response', response);
                        const notificationType = response.success ? 'success' : 'error';
                        const notificationText = response.success ? 'Your form saved successfully!' : 'Form validation failed!';
                        this.$notify({type: notificationType, title: 'Save result', text: notificationText});
                    })
                    .catch(error => {
                        this.$notify({
                            type: 'error',
                            title: 'Error',
                            text: 'Form not saved!'
                        });
                    });
            }
        }
    }
</script>

<style scoped>

</style>