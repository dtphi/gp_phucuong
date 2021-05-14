<template>
    <b-col
        :cols="_colMiddleClass"
        class="col-mobile">
        <keep-alive>
            <component v-bind:is="_currentModule"></component>
        </keep-alive>
        <slot></slot>
    </b-col>
</template>

<script>
    import ImgFooter from 'v@front/assets/img/image_footer.jpg';

    export default {
        name: 'ColumnMiddle',
        components: {
            'module-info-carousel': () => import('v@front/modules/info_carousels')
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
        }
    }
</script>
