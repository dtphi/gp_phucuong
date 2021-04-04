<template>
    <div>
        <label>Show
            <select @change="_getResourceResults" class="">
                <option
                    v-for="(item, index) in $options.setting.perPageList" 
                    :value="item">{{item}}</option>
            </select></label>
    </div>
</template>

<script>
    import {
        mapGetters
    } from 'vuex';
    import AppConfig from '@app/api/admin/constants/app-config';

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
        },
        setting: {
            perPageList: AppConfig.perPageValues
        }
    };
</script>
