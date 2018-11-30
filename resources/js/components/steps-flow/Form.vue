<template>
    <div class="active-step-form" v-if="formBuilderData">
        <form action="" @submit.prevent="submitForm">
            <form-builder type="gui" :form="formBuilderData"></form-builder>

            <input v-if="!isStepDone()" type="submit" class="btn btn-info" value="Submit">
            <a v-else type="submit" class="btn disabled" href="#" @click.prevent="">Submit</a>

        </form>
    </div>
</template>

<script>
    import {Validator} from 'vee-validate';
    import ControlValidatorHelper from './../../helpers/ControlValidatorHelper';

    export default {
        name: 'Form',
        props: {
            formBuilderData: {
                required: true,
            },

            stepDone: {},
        },
        data() {
            return {
                formData: {},
                valid: true,
                validatorObj: {
                    validationRules: 'required',
                    name: 'testValidation',
                },
                veeValidator: new Validator(),
                isLastSection: false,
                isLastRow: false,
                isLastControl: false,
            };
        },
        methods: {
            isStepDone() {
                return this.stepDone === true;
            },
            submitForm() {
                if (this.isStepDone()) {
                    return;
                }

                this.valid = true;
                this.validateFormData();
            },
            validateFormData() {
                this.formBuilderData.sections.forEach((section, index, sections) => {
                    this.isLastSection = index === sections.length - 1;
                    this.iterateSection(section);
                });
            },
            iterateSection(section) {
                section.rows.forEach((row, index, rows) => {
                    this.isLastRow = index === rows.length - 1;
                    this.iterateRow(row);
                });
            },
            iterateRow(row) {
                row.controls.forEach((control, index, controls) => {
                    this.isLastControl = index === controls.length - 1;
                    this.validateControl(control);
                });
            },
            async validateControl(control) {
                const {valid, errors} = await this.veeValidator.verify(
                    control.value,
                    control.validationRules,
                    {name: `"${control.label}"`}
                );

                if (valid) {
                    ControlValidatorHelper.resetErrors(control);
                } else {
                    this.valid = false;
                    ControlValidatorHelper.setErrors(control, errors);
                }

                this.emitSubmitIfNeed();
            },
            emitSubmitIfNeed() {
                if (this.isLastItem() && this.valid) {
                    this.$emit('form-submit', this.formData);
                } else {
                    console.log('NOT VALID');
                }
            },
            isLastItem() {
                return this.isLastSection && this.isLastRow && this.isLastControl;
            },
        },
    };
</script>

<style scoped>

</style>