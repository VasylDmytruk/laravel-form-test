
export default {
    type: Object,
    default: function () {
        return {
            url: '/forms/view/' + this.$route.params.id,
            label: 'View',
        };
    }
}
