<template>
    <b-row id="content-main" class="my-3">
        <slot name="before"></slot>
        <keep-alive>
            <component v-bind:is="_currentContentBoth" class="col-mobile col-12"></component>
        </keep-alive>
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
</template>

<script>
    import ImgFooter from 'v@front/assets/img/image_footer.jpg';

    export default {
        name: 'MainContent',
        components: {
            'content-bottom-both': () => import('./ContentBottomBoth'),
            'column-right': () => import('com@front/Common/ColumnRight'),
            'column-middle': () => import('com@front/Common/ColumnMiddle'),
            'column-left': () => import('com@front/Common/ColumnLeft')
        },
        data() {
            return {
                imgFooter: ImgFooter,
                contentType: 'main'
            }
        },
        computed: {
            _currentContentBoth: function() {
			  	let moduleName = 'bottom-both';
            	return "content-" + moduleName.toLowerCase();
            },
            _currentContentRight: function () {
                let moduleName = 'right';
                if (this.$route.meta.layout_content.content_main_column.right_collumn) {
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

                if (this.$route.meta.layout_content.content_main_column.left_collumn) {
                    return "column-" + moduleName.toLowerCase();
                }
                return false;
            },
        },
        methods: {
        }
    }
</script>
