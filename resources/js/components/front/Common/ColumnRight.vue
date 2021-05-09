<template>
    <b-col cols="4" class="col-mobile">
        <module-category-icon-side-bar>
            
        </module-category-icon-side-bar>

        <module-thong-bao></module-thong-bao>

        <module-lich-cong-giao></module-lich-cong-giao>

        <div class="fanpage mt-4">
            <h4 class="tit-common clr-orange">fanpage</h4>
            <div class="fb-page fb_iframe_widget" data-href="https://www.facebook.com/truyenthongphucuong/" data-tabs="timeline, messages" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" fb-xfbml-state="rendered">
                <iframe width="350px" height="500px" data-testid="fb:page Facebook Social Plugin" title="fb:page Facebook Social Plugin" frameborder="0" allowtransparency="true" allowfullscreen="true" scrolling="no" allow="encrypted-media" src="https://www.facebook.com/v5.0/plugins/page.php?adapt_container_width=true&amp;app_id=210446675691863&amp;channel=https%3A%2F%2Fstaticxx.facebook.com%2Fx%2Fconnect%2Fxd_arbiter%2F%3Fversion%3D46%23cb%3Df2eb147e0af6c64%26domain%3Dgiaophanphucuong.org%26origin%3Dhttps%253A%252F%252Fgiaophanphucuong.org%252Ff46cb85af4ed18%26relation%3Dparent.parent&amp;container_width=330&amp;hide_cover=false&amp;href=https%3A%2F%2Fwww.facebook.com%2Ftruyenthongphucuong%2F&amp;locale=vi_VN&amp;sdk=joey&amp;show_facepile=true&amp;small_header=true&amp;tabs=timeline%2C%20messages&amp;width=330"></iframe>
            </div>
        </div>

        <div class="mt-4">
            <h4 class="tit-common clr-orange">Hạnh các thánh</h4>
            <div id="Hanhcacthanh-PlaylistYoutube" class="embed-responsive embed-responsive-4by3">
                <iframe allowfullscreen="" class="embed-responsive-item" frameborder="0" height="360" src="https://www.youtube-nocookie.com/embed/videoseries?list=PL-uyh2tqni7nLxdHqWjTbLyIoJEriY7lM" width="640"></iframe>
            </div>
        </div>
    </b-col>
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
    import ModuleCategoryIconSideBar from 'v@front/modules/category_icon_side_bars';
    import ModuleThongBao from 'v@front/modules/thong_baos';
    import ModuleLichCongGiao from 'v@front/modules/lich_cong_giaos';

    export default {
        name: 'ContentBottomRight',
        components: {
            ModuleCategoryIconSideBar,
            ModuleThongBao,
            ModuleLichCongGiao
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