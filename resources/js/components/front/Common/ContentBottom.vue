<template>
    <div class="highlights mt-3">
        <slot name="before"></slot>
        <keep-alive>
            <component v-bind:is="_currentContentBoth" :content-type="contentType"></component>
        </keep-alive>
        <b-row class="mt-2">
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
        </b-row>
        <slot name="bottom"></slot>
    </div>
</template>

<script>

    export default {
        name: 'ContentBottom',
        components: {
            'column-both': () => import('./ColumnBoth'),
            'column-middle': () => import('com@front/Common/ColumnMiddle'),
            'column-left': () => import('com@front/Common/ColumnLeft'),
            'column-right': () => import('com@front/Common/ColumnRight')
        },
        props: {
            isTopBottomBoth: {
                default: true
            }
        },
        data() {
            return {
                contentType: 'bottom',
            }
        },
        computed: {
            currentContentLeft: function() {
			  	let moduleName = 'bottom-left';
            	return "content-" + moduleName.toLowerCase();
            },
            currentContentRight: function() {
			  	let moduleName = 'bottom-right';
            	return "content-" + moduleName.toLowerCase();
            },
            _currentContentBoth: function() {
			  	let moduleName = 'both';
                  if (this.$route.meta.layout_content.content_bottom_column.both_column) {
                      return "column-" + moduleName.toLowerCase();
                  }
            	
                return null;
            },
            _currentContentLeft: function () {
                let moduleName = 'left';

                if (this.$route.meta.layout_content.content_bottom_column.left_column) {
                    return "column-" + moduleName.toLowerCase();
                }
                return false;
            },
            _currentContentMiddle: function () {
                let moduleName = 'middle';

                if (this.$route.meta.layout_content.content_bottom_column.middle_column) {
                    return "column-" + moduleName.toLowerCase();
                }
                return false;
            },
            _currentContentRight: function () {
                let moduleName = 'right';
                if (this.$route.meta.layout_content.content_bottom_column.right_column) {
                    return "column-" + moduleName.toLowerCase();
                }
                return false;
            },
        }
    }
</script>
