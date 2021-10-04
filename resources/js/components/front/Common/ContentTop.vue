<template>
    <b-row id="gp-phucuong-content-top" class="my-3">
        <slot name="before"></slot>
        <keep-alive>
            <component v-bind:is="_currentContentLeft" :content-type="contentType">
                <slot name="column_left"></slot>
            </component>
        </keep-alive>
        <keep-alive>
            <component v-bind:is="_currentContentMiddle" :content-type="contentType"> 
                <slot></slot>
            </component>
        </keep-alive>
        <keep-alive>
            <component v-bind:is="_currentContentRight" :content-type="contentType">
                <slot name="column_right"></slot>
            </component>
        </keep-alive>
        <slot name="bottom"></slot>
    </b-row>
</template>

<script>

    export default {
        name: 'ContentTop',
        components: {
            'column-right': () => import('com@front/Common/ColumnRight'),
            'column-middle': () => import('com@front/Common/ColumnMiddle'),
            'column-left': () => import('com@front/Common/ColumnLeft')
        },
        data() {
            return {
                contentType: 'top'
            }
        },
        computed: {
            _currentContentRight: function () {
                let moduleName = 'right';
                if (this.$route.meta.layout_content.content_top_column.right_column) {
                    return "column-" + moduleName.toLowerCase();
                }
                return false;
            },
            _currentContentLeft: function () {
                let moduleName = 'left';

                if (this.$route.meta.layout_content.content_top_column.left_column) {
                    return "column-" + moduleName.toLowerCase();
                }
                return false;
            },
            _currentContentMiddle: function () {
                let moduleName = 'middle';

                if (this.$route.meta.layout_content.content_top_column.middle_column) {
                    return "column-" + moduleName.toLowerCase();
                }
                return false;
            },
        },
    }
</script>
