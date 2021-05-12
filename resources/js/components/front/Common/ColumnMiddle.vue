<template>
    <b-col
        :cols="colMiddleClass"
        class="col-mobile">
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
            'content-bottom-right': () => import('com@front/Common/ContentBottomRight'),
            'content-left': () => import('com@front/Common/ContentLeft')
        },
        data() {
            return {
                imgFooter: ImgFooter
            }
        },
        computed: {
            currentContentRight: function () {
                let moduleName = 'bottom-right';
                return "content-" + moduleName.toLowerCase();
            },
            colMiddleClass() {
                if (this.$route.meta.layout_content.column_number == 3) {
                    return '5';
                }

                return '9';
            }
        }
    }
</script>
