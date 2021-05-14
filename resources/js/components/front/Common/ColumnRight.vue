<template>
    <b-col
        cols="4"
        class="col-mobile">
        <slot></slot>
        <keep-alive>
            <component v-bind:is="_currentModuleCategoryIconSideBar"></component>
        </keep-alive>
        <keep-alive>
            <component v-bind:is="_currentModuleThongBao"></component>
        </keep-alive>
        <keep-alive>
            <component v-bind:is="_currentModuleLichCongGiao"></component>
        </keep-alive>
        <keep-alive>
            <component v-bind:is="_currentModuleFanpage"></component>
        </keep-alive>
        <keep-alive>
            <component v-bind:is="_currentModuleYoutube"></component>
        </keep-alive>
    </b-col>
</template>

<script>
    import IconBook from 'v@front/assets/img/icon-book.png';
    import ImgFooter from 'v@front/assets/img/image_footer.jpg';

    export default {
        name: 'ContentColumnRight',
        props: {
            contentType: {
                default: 'top'
            }
        },
        components: {
            'module-category-icon-side-bar': () => import('v@front/modules/category_icon_side_bars'),
            'module-thong-bao': () => import('v@front/modules/thong_baos'),
            'module-lich-cong-giao': () => import('v@front/modules/lich_cong_giaos'),
            'module-info-fanpage': () => import('v@front/modules/info_fanpages'),
            'module-youtube-hanh-cac-thanh': () => import('v@front/modules/youtube_hanh_cac_thanhs')
        },
        data() {
            return {
                iconBook: IconBook,
                imgFooter: ImgFooter
            }
        },
        computed: {
            _currentModuleCategoryIconSideBar: function () {
                let contentType = 'content_' + this.contentType + '_column';
                let moduleName = this.$route.meta.layout_content[contentType].module_right_category_icon_side_bar;
                if (moduleName) {
                    return "module-" + moduleName.toLowerCase();
                }
                return false;
            },
            _currentModuleFanpage: function () {
                let contentType = 'content_' + this.contentType + '_column';
                let moduleName = this.$route.meta.layout_content[contentType].module_right_info_fanpage;
                if (moduleName) {
                    return "module-" + moduleName.toLowerCase();
                }
                return false;
            },
            _currentModuleYoutube: function () {
                let contentType = 'content_' + this.contentType + '_column';
                let moduleName = this.$route.meta.layout_content[contentType].module_right_youtube_hanh_cac_thanh;
                if (moduleName) {
                    return "module-" + moduleName.toLowerCase();
                }
                return false;
            },
            _currentModuleLichCongGiao: function () {
                let contentType = 'content_' + this.contentType + '_column';
                let moduleName = this.$route.meta.layout_content[contentType].module_right_lich_cong_giao;
                if (moduleName) {
                    return "module-" + moduleName.toLowerCase();
                }
                return false;
            },
            _currentModuleThongBao: function () {
                let contentType = 'content_' + this.contentType + '_column';
                let moduleName = this.$route.meta.layout_content[contentType].module_right_thong_bao;
                if (moduleName) {
                    return "module-" + moduleName.toLowerCase();
                }
                return false;
            },
        }
    }
</script>
