<template>
    <div class="steps-flow">
        <div class="steps-header">
            <ul>
                <li v-for="(step, index) in steps" :key="step.id">
                    <a href="#" @click.prevent="setActiveStepHandler(index)"
                       :class="!isPrevDone(index) ? 'disabled' : ''">
                        <span :class="activeStep === step ? 'active-step' : ''">|{{index + 1}} - {{step.title}}</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="clearfix"></div>

        <div class="active-step-form" v-if="activeStep && activeStep.form && activeStep.form.data">
            <form action="" @submit.prevent="submitForm">
                <form-builder type="gui" :form="activeStep.form.data"></form-builder>
                <input type="submit" class="btn btn-success" value="Submit">
            </form>
        </div>

        <div>
            <span class="vgt-pull-left">
                <a href="#" :class="!hasPrevStep() ? 'disabled' : ''" @click.prevent="prevStep()">Prev</a>
            </span>
            <span class="vgt-pull-right">
                <a href="#" :class="(!canGoNext() || !hasNextStep()) ? 'disabled' : ''"
                   @click.prevent="nextStep()">Next</a>
            </span>
        </div>

    </div>
</template>

<script>
    import Vue from 'vue';
    import {mapState, mapActions} from 'vuex';

    export default {
        name: 'Index',
        data() {
            return {
                activeStep: null,
            };
        },
        computed: mapState({
            steps: state => state.steps.allItems,
        }),
        created() {
            this.getSteps();
        },
        methods: {
            ...mapActions({
                getSteps: 'steps/getItems',
            }),
            setActiveStepHandler(index) {
                if (this.steps[index]) {
                    this.setActiveStep(this.steps[index], index);
                }
            },
            setActiveStep(step, index) {
                this.activeStep = step;
                this.activeStep.index = index;
            },
            isPrevDone(currentIndex) {
                let isPrevDone = false;

                if (currentIndex <= 0) {
                    isPrevDone = true;
                } else {
                    const prevIndex = (currentIndex - 1 >= 0) ? currentIndex - 1 : currentIndex;
                    isPrevDone = this.steps[prevIndex] ? this.steps[prevIndex].done : false;
                }

                return isPrevDone;
            },
            submitForm() {
                Vue.set(this.activeStep, 'done', true);
                console.log('submitForm', this.activeStep.done);
                console.log('submitForm', this.activeStep);
            },
            canGoNext() {
                const canGoNext = this.activeStep && this.activeStep.done;

                return canGoNext;
            },
            nextStep() {
                if (this.activeStep.index !== undefined && this.steps && this.hasNextStep()) {
                    const nextIndex = this.activeStep.index + 1;
                    this.setActiveStep(this.steps[nextIndex], nextIndex);
                }
            },
            hasNextStep() {
                const hasNextStep = ((this.activeStep && this.activeStep.index + 1) < this.steps.length);

                return hasNextStep;
            },
            prevStep() {
                if (this.activeStep.index !== undefined && this.steps && this.hasPrevStep()) {
                    const nextIndex = this.activeStep.index - 1;
                    this.setActiveStep(this.steps[nextIndex], nextIndex);
                }
            },
            hasPrevStep() {
                return ((this.activeStep && this.activeStep.index - 1) >= 0);
            },
        },
        watch: {
            steps(newSteps, oldSteps) {
                if (!this.activeStep && newSteps.length) {
                    this.setActiveStep(newSteps[0], 0);
                }
            },
        },
    };
</script>

<style scoped>
    .steps-flow ul {
        list-style-type: none;
    }

    .steps-flow ul li {
        float: left;
    }

    .active-step {
        background-color: #1ab0ae;
        color: #f8fafc;
    }

    a.disabled {
        color: currentColor;
        cursor: not-allowed;
        opacity: 0.5;
        text-decoration: none;
    }
</style>
