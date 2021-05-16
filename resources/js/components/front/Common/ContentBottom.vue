<template>
    <div class="highlights mt-3">
        <keep-alive>
            <component v-bind:is="currentContentBoth"></component>
        </keep-alive>
        <b-row class="mt-2">
            <keep-alive>
                <component v-bind:is="_currentContentLeft">
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
    </div>
</template>

<script>
    import IconBook from 'v@front/assets/img/icon-book.png';
    import ImgFooter from 'v@front/assets/img/image_footer.jpg';

    export default {
        name: 'ContentBottom',
        components: {
            'content-bottom-both': () => import('./ContentBottomBoth'),
            'column-middle': () => import('com@front/Common/ColumnMiddle'),
            'column-left': () => import('com@front/Common/ColumnLeft'),
            'column-right': () => import('com@front/Common/ColumnRight')
        },
        data() {
            return {
                iconBook: IconBook,
                imgFooter: ImgFooter,
                contentType: 'bottom'
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
            currentContentBoth: function() {
			  	let moduleName = 'bottom-both';
            	return "content-" + moduleName.toLowerCase();
            },
            _currentContentLeft: function () {
                let moduleName = 'left';

                if (this.$route.meta.layout_content.content_bottom_column.left_collumn) {
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
                if (this.$route.meta.layout_content.content_bottom_column.right_collumn) {
                    return "column-" + moduleName.toLowerCase();
                }
                return false;
            },
        }
    }
</script>
