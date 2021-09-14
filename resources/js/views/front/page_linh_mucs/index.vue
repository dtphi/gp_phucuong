<template>
    <main id="news" class="py-2">
        <div class="container">
            <main-menu></main-menu>
            <div style="background-color: #80808008;" :style="{backgroundColor:contentBgColor}">
                <content-top v-if="_isContentTop">
                    <!-- Loading -->
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
                        <div class="box-care mt-3">
                            <b-row class="mt-3">
                                <b-col cols="12" class="m-auto">
                                    <p class="mb-0 text-download" style="padding: 4px 0">Tải app sách nói công giáo</p>
                                </b-col>
                                <b-col cols="12">
                                    <b-carousel
                                        id="carousel-2"
                                        :interval="4000"
                                        style="cursor: pointer;height:150px"
                                        controls
                                        indicators
                                    >
                                        <b-carousel-slide>
                                                <template v-slot:img>
                                                    <img
                                                        class="d-block img-fluid w-100"
                                                        style="width:100%; height:150px !important"
                                                        :src="imgCarousel">
                                                </template>
                                        </b-carousel-slide>
                                        <b-carousel-slide>
                                            <template v-slot:img>
                                                    <img
                                                        class="d-block img-fluid w-100"
                                                        style="width:100%; height:150px !important"
                                                        :src="imgCarousel">
                                                </template>
                                        </b-carousel-slide>
                                    </b-carousel>
                                </b-col>
                            </b-row>
                        </div>
                    </template>
                </content-top>
                <main-content v-if="_isContentMain">
                    <template v-slot:before>
                        <!-- Html linh mục detail -->												
                        <div class="list-danh-muc w-100">
                            <h2 class="title-linh-muc text-center">Danh sách linh mục đoàn giáo phận phú cường <hr class="line-linh-muc"></h2>
                            <div class="tab-linh-muc w-100">												
                                <b-tabs content-class="mt-3" fill>
                                    <b-tab title="Tất cả" active>
                                        <div class="list-linh-muc">
                                            <!-- Load danh sach linh muc -->
												<div v-for="(info,idx) in pageLists" :key="idx" class="row row-linh-muc">
                                                <div class="col-mobile col-2">
                                                    <a class="avatar" :href="`/linh-muc/chi-tiet/${info.id}`">
                                                        <img class="img" :src="`${info.image}`" alt="Hình ảnh đại diện">
                                                    </a>
                                                </div>
                                                <div class="col-mobile col-10 content">
                                                    <h4 class="tit">
                                                        Linh mục {{info.ten_thanh}} <a :href="`/linh-muc/chi-tiet/${info.id}`">{{info.ten}}</a>
                                                    </h4>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <span>Chức vụ: {{info.chuc_vu}}</span>       
															<span>Nơi phục vụ: Gx. {{info.giao_xu}}</span>   
															<span>Giáo hạt: {{info.giao_hat}}</span>                                                     
                                                        </div>
                                                        <div class="col-6">
                                                            <span>Năm sinh: {{info.nam_sinh}}</span>
                                                            <span>Chịu chức: {{info.ngay_nhan_chuc}}</span>  
															<span>Địa chỉ: {{info.dia_chi}}</span>                                                
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>																						
                                        </div>
										<paginate :is-resource="isResource" v-if="pageLists"></paginate>
                                    </b-tab>																																				
                                    <b-tab title="Lọc theo chức vụ / Giáo hạt">
                                        <p>Đang cập nhật</p>
                                    </b-tab>
																		
                                </b-tabs>																											
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
        MODULE_LINH_MUC_PAGE
    } from '@app/stores/front/types/module-types';
    import {
        GET_LISTS_LINH_MUC
    } from '@app/stores/front/types/action-types';
    import MainMenu from 'com@front/Common/MainMenu';
    import ContentTop from 'com@front/Common/ContentTop';
    import ContentBottom from 'com@front/Common/ContentBottom';
    import SocialNetwork from 'com@front/Common/SocialNetwork'; 
    import TabInfoViewedAndPopular from 'com@front/Common/TabInfoViewedAndPopular';
    import NewsletterRegister from 'com@front/Common/NewsletterRegister';
    import MainContent from 'com@front/Common/MainContent';
    import ModulePageBannerList from 'v@front/modules/page_banner_lists';
		import Paginate from 'com@front/Pagination';
		

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
            ModulePageBannerList,
						Paginate
        },
        data() {
            return {
                isContentBottom: true,
                fullPage: true,
                isTopBottomBoth: false,
                imgCarousel: 'https://picsum.photos/1024/480/?image=58',
								isResource: false,
            }
        },
        computed: {
            ...mapState({
                contentBgColor: state => state.cfApp.setting.contentBgColor,
            }),
            ...mapState(MODULE_LINH_MUC_PAGE, {
                pageLists: state => state.pageLists,
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
            this.[GET_LISTS_LINH_MUC](this.$route.params);
        },
        methods: {
            ...mapActions(MODULE_LINH_MUC_PAGE, [
                GET_LISTS_LINH_MUC,
            ]),
        }
    }
</script>

<style lang="scss">
    @import './styles.scss';
</style>
