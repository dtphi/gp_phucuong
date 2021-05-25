<template>
    <div id="special-module" v-if="_getBanner" style="margin-top:15px;margin-bottom:15px">
        <h4 class="tit-highlights"><span></span></h4>
        <b-row>
            <b-col cols="12" class="col-mobile">
                <div class="banner-image">
                    <a :href="_getBanner.url_full" :target="(_getBanner.open)?'_self':'_blank'" style="width:100%">  
                        <img style="width:inherit" v-bind:style="{ height: _getBanner.height + 'px' }"  
                            :src="'/Image/NewPicture/'+_getBanner.image" 
                            alt="Hình ảnh Phú Cường" class="img">
                        <!--<img v-bind:style="{ width: _getBanner.width + 'px', height: _getBanner.height + 'px' }"  
                            :src="'/Image/NewPicture/'+_getBanner.image" 
                            alt="Hình ảnh Phú Cường" class="img">-->
                    </a>
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
            _getBanner() {
                const lists = _.remove(this.settingBanner, function(item) {
                    return parseInt(item.status);
                });

                if (lists.length) {
                    return lists[0];
                }

                return null;
            },
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