<template>
    <b-row id="content-main" class="my-3">
        <slot name="before"></slot>
        <slot name="before_column_both"></slot>
        <keep-alive>
            <component v-bind:is="_currentContentBoth" :content-type="contentType" class="col-mobile col-12">
            </component>
        </keep-alive>
        <keep-alive>
            <component v-bind:is="_currentContentLeft" :content-type="contentType">
                <slot name="column_left"></slot>
            </component>
        </keep-alive>
        <keep-alive>
            <component v-bind:is="_currentContentMiddle" :content-type="contentType">
                <slot name="column_middle"></slot>
            </component>
        </keep-alive>
        <keep-alive>
            <component v-bind:is="_currentContentRight" :content-type="contentType">
                 <slot name="column_right"></slot>
            </component>
        </keep-alive>
        <slot name="bottom"></slot>
        <slot name="bottom_column_both"></slot>
    </b-row>
</template>

<script>

    export default {
        name: 'MainContent',
        components: {
            'column-both': () => import('./ColumnBoth'),
            'column-right': () => import('com@front/Common/ColumnRight'),
            'column-middle': () => import('com@front/Common/ColumnMiddle'),
            'column-left': () => import('com@front/Common/ColumnLeft')
        },
        data() {
            return {
                contentType: 'main'
            }
        },
        computed: {
            _currentContentBoth: function() {
			  	let moduleName = 'both';
            	if (this.$route.meta.layout_content.content_main_column.both_column) {
                    return "column-" + moduleName.toLowerCase();
                }
                return false;
            },
            _currentContentRight: function () {
                let moduleName = 'right';
                if (this.$route.meta.layout_content.content_main_column.right_column) {
                    return "column-" + moduleName.toLowerCase();
                }
                return false;
            },
            _currentContentMiddle: function () {
                let moduleName = 'middle';

                if (this.$route.meta.layout_content.content_main_column.middle_column) {
                    return "column-" + moduleName.toLowerCase();
                }
                return false;
            },
            _currentContentLeft: function () {
                let moduleName = 'left';

                if (this.$route.meta.layout_content.content_main_column.left_column) {
                    return "column-" + moduleName.toLowerCase();
                }
                return false;
            },
        },
        methods: {
        }
    }
</script>
