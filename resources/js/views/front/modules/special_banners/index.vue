<template>
    <div id="special-module" v-if="_getBanner" style="margin-top:15px;margin-bottom:15px">
        <h4 class="tit-highlights"><span></span></h4>
        <b-row>
            <b-col cols="12" class="col-mobile">
                <div class="banner-image">
                    <a :href="_getBanner.url_full" :target="(_getBanner.open)?'_self':'_blank'" style="width:100%">  
                        <span style="position:absolute" :style="_getSettingFormat">{{_getBanner.title}}</span>
                        <img style="width:100%" v-bind:style="{ height: _getBanner.height + 'px' }"  
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

    export default {
        name: 'ModuleNoiBat',
        data() {
            return {
                fullPage: true,
            }
        },
        computed: {
            ...mapGetters(MODULE_MODULE_NOI_BAT, [
                'settingBanner',
                'settingBannerFormat'
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
            _getSettingFormat() {
                if (this.settingBannerFormat.length) {
                    const format = this.settingBannerFormat[0];

                    let top = format.top;
                    let left = format.left;
                    let color = format.color;
                    let fontWeight = format.font_weight;
                    let fontSize = format.font_size;

                    let styleTitle = `top: ${top}%; left: ${left}%;color: ${color};font-weight: ${fontWeight};font-size: ${fontSize}px`;

                    return styleTitle;
                }

                return "";
            }
        },
        methods: {
            ...mapActions(MODULE_MODULE_NOI_BAT, [
                ACTION_GET_SETTING,
            ])
        },
        setting: {
            styleTitle: "position: absolute;left: 15%;top: 41%;color: white;font-weight: 600;font-size: 36px;"
        }
    };
</script>

<style lang="scss">
    @import './styles.scss';
</style>