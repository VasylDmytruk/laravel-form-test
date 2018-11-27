<template>
    <div class="active-step-form" v-if="formBuilderData">
        <form action="" @submit.prevent="submitForm">
            <form-builder type="gui" :form="formBuilderData"></form-builder>

            <!--<input-->
                    <!--type="text"-->
                    <!--:name="validatorObj.name"-->
                    <!--v-validate="validatorObj.validationRules"-->
                    <!--:class="{ input: true, 'is-danger': errors.has(validatorObj.name) }"-->
            <!--&gt;-->
            <!--<span>{{ errors.first(validatorObj.name) }}</span>-->
            <!--<span v-show="errors.has(validatorObj.name)"-->
                  <!--class="help is-danger">-->
                <!--{{ errors.first(validatorObj.name) }}-->
            <!--</span>-->

            <input v-if="!isStepDone()" type="submit" class="btn btn-info" value="Submit">
            <a v-else type="submit" class="btn disabled" href="#" @click.prevent="">Submit</a>


        </form>
    </div>
</template>

<script>
    import Vue from 'vue';

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

                // console.log('this.$validator', this.$validator);
                // console.log('this.$validator.errors', this.$validator.errors);
                // console.log('this.$validator.fields', this.$validator.fields);
                // this.$validator.validateAll().then(result => {
                //     if (result) {
                //         // eslint-disable-next-line
                //         console.log("Form Submitted!************");
                //         return;
                //     }
                //
                //     console.error("Correct them errors!**************", result);
                // });

                // this.validateFormData();


                console.log('this.$emit(\'form-submit', this.formData);
                this.$emit('form-submit', this.formData);


                // this.valid = true;
                // this.validateFormData();
                //
                // if (this.valid) {
                //     this.$emit('form-submit', this.formData);
                // } else {
                //     console.log('NOT VALID');
                // }
            },
            validateFormData() {
                // console.log('validateFormData');
                this.formBuilderData.sections.forEach(section => {
                    this.iterateSection(section);
                });
            },
            iterateSection(section) {
                section.rows.forEach(row => {
                    this.iterateRow(row);
                });
            },
            iterateRow(row) {
                row.controls.forEach(control => {
                    this.iterateControl(control);
                });
            },
            iterateControl(control) {
                Vue.set(control, 'formSubmit', true);
                console.log('control.formSubmit', control.formSubmit);
                // this.validateControl(control);
                // this.formData[control.name] = control.value;
            },
            validateControl(control) {
                // TODO validate control

                if (control.required && control.value === null) {
                    // TODO add validation false view to form gui
                    control.valid = false;
                    control.validationMessage = `"${control.label}" is required`;
                    this.valid = false;
                }
            },
        },
    };
</script>

<style scoped>

</style>