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
    import {
        mapGetters,
        mapActions
    } from 'vuex';
    import ImgFooter from 'v@front/assets/img/image_footer.jpg';
    import {
        MODULE_INFO,
    } from '@app/stores/front/types/module-types';
    import {
        GET_DETAIL
    } from '@app/stores/front/types/action-types';

    export default {
        name: 'ColumnMiddle',
        components: {
            'module-info-carousel': () => import('v@front/modules/info_carousels')
        },
        data() {
            return {
                imgFooter: ImgFooter
            }
        },
        computed: {
            _colMiddleClass() {
                if (this.$route.meta.layout_content.content_top_column.column_number == 3) {
                    return '5';
                }
                if (this.$route.meta.layout_content.content_top_column.colClass) {
                    return this.$route.meta.layout_content.content_top_column.colClass;
                }

                return '9';
            },
            _currentModule: function () {
                let moduleName = this.$route.meta.layout_content.content_top_column.middle_module_info_carousel;
                if (moduleName) {
                    return "module-" + moduleName.toLowerCase();
                }
                return false;
            },
        }
    }
</script>
