<template>
    <div>
        <h1>Steps Create</h1>

        <step-form :data-model="step" v-on:form-submit="save"></step-form>
    </div>
</template>

<script>
    import {mapActions} from 'vuex';
    import Form from './Form';

    export default {
        name: "StepsCreate",
        components: {
            'step-form': Form
        },
        data() {
            return {
                step: {
                    title: '',
                    healing_methods: '',
                    step_order: 0,
                },
                form: {

                },
            }
        },
        methods: {
            ...mapActions({
                createStep: 'steps/createItem',
            }),
            save() {
                this.createStep(this.step)
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