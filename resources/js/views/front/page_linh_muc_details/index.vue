<template>
    <main id="news" class="py-2">
        <div class="container">
            <main-menu></main-menu>
            <div style="background-color: #80808008;">
            <content-top v-if="_isContentTop">
                <template v-if="loading">
                    <loading-over-lay
                        :active.sync="loading"
                        :is-full-page="fullPage"></loading-over-lay>
                </template>
                <template v-slot:column_right>
                    <social-network></social-network>
                    <div class="box-social">
                        <tab-info-viewed-and-popular></tab-info-viewed-and-popular>
                    </div>
                </template>
            </content-top>
            <main-content v-if="_isContentMain">
                <template v-slot:before>
                    <!-- Html linh mục detail -->
                    <div class="header-linh-muc w-100">
                        <span class="d-block line-header"></span>
                        <div class="box-header">
                            <div class="row">
                                <div class="col-mobile col-3">
                                    <span class="d-block img-header">
                                        <img class="img rounded-circle" :src="`${pageLists.image}`" alt="">
                                    </span>
                                </div>
                                <div class="col-mobile col-9 text-center text-header">
                                    <h2>Trang thông tin linh mục</h2>
                                    <h5>Giáo phận phú cường</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="detail-linh-muc w-100 mt-3">
                        <div class="row">
                            <div class="col-mobile col-3">
                                <div class="row">
                                    <p class="col-4 text-uppercase">Linh mục</p>
                                    <div class="col-8">
                                        <p style="font-size: 20px; margin-bottom: 0.1rem;" class="text-uppercase">{{pageLists.ten_thanh}}</p>																				
                                        <p style="font-weight: bold;font-size: 20px; margin-bottom: 0.1rem;" class="text-uppercase">{{pageLists.ten}}</p>
                                        <p>{{pageLists.cv_hien_tai}}</p>
                                    </div>
                                </div>

                                <div class="bi-tich p-4 mt-3">
                                    <h4 class="text-uppercase text-white text-center mb-3">Bí tích</h4>
                                    <a class="d-block text-white" href="#">Bí tích Rửa Tội</a>
                                    <p class="d-block text-white">{{_formatDate(pageLists.ngay_rua_toi)}}</p>
                                    <a class="d-block text-white" href="#">Bí tích Thêm sức </a>
                                    <p class="d-block text-white">{{_formatDate(pageLists.ngay_them_suc)}}</p>
                                    <a class="d-block text-white" href="#">Bí tích Truyền Chức </a>
									<p
                                        v-for="value in pageLists.ds_chuc_thanh" 
                                        :key="value.chuc_thanh_id + '_ct'" 
                                        class="d-block text-white">{{value.chuc_thanh_id+'.'+chucThanh[value.chuc_thanh_id]}} : {{_formatDate(value.ngay_thang_nam_chuc_thanh)}}</p>	
                                        															
                                </div>
                            </div>
                            <div class="col-mobile col-9">
                                <span class="d-block avatar-img mt-3">
                                    <img class="img" :src="`${pageLists.image}`" alt="">
                                </span>
                                <div class="info-personal mt-5">
                                    <h4 class="text-uppercase">Thông tin cá nhân</h4>
                                    <p class="row">
                                        <span class="col-mobile col-4">Ngày sinh: {{_formatDate(pageLists.nam_sinh)}}</span>
                                        <span class="col-mobile col-4">Tại: {{pageLists.dia_chi}} </span>
                                    </p>
                                    <p class="row">
                                        <span class="col-mobile col-4">Giáo xứ: {{pageLists.giao_xu}}</span>
                                        <span class="col-mobile col-4">Giáo phận: {{pageLists.giao_phan}}</span>
                                    </p>
                                    <p>Tên cha: {{pageLists.ho_ten_cha}}</p>
                                    <p>Tên mẹ: {{pageLists.ho_ten_me}}</p>
                                    <p>CMND: {{pageLists.so_cmnd}}</p>
                                    <p class="row">
                                        <span class="col-mobile col-4">Ngày cấp: {{pageLists.ngay_cap_cmnd}}</span>
                                        <span class="col-mobile col-4">Nơi cấp: {{pageLists.noi_cap_cmnd}}</span>
                                    </p>
                                </div>

                                <div class="maxim text-center">
                                    <h4 class="tit-maxim">Châm ngôn đời linh mục</h4>
                                </div>
																<div>
																	<h3>HOẠT ĐỘNG SỨ VỤ</h3>														
                                 		<h4 v-for="(value, idx) in pageLists.ds_chuc_vu" :key="idx" class="d-block text-black">{{idx + 1}}. {{value.chucvu_name}} ({{_formatDate(value.from_date)}}&nbsp; - &nbsp;{{value.to_date?_formatDate(value.to_date):"Chưa cập nhật"}})</h4>                        																				
																</div>																
                            </div>
                        </div>
                    </div>
                </template>
            </main-content>
            <content-bottom v-if="_isContentBottom">
            </content-bottom>
            </div>
        </div>
    </main>
</template>

<script>
    import {
        mapState,
        mapActions
    } from 'vuex';
    import {
        MODULE_LINH_MUC_DETAIL_PAGE
    } from '@app/stores/front/types/module-types'; 
    import {
        GET_DETAIL_LINH_MUC
    } from '@app/stores/front/types/action-types';
    import MainMenu from 'com@front/Common/MainMenu';
    import ContentTop from 'com@front/Common/ContentTop';
    import ContentBottom from 'com@front/Common/ContentBottom';
    import SocialNetwork from 'com@front/Common/SocialNetwork';
    import TabInfoViewedAndPopular from 'com@front/Common/TabInfoViewedAndPopular';
    import NewsletterRegister from 'com@front/Common/NewsletterRegister';
    import MainContent from 'com@front/Common/MainContent';
    import ModulePageBannerList from 'v@front/modules/page_banner_lists';
		import {
			fn_format_dd_mm_yyyy,
		} from '@app/api/utils/fn-helper';

    export default {
        name: 'InfoPage',
        components: {
            MainMenu,
            TabInfoViewedAndPopular,
            ContentTop,
            ContentBottom,
            SocialNetwork,
            NewsletterRegister,
            MainContent,
            ModulePageBannerList
        },
        data() {
            return {
                isContentBottom: true,
                fullPage: false,
                isTopBottomBoth: false,
                imgCarousel: 'https://picsum.photos/1024/480/?image=58',
                chucThanh: ['','Phó Tế', 'Linh Mục', 'Giám Mục']
            }
        },
        computed: {
            ...mapState(MODULE_LINH_MUC_DETAIL_PAGE, {
                pageLists: (state) => {
									return state.pageLists;
								},
                loading: state => state.loading
            }),
            _isContentTop() {
                return this.$route.meta.layout_content.content_top;
            },
            _isContentBottom() {
                return this.$route.meta.layout_content.content_bottom;
            },
            _isContentMain() {
                return this.$route.meta.layout_content.content_main;
            },
        },
         mounted() {
            this.[GET_DETAIL_LINH_MUC](this.$route.params);			
						
        },
        methods: {
            ...mapActions(MODULE_LINH_MUC_DETAIL_PAGE, [
                GET_DETAIL_LINH_MUC,
            ]),
            _formatDate(date) {
                    return fn_format_dd_mm_yyyy(date);		
            }
        }
    }
</script>

<style lang="scss">
    @import './styles.scss';
</style>
