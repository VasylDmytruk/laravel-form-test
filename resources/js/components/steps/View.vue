<template>
    <div>
        <h1>FormsView: {{step ? step.title : ''}}</h1>


        <div v-if="!step">Loading...</div>
        <div v-else>
            <p>{{step.title}}</p>
            <p>{{step.step_order}}</p>
            <p>{{step.healing_methods}}</p>

            <p v-if="step.form && step.form.title">Form title: {{step.form.title}}</p>
            <form-builder v-if="step.form && step.form.data" type="gui" :form="step.form.data"></form-builder>
        </div>
    </div>
</template>

<script>
    import {mapState, mapActions, mapMutations} from 'vuex';

    export default {
        name: "StepsView",
        props: {
            menuItem: {
                type: Object,
                default: function () {
                    return {
                        url: '/steps/edit/' + this.$route.params.id,
                        label: 'Edit Step',
                    };
                }
            },
        },
        computed: mapState({
            step: state => state.steps.lastItem,
        }),
        methods: {
            ...mapActions({
                getStep: 'steps/getItem',
            }),
            ...mapMutations({
                addMenuItem: 'menu/addItem',
                removeMenuItem: 'menu/removeItem',
            }),
        },
        created() {
            this.addMenuItem(this.menuItem);
            this.getStep(this.$route.params.id);
        },
        beforeDestroy() {
            this.removeMenuItem(this.menuItem);
        },
    }
</script>

<style scoped>

</style>