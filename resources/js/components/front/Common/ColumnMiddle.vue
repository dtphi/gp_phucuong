<template>
    <b-col
        :cols="_colMiddleClass"
        class="col-mobile">
        <slot></slot>
        <keep-alive v-for="(item,idx) in _moduleList"  :key="idx">
            <component  v-bind:is="item"></component>
        </keep-alive>
    </b-col>
</template>

<script>
    import ImgFooter from 'v@front/assets/img/image_footer.jpg';

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
                imgFooter: ImgFooter
            }
        },
        computed: {
            _loadModules: function () {
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
            _currentModule: function () {
                let contentType = 'content_' + this.contentType + '_column';
                let moduleName = this.$route.meta.layout_content[contentType].middle_module_info_carousel;
                if (moduleName) {
                    return "module-" + moduleName.toLowerCase();
                }
                return false;
            },
            _currentModuleSpecialBanner: function () {
                let contentType = 'content_' + this.contentType + '_column';
                let moduleName = this.$route.meta.layout_content[contentType].middle_module_special_banner;
                if (moduleName) {
                    return "module-" + moduleName.toLowerCase();
                }
                return false;
            },
            _currentModuleLoiChua: function () {
                let contentType = 'content_' + this.contentType + '_column';
                let moduleName = this.$route.meta.layout_content[contentType].module_middle_loi_chua;
                if (moduleName) {
                    return "module-" + moduleName.toLowerCase();
                }
                return false;
            },
            _currentModuleTinGiaoPhan: function() {
                let contentType = 'content_' + this.contentType + '_column';
                let moduleName = this.$route.meta.layout_content[contentType].module_middle_tin_giao_phan;
                if (moduleName) {
                    return "module-" + moduleName.toLowerCase();
                }
                return false;
            },
            _currentModuleVanKien: function () {
                let contentType = 'content_' + this.contentType + '_column';
                let moduleName = this.$route.meta.layout_content[contentType].module_middle_van_kien;
                if (moduleName) {
                    return "module-" + moduleName.toLowerCase();
                }
                return false;
            },
        }
    }
</script>
