<template>
    <b-col
        :cols="_getColumnNumber()"
        class="col-mobile">
        <slot></slot>
        <keep-alive v-for="(item,idx) in _moduleList"  :key="idx">
            <component  v-bind:is="item"></component>
        </keep-alive>
    </b-col>
</template>

<script>
    import {
        mapState
    } from 'vuex';
    import special_infos from 'v@front/modules/special_infos';
    import special_banners from 'v@front/modules/special_banners';
    import loi_chuas from 'v@front/modules/loi_chuas';
    import tin_giao_phans from 'v@front/modules/tin_giao_phans';
    import van_kiens from 'v@front/modules/van_kiens';
    import tin_giao_hois from 'v@front/modules/tin_giao_hois';

    export default {
        name: 'ColumnMiddle',
        components: {
            'module-info-carousel': special_infos,
            'module-special-banner': special_banners,
            'module-loi-chua': loi_chuas,
            'module-tin-giao-phan': tin_giao_phans,
            'module-van-kien': van_kiens,
            'module-tin-giao-hoi': tin_giao_hois,
        },
        props: {
            contentType: {
                default: 'top'
            }
        },
        data() {
            return {
            }
        },
        computed: {
            ...mapState({
                setting: state => state.cfApp.setting
            }),
            _moduleList() {
                let list = [];

                if (Object.keys(this.setting) && this.setting.hasOwnProperty('modules')) {
                    let contentType = 'content_' + this.contentType + '_column';
                    let modules = this.$route.meta.layout_content[contentType].middle_modules;
                    if (modules && modules.length) {
                        
                        _.forEach(modules, function(item){
                            list.push("module-" + item.moduleName.toLowerCase());
                        });
                    }
                }
                
                return list;
            },
            _colMiddleClass() {
                let contentType = 'content_' + this.contentType + '_column';
                if (this.$route.meta.layout_content[contentType].column_number == 3) {
                    return '5';
                }
                if (this.$route.meta.layout_content[contentType].colClass) {
                    return this.$route.meta.layout_content[contentType].colClass;
                }

                return '9';
            },
        },
        methods: {
            _getColumnNumber() {
                let contentType = 'content_' + this.contentType + '_column';
                
                return this.$route.meta.layout_content[contentType].middle_column;
            }
        }
    }
</script>
