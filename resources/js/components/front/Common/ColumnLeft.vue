<template>
    <b-col cols="3">
        <side-bar class="aside"></side-bar>
    </b-col>
</template>

<script>
	import{
      mapGetters,
      mapActions
  } from 'vuex';
  import ImgFooter from 'v@front/assets/img/image_footer.jpg';

  import SideBar from 'com@front/SideBar';

  import {
        MODULE_INFO_DETAIL
    } from '@app/stores/front/types/module-types';
    import {
        GET_DETAIL
    } from '@app/stores/front/types/action-types';


    export default {
        name: 'ColumnLeft',
        components: {
            SideBar,
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
            	return "content-" + moduleName.toLowerCase();
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