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
                formData: 'hello',
            };
        },
        methods: {
            submitForm() {
                // TODO add validation

                this.$emit('form-submit', this.formBuilderData);
            },
        },
    };
</script>

<style scoped>

</style>