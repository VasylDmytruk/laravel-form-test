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

        <slot name="form"></slot>

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
    import {mapState, mapMutations} from 'vuex';

    export default {
        name: 'Flow',
        props: {
            steps: {
                required: true,
            },
        },
        computed: mapState({
            activeStep: state => state.activeStep.activeStep,
        }),
        methods: {
            ...mapMutations({
                setActiveStep: 'activeStep/setActiveStep',
            }),
            setActiveStepHandler(index) {
                if (this.isPrevDone(index) && this.steps[index]) {
                    this.setActiveStep({step: this.steps[index], index});
                }
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
            canGoNext() {
                return this.activeStep.done;
            },
            nextStep() {
                if (this.canGoNext() && this.hasNextStep() && this.activeStep.index !== undefined && this.steps && this.hasNextStep()) {
                    const nextIndex = this.activeStep.index + 1;
                    this.setActiveStep({step: this.steps[nextIndex], index: nextIndex});
                }
            },
            hasNextStep() {
                const hasNextStep = ((this.activeStep.index + 1) < this.steps.length);

                return hasNextStep;
            },
            prevStep() {
                if (this.hasPrevStep() && this.activeStep.index !== undefined && this.steps && this.hasPrevStep()) {
                    const nextIndex = this.activeStep.index - 1;
                    this.setActiveStep({step: this.steps[nextIndex], index: nextIndex});
                }
            },
            hasPrevStep() {
                return ((this.activeStep.index - 1) >= 0);
            },
            resetActiveStepParentChangeFlag() {
                this.activeStepParentChangeFlag = false;
            },
        },
        watch: {
            steps(newSteps) {
                // TODO maybe move to created, maybe
                if (this.activeStep.id === null && newSteps.length) {
                    this.setActiveStep({step: newSteps[0], index: 0});
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