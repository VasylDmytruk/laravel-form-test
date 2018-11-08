<template>
    <div class="active-step-form" v-if="formBuilderData">
        <form action="" @submit.prevent="submitForm">
            <form-builder type="gui" :form="formBuilderData"></form-builder>
            <input type="submit" class="btn btn-success" value="Submit">
        </form>
    </div>
</template>

<script>
    export default {
        name: 'Form',
        props: {
            formBuilderData: {
                required: true,
            },
        },
        data() {
            return {
                formData: {},
                valid: true,
            };
        },
        methods: {
            submitForm() {
                this.validateFormData();

                if (this.valid) {
                    this.$emit('form-submit', this.formData);
                } else {
                    console.log('NOT VALID');
                }
            },
            validateFormData() {
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
                this.validateControl(control);
                this.formData[control.name] = control.value;
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