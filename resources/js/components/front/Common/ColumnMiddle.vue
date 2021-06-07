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

    export default {
        name: 'ColumnMiddle',
        components: {
            'module-info-carousel': () => import('v@front/modules/special_infos'),
            'module-special-banner': () => import('v@front/modules/special_banners'),
            'module-loi-chua': () => import('v@front/modules/loi_chuas'),
            'module-tin-giao-phan': () => import('v@front/modules/tin_giao_phans'),
            'module-van-kien': () => import('v@front/modules/van_kiens'),
            'module-tin-giao-hoi': () => import('v@front/modules/tin_giao_hois'),
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
            _moduleList() {
                let list = [];
                let contentType = 'content_' + this.contentType + '_column';
                let modules = this.$route.meta.layout_content[contentType].middle_modules;
                if (modules && modules.length) {
                    
                    _.forEach(modules, function(item){
                        list.push("module-" + item.moduleName.toLowerCase());
                    });
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
