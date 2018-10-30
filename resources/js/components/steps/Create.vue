<template>
    <div>
        <h1>Steps Create</h1>

        <step-form :data-model="step" v-on:step-form-submit="save">
            <template slot="form-form">
                <form-form :form="form"></form-form>
            </template>
        </step-form>
    </div>
</template>

<script>
    import {mapActions} from 'vuex';
    import StepForm from './Form';
    import Form from '../forms/Form';

    export default {
        name: "StepsCreate",
        components: {
            'step-form': StepForm,
            'form-form': Form,
        },
        data() {
            return {
                step: {
                    title: '',
                    healing_methods: '',
                    step_order: 0,
                },
                form: {
                    title: '',
                    data: null,
                },
            }
        },
        methods: {
            ...mapActions({
                createStep: 'steps/createItem',
            }),
            save() {
                const data = {
                    step: this.step,
                    form: this.form,
                };

                this.createStep(data)
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