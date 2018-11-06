<template>
    <div>
        <h1>Steps Edit</h1>
        <step-form :data-model="step" v-on:step-form-submit="save">
            <template slot="form-form">
                <form-form :form="step.form"></form-form>
            </template>
        </step-form>
    </div>
</template>

<script>
    import {mapState, mapActions, mapMutations} from 'vuex';
    import StepForm from './Form';
    import Form from '../forms/Form';

    export default {
        name: "StepsEdit",
        components: {
            'step-form': StepForm,
            'form-form': Form,
        },
        props: {
            menuItem: {
                type: Object,
                default: function () {
                    return {
                        url: '/steps/view/' + this.$route.params.id,
                        label: 'View Step',
                    };
                }
            },
        },
        computed: mapState({
            step: state => state.steps.lastItem,
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
                getForm: 'steps/getItem',
                updateStep: 'steps/updateItem',
            }),
            ...mapMutations({
                addMenuItem: 'menu/addItem',
                removeMenuItem: 'menu/removeItem',
            }),
            save() {
                const data = {
                    step: this.step,
                    form: this.step.form,
                };

                this.updateStep({
                    id: this.$route.params.id,
                    data: data,
                })
                    .then(response => {
                        const notificationType = response.success ? 'success' : 'error';
                        const notificationText = response.success ? 'Your step saved successfully!' : 'Form validation failed!';
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