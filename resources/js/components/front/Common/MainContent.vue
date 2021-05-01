<template>
    <b-row class="my-3">
        <keep-alive>
            <component v-bind:is="currentContentLeft"></component>
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
        MODULE_INFO_DETAIL
    } from '@app/stores/front/types/module-types';
    import {
        GET_DETAIL
    } from '@app/stores/front/types/action-types';


    export default {
        name: 'MainContent',
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
            ...mapGetters(MODULE_INFO_DETAIL, [
                'pageLists'
            ]),
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
                      return "content-" + moduleName.toLowerCase();
                  }
            	return false;
            },
        },
        methods: {
            ...mapActions(MODULE_INFO_DETAIL, [
                GET_DETAIL,
            ]),
        }
    }
</script>

<style lang="scss">
</style>