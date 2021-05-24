<template>
    <div id="special-module" v-if="_isExist">
        <h4 class="tit-highlights"><span></span></h4>
        <b-row>
            <b-col cols="12" class="col-mobile">
                <div class="banner-image d-inline-block">
                    <img v-bind:style="{ width: _bannerW + 'px', height: _bannerH + 'px' }"  :src="'/Image/NewPicture/'+settingBanner[0].image" alt="Hình ảnh Phú Cường" class="img">
                </div>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    import {
        mapGetters,
        mapActions
    } from 'vuex';
    import {
        MODULE_MODULE_NOI_BAT
    } from 'store@front/types/module-types';
    import {
        ACTION_GET_SETTING
    } from 'store@front/types/action-types';
    import IconBook from 'v@front/assets/img/icon-book.png';

    export default {
        name: 'ModuleNoiBat',
        data() {
            return {
                fullPage: true,
                iconBook: IconBook,
            }
        },
        computed: {
            ...mapGetters(MODULE_MODULE_NOI_BAT, [
                'settingBanner',
            ]),
            _isExist() {
                return this.settingBanner.length 
            },
            _bannerW() {
                return this.settingBanner[0].width
            },
            _bannerH() {
                return this.settingBanner[0].height;
            }
        },
        methods: {
            ...mapActions(MODULE_MODULE_NOI_BAT, [
                ACTION_GET_SETTING,
            ])
        },
        setting: {
            panel_title: 'Module Danh Mục Icon',
            frm_title: 'Thêm danh mục Icon',
            btn_save_txt: 'Lưu',
        }
    };
</script>

<style lang="scss">
    @import './styles.scss';
</style>