<template>
    <b-col cols="3">
        <aside>
            <slot></slot>
            <info-left-side-bar></info-left-side-bar>
            <module-category-menu-left></module-category-menu-left>
            <hr class="border my-3">
            <div class="form">
                <p class="font-weight-bold txt">Đăng ký để nhận tin mỗi ngày</p>
                <div class="input">
                    <input class="d-block mb-3" type="email" name="email" id="email" placeholder="Enter your e-mail address">
                    <input class="btn" type="button" value="Subscribe">
                </div>
            </div>
            <hr class="border my-4">
            <div class="logo">
                <p class="mb-4">
                    <img src="../../../views/front/assets/img/logo.png" alt="Logo Phú Cường"></p>
                <h4 class="title mb-3">Giáo Phận Phú Cường</h4>
                <p class="mb-0">Ban Truyền Thông Giáo Phận</p>
                <p>104 Lạc Long Quân, Phường Phú Cường, Tp. Thủ Dầu Một, Tỉnh Bình Dương</p>
                <p class="mb-0">+84 274 730 7788</p>
                <p class="mb-0">giaophanphucuong@gmail.com</p>
            </div>
        </aside>
    </b-col>
</template>

<script>
	import{
      mapGetters,
      mapActions
  } from 'vuex';
  import ImgFooter from 'v@front/assets/img/image_footer.jpg';
  import InfoLeftSideBar from '../SideBar/SideBarInfoLeft';
  import ModuleCategoryMenuLeft from 'v@front/modules/category_left_side_bars';

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
            InfoLeftSideBar,
            ModuleCategoryMenuLeft,
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
    @import './left-column-styles.scss';
</style>
