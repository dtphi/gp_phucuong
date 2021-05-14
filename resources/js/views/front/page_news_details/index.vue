<template>
    <main id="news" class="py-2">
        <div class="container">
            <main-menu></main-menu>

            <main-content v-if="_isContentMain">
                <info-data-detail></info-data-detail>
                <div class="mt-4 new-related">
                    <h4 class="tit-common clr-blue mb-3">Tin liên quan</h4>
                    <b-row>
                        <b-col class="col-mobile" cols="4" v-for="(item, index) in 6" :key="index">
                            <a class="d-block" href="#"><img class="img" :src="imgFooter" alt=""></a>
                            <h4 class="tit-bg-common mt-2">
                                <a class="pl-0" href="#">Thông báo: Bế mạc năm thánh mừng kính các thánh tử đạo Việt Nam</a>
                            </h4>
                            <p class="info-post">
                                <b-icon class="alarm" icon="alarm"></b-icon>
                                <span>12/03/2021</span>
                            </p>
                        </b-col>
                    </b-row>
                </div>
                <div class="mt-2 mb-3 new-care">
                    <h4 class="tit-common clr-blue mb-3">Có thể bạn quan tâm</h4>
                    <div class="list-new">
                        <a class="d-block mb-2" href="#" v-for="(item, index) in 10" :key="index">
                            <span><b-icon class="arrow-right-circle-fill" icon="arrow-right-circle-fill"></b-icon></span>
                            <span class="mr-2">Giáo Xứ Rạch Kiến Mừng Đón Giáng Sinh</span>
                            <span><b-icon class="alarm" icon="alarm"></b-icon> 27/12/2019</span>
                        </a>
                    </div>
                </div>
            </main-content>

            <content-bottom v-if="_isContentBottom"></content-bottom>
        </div>
    </main>
</template>

<script>
    import {
        mapGetters,
        mapActions
    } from 'vuex';
    import ImgFooter from 'v@front/assets/img/image_footer.jpg';
    import MainMenu from 'com@front/Common/MainMenu';
    import {
        MODULE_INFO_DETAIL
    } from '@app/stores/front/types/module-types';
    import {
        GET_DETAIL
    } from '@app/stores/front/types/action-types';
    import MainContent from 'com@front/Common/MainContent';
    import ContentBottom from 'com@front/Common/ContentBottom';
    import InfoDataDetail from 'com@front/Common/InfoDetail';

    export default {
        name: 'NewsDetailPage',
        components: {
            MainMenu,
            MainContent,
            ContentBottom,
            InfoDataDetail,
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
            _isContentBottom() {
                return this.$route.meta.layout_content.content_bottom;
            },
            _isContentMain() {
                return this.$route.meta.layout_content.content_main;
            },
        },
        mounted() {
            this.[GET_DETAIL]({
                slug: this.$route.params.slug
            });
        },
        methods: {
            ...mapActions(MODULE_INFO_DETAIL, [
                GET_DETAIL,
            ]),
        }
    }
</script>

<style lang="scss">
    @import './new-detail-styles.scss';
</style>
