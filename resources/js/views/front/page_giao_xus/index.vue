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
                    <template v-slot:before_column_both>
                        <div class="col-mobile col-12">
                            <module-page-banner-list></module-page-banner-list>
                        </div>
                    </template>
                    <template v-slot:bottom>
                        <div class="list-danh-muc w-100">
                            <h2 class="title-linh-muc text-center">Danh sách giáo xứ giáo phận phú cường <hr class="line-linh-muc"></h2>
                            <div class="tab-linh-muc w-100">
                                <b-tabs content-class="mt-3" fill>
                                    <b-tab title="Tất cả" active>
                                        <div class="list-giao-xu">
                                            <div v-for="(info,idx) in infoList" :key="idx" class="row row-linh-muc">
                                                <div class="col-mobile col-2">
                                                    <a class="avatar" :href="info.hrefDetail">
                                                        <img class="img" v-lazy="info.image" :alt="info.name">
                                                    </a>
                                                </div>
                                                <div class="col-mobile col-10 content">
                                                    <h4 class="tit">
                                                       <a :href="info.hrefDetail"> Giáo Xứ {{info.name}}</a>
                                                    </h4>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <span>Giờ lễ: <span v-html="info.gio_le"></span></span>
                                                            <span>Địa chỉ: {{info.dia_chi}}</span>
                                                            <span>Email: {{info.email}}</span>
                                                        </div>
                                                        <div class="col-6">
                                                            <span>Điện thoại: {{info.dien_thoai}}</span>
                                                            <span>Dân số: {{info.dan_so}}</span>
                                                            <span>Số tín hữu: {{info.so_tin_huu}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <paginate :is-resource="isResource" v-if="infoList"></paginate>
                                    </b-tab>
                                    <b-tab title="Lọc theo Giáo phận / Giáo hạt">
                                        <div class="list-giao-xu">
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
        MODULE_GIAO_XU_PAGE 
    } from '@app/stores/front/types/module-types';
    import {
        GET_LISTS
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
        name: 'GiaoXuPage',
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
                isContentBottom: false,
                fullPage: false,
                isTopBottomBoth: false,
                imgCarousel: 'https://picsum.photos/1024/480/?image=58',
                isResource: false,
            }
        },
        computed: {
            ...mapState({
                contentBgColor: state => state.cfApp.setting.contentBgColor,
            }),
            ...mapState(MODULE_GIAO_XU_PAGE, {
                infoList: state => state.pageLists,
                loading: state => state.loading
            }),
            _isContentTop() {
                return this.$route.meta.layout_content.content_top;
            },
            _isContentBottom() {
                return false;//this.$route.meta.layout_content.content_bottom;
            },
            _isContentMain() {
                return this.$route.meta.layout_content.content_main;
            },
        },
         mounted() {
            this.getList(this.$route.params);
        },
        methods: {
            ...mapActions(MODULE_GIAO_XU_PAGE, {
                'getList':GET_LISTS,
            }),
        }
    }
</script>

<style lang="scss">
    @import './styles.scss';
</style>
