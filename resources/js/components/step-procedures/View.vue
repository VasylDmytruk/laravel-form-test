<template>
    <div>
        <h1>Step procedure {{stepProcedure ? stepProcedure.id : 'empty'}}</h1>

        <p v-if="stepProcedure.total_spent_time">
            Spent total time: {{formattedTime(stepProcedure.total_spent_time)}}
        </p>

        <div class="container">
            <div class="" v-for="(doneStep, index) in stepProcedure.done_steps" :key="doneStep.id">
                <h4>Step: {{doneStep.step.title}} ({{formattedTime(doneStep.spent_time)}})</h4>
                <div class="step-content">
                    <template v-for="section in doneStep.form_data_value.sections">
                        <template v-for="formRow in section.rows">
                            <template v-for="control in formRow.controls">
                                <div class="row">
                                    <div class="col-md-6">{{control.label}}</div>
                                    <div class="col-md-6">{{control.value}}</div>
                                </div>
                            </template>
                        </template>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState, mapActions} from 'vuex';
    import DateTimeHelper from './../../helpers/DateTimeHelper';

    export default {
        name: 'StepProcedureView',
        computed: mapState({
            stepProcedure: state => state.stepProcedures.lastItem,
        }),
        created() {
            this.getStepProcedure(this.$route.params.id);

            setTimeout(() => {
                console.log(this.stepProcedure);
            }, 1000);
        },
        methods: {
            ...mapActions({
                getStepProcedure: 'stepProcedures/getItem',
            }),
            formattedTime(timeToFormat) {
                return DateTimeHelper.getFormattedTime(timeToFormat);
            },
        },
    };
</script>

<style scoped>

</style>