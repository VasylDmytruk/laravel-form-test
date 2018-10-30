<template>
    <div>
        <div class="form-group">
            <label for="form-title">Form Title</label>
            <input v-model="form.title" type="text" class="form-control" id="form-title">
            <div v-if="!form.title" class="alert-danger">
                Form Title is required.
            </div>
        </div>

        <form-builder type="template" v-model="form.data"></form-builder>
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