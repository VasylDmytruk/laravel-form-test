<template>
    <div>
        <h1>FormsCreate</h1>
        <button class="btn btn-success" @click="save">Save</button>

        <form-form :form="form"></form-form>
    </div>
</template>

<script>
    import {mapActions} from 'vuex';
    import Form from './Form';

    export default {
        name: "FormsCreate",
        components: {
            'form-form': Form
        },
        data() {
            return {
                form: {
                    title: '',
                    data: null,
                },
            }
        },
        methods: {
            ...mapActions({
                createForm: 'forms/createItem',
            }),
            save() {
                if (!this.form.data._uniqueId) {
                    return;
                }

                this.createForm(this.form)
                    .then(response => {
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