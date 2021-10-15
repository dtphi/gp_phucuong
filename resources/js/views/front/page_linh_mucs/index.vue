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
                    </template>
                </content-top>
                <main-content v-if="_isContentMain">
                    <!--<template v-slot:before_column_both>
                        <div class="col-mobile col-12">
                            <module-page-banner-list></module-page-banner-list>
                        </div>
                    </template>-->
                    <template v-slot:bottom>
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
                                                       <a :href="`/linh-muc/chi-tiet/${info.id}`"> Linh mục {{info.ten_thanh}} {{info.ten}}</a>
                                                    </h4>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <span>Chức vụ: {{info.chuc_vu}}</span>       
															<a :href="info.href_giaoxu">
																<span>Nơi phục vụ: Gx. {{info.giao_xu}} </span>
															</a>
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
                                        <div class="col-mobile col-12">
                                            <div class="col-mobile col-3">
                                                <p>Chức vụ: </p>
                                                <!-- string value -->
                                                <model-select 
                                                    key='chuc_vu'
                                                    :options="options2"
                                                    v-model="item2"
                                                    placeholder="select item2"></model-select>
                                            </div>
                                            <div class="col-mobile col-3">
                                                <p>Giáo hạt: </p>
                                                <!-- string value -->
                                                <model-select 
                                                    key='giao_hat'
                                                    :options="options3"
                                                    v-model="item3"
                                                    placeholder="select item2"></model-select>
                                            </div>
                                        </div>
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

    import 'vue-search-select/dist/VueSearchSelect.css'
    import { ModelSelect } from 'vue-search-select';
		

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
			Paginate,
            ModelSelect,
        },
        data() {
            return {
                isContentBottom: true,
                fullPage: true,
                isTopBottomBoth: false,
                imgCarousel: 'https://picsum.photos/1024/480/?image=58',
				isResource: false,
                options2: [
                    { value: '1', text: 'Chức vụ' + ' - ' + '1' },
                    { value: '2', text: 'Chức vụ' + ' - ' + '2' }
                ],
                item2: '',
                options3: [
                    { value: '1', text: 'Giáo hạt' + ' - ' + '1' },
                    { value: '2', text: 'Giáo hạt' + ' - ' + '2' }
                ],
                item3: ''
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
            this.getList(this.$route.params);
        },
        methods: {
            ...mapActions(MODULE_LINH_MUC_PAGE, {
                'getList':GET_LISTS_LINH_MUC,
            }),
        }
    }
</script>

<style lang="scss">
    @import './styles.scss';
</style>
