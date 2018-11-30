<template>
    <div>
        <flow
                :steps="steps"
                @step-finished="stepFinishedHandler()"
                @step-canceled="stepCanceledHandler"
        >

            <template slot="form" v-if="activeStep.form.data">
                <flow-form
                        :formBuilderData="activeStep.form.data"
                        @form-submit="formSubmitHandler"
                        :stepDone="activeStep.done"></flow-form>
            </template>

        </flow>
    </div>
</template>

<script>
    import {mapState, mapMutations, mapActions, mapGetters} from 'vuex';
    import Flow from './Flow';
    import Form from './Form';
    import DateTimeHelper from './../../helpers/DateTimeHelper';
    import NotificationHelper from './../../helpers/NotificationHelper';

    export default {
        name: 'Index',
        components: {
            Flow,
            'flow-form': Form,
        },
        computed: {
            ...mapState({
                activeStep: state => state.activeStep.activeStep,
                steps: state => state.doneSteps.doneSteps,
            }),
            ...mapGetters({
                areAllStepsDone: 'doneSteps/areAllDone',
            }),
        },
        data() {
            return {
                startTime: 0,
            };
        },
        created() {
            this.getDoneSteps();

            this.startTime = DateTimeHelper.getCurrentTime();
        },
        methods: {
            ...mapActions({
                createStepTime: 'stepProcedures/createItem',
                getDoneSteps: 'doneSteps/getDoneSteps',
                resetDoneSteps: 'doneSteps/resetDoneSteps',
                createDoneSteps: 'doneSteps/createDoneSteps',
            }),
            ...mapMutations({
                setActiveStepDone: 'activeStep/setDone',
                setActiveStep: 'activeStep/setActiveStep',
                resetActiveStep: 'activeStep/resetActiveStep',
            }),
            formSubmitHandler(formData) {
                // TODO need some notification of sequence of this code
                const endTime = DateTimeHelper.getCurrentTime();
                this.processTime(endTime);

                console.log('formSubmitHandler formData', formData);
                this.setActiveStepDone();

                // console.log('formSubmitHandler', formData);
                // const isValid = this.$refs.observer.validate();
                // isValid.then(value => {
                //     console.log('is valid value: ', value);
                // }).catch(error => {
                //     console.error('is valid error', error);
                // });
            },

            processTime(endTime) {
                this.activeStep.spent_time = endTime - this.startTime;
                this.startTime = DateTimeHelper.getCurrentTime();
            },

            setActiveFirstStep(steps) {
                if (this.activeStep.id === null && steps.length) {
                    this.setActiveStep({step: steps[0], index: 0});
                } else {
                    this.resetActiveStep();
                }
            },

            stepFinishedHandler() {
                if (this.areAllStepsDone()) {
                    console.log('stepFinishedHandler');

                    this.createDoneSteps()
                        .then(response => {
                            const notificationType = response.success
                                ? NotificationHelper.TYPE_SUCCESS
                                : NotificationHelper.TYPE_ERROR;
                            const notificationText = response.success
                                ? 'Your steps saved successfully!'
                                : 'Steps did not save! Some error occurred!';

                            this.$notify({type: notificationType, title: 'Save result', text: notificationText});
                        })
                        .catch(error => {
                            console.error(error);
                            this.$notify({type: 'error', title: 'Save result', text: 'Some error occurred!'});
                        });

                    this.resetSteps();
                }
            },

            stepCanceledHandler() {
                this.resetSteps();
                this.$notify({type: NotificationHelper.TYPE_WARNING, text: 'Canceled!'});
            },

            resetSteps() {
                this.resetActiveStep();
                this.resetDoneSteps();
            },
        },
        watch: {
            steps(newSteps) {
                if (this.activeStep.id === null) {
                    this.setActiveFirstStep(newSteps);
                }
            },
        },
    };
</script>

<style scoped>

</style>
