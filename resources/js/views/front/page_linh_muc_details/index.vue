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
                    <div class="col-mobile col-12">
                        <div class="header-linh-muc w-100">
                            <span class="d-block line-header"></span>
                            <div class="box-header">
                                <div class="row">
                                    <div class="col-mobile col-3">
                                        <span class="d-block img-header">
                                            <img class="img rounded-circle" v-lazy="`${pageLists.image}`" :alt="pageLists.ten">
                                        </span>
                                    </div>
                                    <div class="col-mobile col-9 text-center text-header">
                                        <h2>Trang thông tin linh mục</h2>
                                        <h5>Giáo phận phú cường</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-mobile col-12">
                        <div class="detail-linh-muc w-100 mt-3">
                            <div class="row">
                                <div class="col-mobile col-4">
                                    <div class="row">
                                        <p class="col-4 text-uppercase">Linh mục</p>
                                        <div class="col-8">
                                            <p style="font-size: 20px; margin-bottom: 0.1rem;" class="text-uppercase">{{pageLists.ten_thanh}}</p>																				
                                            <p style="font-weight: bold;font-size: 16px; margin-bottom: 0.1rem;" class="text-uppercase">{{pageLists.ten}}</p>
                                            <p>{{pageLists.cv_hien_tai}}</p>
                                        </div>
                                    </div>

                                    <div class="bi-tich p-3 mt-3">
                                        <h4 class="text-uppercase text-white text-center mb-3">Bí tích</h4>
                                        <a style="font-size: 25px;" class="d-block text-white" href="javascript:void(0);">Bí tích Rửa Tội</a>
                                        <p style="margin-bottom: 2rem;font-size: 20px;" class="d-block text-white">{{_formatDate(pageLists.ngay_rua_toi)}}</p>
                                        <a style="font-size: 25px;" class="d-block text-white" href="javascript:void(0);">Bí tích Thêm sức </a>
                                        <p style="margin-bottom: 2rem;font-size: 20px;" class="d-block text-white">{{_formatDate(pageLists.ngay_them_suc)}}</p>
                                        <a style="font-size: 25px;" class="d-block text-white" href="javascript:void(0);">Bí tích Truyền Chức </a>
                                        <p style="margin-bottom: 2rem;font-size: 20px;"
                                            v-for="(value,idx) in pageLists.ds_chuc_thanh" 
                                            :key="value.chuc_thanh_id + '_ct'" 
                                            class="d-block text-white">{{(idx+1)+'. '+chucThanh[value.chuc_thanh_id]}}</p>	
                                                                                                        
                                    </div>
                                </div>
                                <div class="col-mobile col-8">
                                    <span class="d-block avatar-img mt-3">
                                        <img class="img" v-lazy="`${pageLists.image}`" :alt="pageLists.ten">
                                    </span>
                                    <div class="info-personal mt-5" style="font-size:0.87rem">
                                        <h4 class="text-uppercase">Thông tin cá nhân</h4>
                                        <p style="margin-bottom: 0.3rem;" class="row">
                                            <span class="col-mobile col-5">
                                                <label class="doted-bottom" style="position: absolute; left: 97px; top: 0px; font-weight: 400;">..................................</label>
                                                <label class="doted-xs-bottom" style="position: absolute;left: 97px;top: 0px;font-weight: 400;">...............................................</label>
                                                Ngày sinh: <label style="position: absolute;top: -3px;padding-left: 10px;font-style: italic;">{{_formatDate(pageLists.nam_sinh)}}</label></span>
                                            <span class="col-mobile col-6">
                                                <label class="doted-bottom" style="position: absolute; left: 39px; top: 0px; font-weight: 400;">...............................................</label>
                                                <label class="doted-xs-bottom" style="position: absolute;left: 41px;top: 0px;font-weight: 400;">............................................................</label>
                                                tại: <label style="position: absolute;top: -3px;padding-left: 10px;font-style: italic;">{{pageLists.dia_chi}}</label>
                                            </span>
                                        </p>
                                        <p style="margin-bottom: 0.3rem;" class="row">
                                            <span class="col-mobile col-5">
                                                <label class="doted-bottom" style="position: absolute; left: 80px; top: 0px; font-weight: 400;">......................................</label>
                                                <label class="doted-xs-bottom" style="position: absolute;left: 80px;top: 0px;font-weight: 400;">...................................................</label>
                                                Giáo xứ: <label style="position: absolute;top: -3px;padding-left: 10px;font-style: italic;">{{pageLists.giao_xu}}</label>
                                            </span>
                                            <span class="col-mobile col-6">
                                                <label class="doted-bottom" style="position: absolute; left: 100px; top: 0px; font-weight: 400;">.................................</label>
                                                <label class="doted-xs-bottom" style="position: absolute;left: 99px;top: 0px;font-weight: 400;">...............................................</label>
                                                Giáo phận: <label style="position: absolute;top: -3px;padding-left: 10px;font-style: italic;">{{pageLists.giao_phan}}</label>
                                            </span>
                                        </p>
                                        <p style="margin-bottom: 0.3rem;" class="row">
                                            <span class="col-mobile col-11">
                                                <label class="doted-bottom" style="position: absolute; left: 82px; top: 0px; font-weight: 400;">..........................................................................................................</label>
                                                <label class="doted-xs-bottom" style="position: absolute;left: 82px;top: 0px;font-weight: 400;">...................................................</label>
                                                Tên cha: <label style="position: absolute;top: -3px;padding-left: 10px;font-style: italic;">{{pageLists.ho_ten_cha}}</label>
                                            </span>    
                                        </p>
                                        <p style="margin-bottom: 0.3rem;" class="row">
                                            <span class="col-mobile col-11">
                                                <label class="doted-bottom" style="position: absolute; left: 78px; top: 0px; font-weight: 400;">...........................................................................................................</label>
                                                <label class="doted-xs-bottom" style="position: absolute;left: 78px;top: 0px;font-weight: 400;">....................................................</label>
                                                Tên mẹ: <label style="position: absolute;top: -3px;padding-left: 10px;font-style: italic;">{{pageLists.ho_ten_me}}</label>
                                            </span>    
                                        </p>
                                        <p style="margin-bottom: 0.3rem;" class="row">
                                            <span class="col-mobile col-11">
                                                <label class="doted-bottom" style="position: absolute; left: 71px; top: 0px; font-weight: 400;">.............................................................................................................</label>
                                                <label class="doted-xs-bottom" style="position: absolute;left: 71px;top: 0px;font-weight: 400;">.....................................................</label>
                                                CMND: <label style="position: absolute;top: -3px;padding-left: 10px;font-style: italic;">{{pageLists.so_cmnd}}</label>
                                            </span>    
                                        </p>
                                        <p style="margin-bottom: 0.3rem;" class="row">
                                            <span class="col-mobile col-5">
                                                <label class="doted-bottom" style="position: absolute; left: 94px; top: 0px; font-weight: 400;">...................................</label>
                                                <label class="doted-xs-bottom" style="position: absolute;left: 93px;top: 0px;font-weight: 400;">................................................</label>
                                                Ngày cấp: <label style="position: absolute;top: -3px;padding-left: 10px;font-style: italic;">{{_formatDate(pageLists.ngay_cap_cmnd)}}</label>
                                            </span>
                                            <span class="col-mobile col-6">
                                                <label class="doted-bottom" style="position: absolute; left: 80px; top: 0px; font-weight: 400;">......................................</label>
                                                <label class="doted-xs-bottom" style="position: absolute;left: 80px;top: 0px;font-weight: 400;">...................................................</label>
                                                Nơi cấp: <label style="position: absolute;top: -3px;padding-left: 10px;font-style: italic;">{{pageLists.noi_cap_cmnd}}</label>
                                            </span>
                                        </p>
                                    </div>															
                                </div>
                                <div class="col-mobile col-12">
                                    <div class="maxim text-center">
                                        <h4 class="tit-maxim">Châm ngôn đời linh mục</h4>
                                    </div>
                                    <div>
                                        <h3>HOẠT ĐỘNG SỨ VỤ</h3>
                                        <simple-timeline
                                            :items="_itemChucVus(pageLists.ds_chuc_vu)" 
                                            dateFormat="DD/MM/YY" 
                                            v-on="$listeners"></simple-timeline>                       																				
                                    </div>	
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

    import Vue from "vue";
    import { SimpleTimelinePlugin } from 'simple-vue-timeline';
    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'; 
    Vue.use(SimpleTimelinePlugin);
    Vue.component('font-awesome-icon', FontAwesomeIcon);
    import { Item, Status } from "simple-vue-timeline";
    import 'simple-vue-timeline/dist/simple-vue-timeline.css';
    import { BadgePlugin, ButtonPlugin, CardPlugin } from 'bootstrap-vue';

    Vue.use(BadgePlugin);
    Vue.use(ButtonPlugin);
    Vue.use(CardPlugin);

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
                chucThanh: ['','Phó Tế', 'Linh Mục', 'Giám Mục'],
                chucVus: []
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
            }
        },
         mounted() {
            this.getDetail(this.$route.params);			
						
        },
        methods: {
            ...mapActions(MODULE_LINH_MUC_DETAIL_PAGE, {
                'getDetail':GET_DETAIL_LINH_MUC,
            }),
            _formatDate(date) {
                    return fn_format_dd_mm_yyyy(date);		
            },
            _itemChucVus(chucVus) {
                const self  = this;
                if (self.chucVus.length)
                    return self.chucVus;
                if (chucVus && chucVus.length) {
                    //Status.WARNING = 'rgba(0, 0, 0, 0.125)';
                    chucVus.forEach(function(item, idx) {
                        var fromDate = fn_format_dd_mm_yyyy(item.from_date)?fn_format_dd_mm_yyyy(item.from_date):'';
                        var toDate = fn_format_dd_mm_yyyy(item.to_date)?(' đến ngày ' + fn_format_dd_mm_yyyy(item.to_date)): '';
                        self.chucVus.push(new Item(
                            idx,
                            "edit",
                            Status.DANGER,
                            item.chucvu_name,
                            [],
                            (item.from_date)?new Date(item.from_date):'',
                            'Từ ngày ' + fromDate + toDate
                            ));
                    });
                }
                return self.chucVus;
            }
        }
    }
</script>

<style lang="scss">
    @import './styles.scss';
</style>
