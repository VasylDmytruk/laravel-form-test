<template>
    <div>
        <flow :steps="steps">

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
            steps: state => state.steps.allItems,
            activeStep: state => state.activeStep.activeStep,
        }),
        data() {
            return {
                startTime: 0,
            };
        },
        created() {
            console.log('created steps-flow/index');

            this.getSteps();

            this.startTime = this.getCurrentTime();
        },
        destroyed() {
            console.log('destroyed steps-flow/index');
        },
        methods: {
            ...mapActions({
                getSteps: 'steps/getItems',
                createStepTime: 'stepTimes/createItem',
            }),
            ...mapMutations({
                setActiveStepDone: 'activeStep/setDone',
            }),
            activeStepChanged(activeStep) {
                this.activeStep = activeStep;
            },
            formSubmitHandler(formData) {
                // TODO need some notification of sequence of this code
                const endTime = this.getCurrentTime();
                this.processTime(endTime);

                this.setActiveStepDone();
                console.log('formSubmitHandler', formData);

                // const isValid = this.$refs.observer.validate();
                // isValid.then(value => {
                //     console.log('is valid value: ', value);
                // }).catch(error => {
                //     console.error('is valid error', error);
                // });

            },

            processTime(endTime) {
                const diff = endTime - this.startTime;
                console.log('startTime', this.startTime);
                console.log('endTime', endTime);
                console.log('diff', diff);

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
        },
    };
</script>

<style scoped>

</style>
