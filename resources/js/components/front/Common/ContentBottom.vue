<template>
    <div class="highlights mt-3">
        
        <keep-alive>
            <component v-bind:is="currentContentBoth"></component>
        </keep-alive>
        <b-row class="mt-2">
            <keep-alive>
                <component v-bind:is="currentContentLeft"></component>
            </keep-alive>
            <keep-alive>
				<component v-bind:is="currentColumnRight"></component>
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
            'content-bottom-left': () => import('./ContentBottomLeft'),
            'content-bottom-right': () => import('./ContentBottomRight'),
            'content-bottom-both': () => import('./ContentBottomBoth'),
            'column-right': () => import('./ColumnRight'),
        },
        data() {
            return {
                iconBook: IconBook,
                imgFooter: ImgFooter
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
            currentColumnRight: function() {
			  	let moduleName = 'right';
            	return "column-" + moduleName.toLowerCase();
            },
        },
        methods: {
        }
    }
</script>

<style lang="scss">
</style>