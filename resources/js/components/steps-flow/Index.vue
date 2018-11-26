<template>
    <div>
        <flow :steps="steps" @step-finished="stepFinishedHandler()" @step-canceled="stepCanceledHandler">

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
    import {mapState, mapMutations, mapActions} from 'vuex';
    import Flow from './Flow';
    import Form from './Form';

    export default {
        name: 'Index',
        components: {
            Flow,
            'flow-form': Form,
        },
        computed: mapState({
            activeStep: state => state.activeStep.activeStep,
            steps: state => state.doneSteps.doneSteps,
        }),
        data() {
            return {
                startTime: 0,
            };
        },
        created() {
            this.getDoneSteps();

            this.startTime = this.getCurrentTime();
        },
        methods: {
            ...mapActions({
                createStepTime: 'stepProcedures/createItem',
                getDoneSteps: 'doneSteps/getDoneSteps',
                resetDoneSteps: 'doneSteps/resetDoneSteps',
            }),
            ...mapMutations({
                setActiveStepDone: 'activeStep/setDone',
                setActiveStep: 'activeStep/setActiveStep',
                resetActiveStep: 'activeStep/resetActiveStep',
            }),
            formSubmitHandler(formData) {
                // TODO need some notification of sequence of this code
                const endTime = this.getCurrentTime();
                this.processTime(endTime);

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
                const diff = endTime - this.startTime;

                const stepTime = {
                    step_id: this.activeStep.id,
                    spent_time: diff,
                };

                this.createStepTime(stepTime)
                    .then(response => {
                        console.log(response);
                    })
                    .catch(error => {
                        console.log(error);
                    });

                this.startTime = this.getCurrentTime();
            },

            getCurrentTime() {
                return Math.round((new Date()).getTime() / 1000);
            },

            setActiveFirstStep(steps) {
                if (this.activeStep.id === null && steps.length) {
                    this.setActiveStep({step: steps[0], index: 0});
                } else {
                    this.resetActiveStep();
                }
            },

            mergeSteps(array1, array2) {
                var result_array = [];
                var arr = array1.concat(array2);
                var len = arr.length;
                var assoc = {};

                while (len--) {
                    var item = arr[len];

                    if (!assoc[item]) {
                        result_array.unshift(item);
                        assoc[item] = true;
                    }
                }

                return result_array;
            },

            stepFinishedHandler() {
                // TODO save doneSteps
            },

            stepCanceledHandler() {
                // |TODO Reset doneSteps

                console.log('stepCanceledHandler');
                // TODO fix error, finish it
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
