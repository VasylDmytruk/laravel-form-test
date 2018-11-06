<template>
    <div class="form-container">
        <form @submit.prevent="">
            <div class="form-group">
                <label for="title">Title</label>
                <input v-model="dataModel.title" type="text" class="form-control" id="title" required>
            </div>
            <div class="form-group">
                <label for="healing_methods">Healing Methods</label>
                <textarea v-model="dataModel.healing_methods" class="form-control" id="healing_methods" rows="6"></textarea>
            </div>
        </form>

        <slot name="form-form"></slot>

        <button @click.prevent="onStepFormSubmit" type="submit" class="btn btn-primary">Submit</button>
    </div>
</template>

<script>
    export default {
        name: 'Form',
        props: {
            dataModel: {
                type: Object,
                required: true,
            },
        },
        methods: {
            onStepFormSubmit() {
                this.$emit('step-form-submit');
            },
        },
    };
</script>

<style scoped>
    .form-container {
        margin-bottom: 10px;
    }
</style>