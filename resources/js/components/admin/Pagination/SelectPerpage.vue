<template>
    <div class="dataTables_length">
        <label>Show
            <select @change="_getResourceResults" class="custom-select custom-select-sm form-control form-control-sm">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select> entries</label>
    </div>
</template>

<script>
    import {
        mapGetters,
        mapActions
    } from 'vuex';

    export default {
        name: 'SelectPerpage',
        components: {},
        computed: {
            ...mapGetters(['moduleNameActive', 'moduleActionListActive']),
        },
        methods: {
            _getResourceResults (event) {
                const _self = this;
                
                var perPage = event.target.value; 
                
                const actionName = _self.moduleNameActive + '/' + _self.moduleActionListActive;
                _self.$store.dispatch(actionName, {perPage: parseInt(perPage)});
            }
        }
    };
</script>
