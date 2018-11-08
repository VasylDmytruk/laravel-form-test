<template>
    <div>
        <flow :steps="steps">

            <template slot="form" v-if="activeStep.form.data">
                <flow-form :formBuilderData="activeStep.form.data" @form-submit="formSubmitHandler"></flow-form>
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
        created() {
            this.getSteps();
        },
        methods: {
            ...mapActions({
                getSteps: 'steps/getItems',
            }),
            ...mapMutations({
                setActiveStepDone: 'activeStep/setDone',
            }),
            activeStepChanged(activeStep) {
                this.activeStep = activeStep;
            },
            formSubmitHandler(formData) {
                this.setActiveStepDone();
                console.log('formSubmitHandler', formData);
            },
        },
    };
</script>

<style scoped>

</style>
