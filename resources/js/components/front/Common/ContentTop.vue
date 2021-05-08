<template>
    <b-row class="my-3">

        <keep-alive>
            <component v-bind:is="currentContentLeft"></component>
        </keep-alive>

        <keep-alive>
            <component v-bind:is="currentContentMiddle">
                <slot></slot>
            </component>
        </keep-alive>

        <keep-alive>
            <component v-bind:is="currentContentRight"></component>
        </keep-alive>
    </b-row>
</template>

<script>
	import{
      mapGetters,
      mapActions
  } from 'vuex';
  import ImgFooter from 'v@front/assets/img/image_footer.jpg';

  import {
    } from '@app/stores/front/types/module-types';
    import {
    } from '@app/stores/front/types/action-types';


    export default {
        name: 'ContentTop',
        components: {
            'content-bottom-right': () => import('com@front/Common/ContentBottomRight'),
            'column-middle': () => import('com@front/Common/ColumnMiddle'),
            'column-left': () => import('com@front/Common/ColumnLeft')
        },
        data() {
            return {
                imgFooter: ImgFooter
            }
        },
        computed: {
            currentContentRight: function() {
			  	let moduleName = 'bottom-right';
                  if (this.$route.meta.layout_content.right_collumn) {
                      return "content-" + moduleName.toLowerCase();
                  }
            	return false;
            },
            currentContentLeft: function() {
			  	let moduleName = 'left';
            	
                if (this.$route.meta.layout_content.left_collumn) {
                      return "column-" + moduleName.toLowerCase();
                  }
            	return false;
            },
            currentContentMiddle: function() {
			  	let moduleName = 'middle';
            	
                if (this.$route.meta.layout_content.middle_column) {
                      return "column-" + moduleName.toLowerCase();
                  }
            	return false;
            },
        },
        methods: {
        }
    }
</script>

<style lang="scss">
</style>