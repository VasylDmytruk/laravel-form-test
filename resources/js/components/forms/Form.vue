<template>
    <div v-if="form">
        <div class="form-group">
            <label for="form-title">Form Title</label>
            <input v-model="form.title" type="text" class="form-control" id="form-title">
        </div>

        <form-builder type="template" v-model="form.data"></form-builder>
    </div>
</template>

<script>
    export default {
        name: "Form",
        props: {
            form: {
                required: true,
            },
        },
    }
</script>

<style scoped>

</style>