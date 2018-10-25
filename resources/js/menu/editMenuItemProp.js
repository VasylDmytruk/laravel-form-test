
export default {
    type: Object,
    default: function () {
        return {
            url: '/forms/edit/' + this.$route.params.id,
            label: 'Edit',
        };
    }
}
