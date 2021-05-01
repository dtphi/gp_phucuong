<template>
    <div class="highlights mt-3">
        <h4 class="tit-highlights"><span>Nổi bật</span></h4>

        <b-row>
            <b-col cols="4" class="mb-3 col-mobile">
                <h4 class="tit-common">Sách nói</h4>
                <a href="#" class="row-item-2" v-for="(item, index) in 4" :key="index">
                    <span>Chí khí - đường hi vọng</span>
                    <span>
                        <img :src="iconBook" alt="">
                        <i>Thanh Thúy</i>
                    </span>
                </a>
            </b-col>
            <b-col cols="4" class="mb-3 col-mobile">
                <h4 class="tit-common">Youtube</h4>
                <a href="#" class="row-item-2" v-for="(item, index) in 4" :key="index">
                    <span>Chí khí - đường hi vọng</span>
                    <span>
                        <img :src="iconBook" alt="">
                        <i>Thanh Thúy</i>
                    </span>
                </a>
            </b-col>
            <b-col cols="4" class="mb-3 col-mobile">
                <h4 class="tit-common">Hát thanh vịnh</h4>
                <a href="#" class="row-item-2" v-for="(item, index) in 4" :key="index">
                    <span>Chí khí - đường hi vọng</span>
                    <span>
                        <img :src="iconBook" alt="">
                        <i>Thanh Thúy</i>
                    </span>
                </a>
            </b-col>
        </b-row>
        <b-row class="mt-2">
            <keep-alive>
                <component v-bind:is="currentContentLeft"></component>
            </keep-alive>
            <keep-alive>
				<component v-bind:is="currentContentRight"></component>
			</keep-alive>
        </b-row>
    </div>
</template>

<script>
	import{
      mapState,
      mapActions
  } from 'vuex';

  import {
        MODULE_INFO
    } from '@app/stores/front/types/module-types';
    import {
        GET_DETAIL,
        GET_INFORMATION_LIST_TO_CATEGORY
    } from '@app/stores/front/types/action-types';
    import IconBook from 'v@front/assets/img/icon-book.png';
    import ImgFooter from 'v@front/assets/img/image_footer.jpg';

    export default {
        name: 'ContentBottom',
        components: {
            'content-bottom-left': () => import('./ContentBottomLeft'),
            'content-bottom-right': () => import('./ContentBottomRight'),
        },
        data() {
            return {
                iconBook: IconBook,
                imgFooter: ImgFooter
            }
        },
        computed: {
            ...mapState(MODULE_INFO,{
                infoList: state => state.pageLists
            }),
            currentContentLeft: function() {
			  	let moduleName = 'bottom-left';
            	return "content-" + moduleName.toLowerCase();
            },
            currentContentRight: function() {
			  	let moduleName = 'bottom-right';
            	return "content-" + moduleName.toLowerCase();
            },
        },
        mounted() {
            this.[GET_INFORMATION_LIST_TO_CATEGORY](this.$route.params);
        },
        methods: {
            ...mapActions(MODULE_INFO, [
                GET_DETAIL,GET_INFORMATION_LIST_TO_CATEGORY
            ]),
        }
    }
</script>

<style lang="scss">
</style>