<template>
    <div>
        <p>Name: </p>
        <input type="text" v-model="form.name">
        <p v-if="!form.name" class="control-error">form name is required</p>
        <form-builder type="template" v-model="form.data"></form-builder>

        <p>form builder gui</p>
        <form-builder v-if="form.data" type="gui" :form="form.data"></form-builder>
    </div>
</template>

<script>
    export default {
        name: "Form",
        props: {
            form: {
                type: Object,
                required: true,
            },
        },
    }
</script>

<style scoped>

</style>