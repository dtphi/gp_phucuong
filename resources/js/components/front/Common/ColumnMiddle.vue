<template>
    <b-col
        :cols="_colMiddleClass"
        class="col-mobile">
        <keep-alive>
            <component v-bind:is="_currentModule"></component>
        </keep-alive>
        <keep-alive>
            <component v-bind:is="_currentModuleSpecialBanner"></component>
        </keep-alive>
         <keep-alive>
            <component v-bind:is="_currentModuleLoiChua"></component>
        </keep-alive>
        <slot></slot>
        <keep-alive>
            <component v-bind:is="_currentModuleTinGiaoPhan"></component>
        </keep-alive>
        <keep-alive>
            <component v-bind:is="_currentModuleVanKien"></component>
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
