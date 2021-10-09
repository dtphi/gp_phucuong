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
                <template v-slot:before_column_both>
                    <div class="col-mobile col-12">
                        <module-page-banner-list></module-page-banner-list>
                    </div>
                </template>
                <template v-slot:column_middle v-if="info">
                    <img style="width:100%; margin-bottom:15px" v-lazy="info.image"/>
                    <!-- Latest update -->
                    <vue-timeline-update
                        :date="new Date()"
                        dateString="Giáo dân"
                        :category="info.so_tin_huu"
                        :title="info.name"
                        :description="info.dan_so"
                        icon="home"
                        color="red"
                    />
                    <vue-timeline-update
                        :date="new Date()"
                        dateString="Giờ cử hành thánh lễ"
                        category="Giờ lễ trong tuần"
                        :title="info.name"
                        :description="info.gio_le"
                        icon="home"
                        color="red"
                    />
                    <vue-timeline-update
                        :date="new Date()"
                        dateString="Địa chỉ"
                        category="Địa chỉ giáo xứ"
                        :title="info.name"
                        :description="info.dia_chi"
                        icon="home"
                        color="red"
                    />
                    <vue-timeline-update
                        :date="new Date()"
                        dateString="Điện thoại"
                        :category="info.dien_thoai"
                        :title="info.name"
                        description="Số điện thoại liên hệ"
                        icon="home"
                        color="red"
                    />
                    <vue-timeline-update
                        :date="new Date()"
                        dateString="E-mail"
                        category="E-mail liện hệ"
                        :title="info.name"
                        :description="info.email"
                        icon="home"
                        color="red"
                    />
                    <vue-timeline-update
                        :date="new Date()"
                        dateString="Linh mục"
                        category="Các linh mục tiền nhiệm"
                        :title="info.name"
                        description="Chưa cập nhật"
                        icon="home"
                        color="red"
                    />
                    <div style="margin-top:15px" v-html="info.noi_dung"></div>
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
        MODULE_GIAO_XU_DETAIL_PAGE
    } from '@app/stores/front/types/module-types'; 
    import {
        GET_DETAIL
    } from '@app/stores/front/types/action-types';
    import MainMenu from 'com@front/Common/MainMenu';
    import ContentTop from 'com@front/Common/ContentTop';
    import ContentBottom from 'com@front/Common/ContentBottom';
    import SocialNetwork from 'com@front/Common/SocialNetwork';
    import TabInfoViewedAndPopular from 'com@front/Common/TabInfoViewedAndPopular';
    import NewsletterRegister from 'com@front/Common/NewsletterRegister';
    import MainContent from 'com@front/Common/MainContent';
    import ModulePageBannerList from 'v@front/modules/page_banner_lists';
    import Vue from "vue"
    import vuetimeline from "@growthbunker/vuetimeline"
    Vue.use(vuetimeline)

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
                imgCarousel: 'https://picsum.photos/1024/480/?image=58'
            }
        },
        computed: {
            ...mapState(MODULE_GIAO_XU_DETAIL_PAGE, {
                info: state => state.pageLists.results,
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
            this.getDetail(this.$route.params);
        },
        methods: {
            ...mapActions(MODULE_GIAO_XU_DETAIL_PAGE, {
                'getDetail':GET_DETAIL,
            }),
        }
    }
</script>

<style lang="scss">
    @import './styles.scss';
</style>
