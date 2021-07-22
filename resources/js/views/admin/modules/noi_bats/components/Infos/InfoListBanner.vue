<template>
    <div>
        <div class="form-group">
            <label
                class="col-sm-2 control-label"
                for="input-parent-category-name">
                    <span data-toggle="tooltip"
                        data-original-title="(Tự động hoàn toàn)">Key</span>
            </label>
            <div class="col-sm-10">
                <input class="form-control" :value="settingBanner.key" type="text" disabled/>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-12">
                <div id="media-info-banner-manager"></div>
                <input type="hidden" class="form-control" id="file-banner-input" disabled>
            </div>
            <div class="col-sm-12">
                Định dạng banner
            </div>
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <td style="width:10%" class="text-left">Top (%)</td>
                            <td style="width:35%" class="text-left">Left (%)</td>
                            <td style="width:25%">Color(tên hoặc mã màu: ffffff)</td>
                            <td>Font-weight</td>
                            <td>Font-size (px)</td>
                            <td class="text-right">
                                <button 
                                    type="button"
                                    @click="_updateBanner"
                                    data-toggle="tooltip"
                                    class="btn btn-primary"
                                        data-original-title="Sửa Tin">
                                        <i class="fa fa-edit fa-fw"/>
                                </button>
                            </td>
                        </tr>
                        </thead>
                        <tbody v-if="_getBannerFormatList.length">
                            <item-format-banner v-for="(item, idx) in _getBannerFormatList" 
                                :key="idx" :banner="item"></item-format-banner>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <td style="width:10%" class="text-left">{{$options.setting.image_title}}</td>
                            <td style="width:35%" class="text-left">Tiêu đề</td>
                            <td style="width:25%">{{$options.setting.image_url_title}}</td>
                            <td>Width</td>
                            <td>Height</td>
                            <td>Trạng thái</td>
                            <td>Mở</td>
                            <td>Thực hiện </td>
                        </tr>
                        </thead>
                        <tbody v-if="_getBannerList.length">
                            <item-banner v-for="(item, idx) in _getBannerList" 
                                :key="idx" :banner="item"></item-banner>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {
        mapActions,
        mapGetters,
    } from 'vuex';
    require('@app/tools/mm/dist/style.css');
    import {MM} from '@app/tools/mm/dist/mm.min';
    import {
        MODULE_MODULE_NOI_BAT,
    } from 'store@admin/types/module-types';
    import lodash from 'lodash';
    import ItemBanner from './ItemBanner';
    import ItemFormatBanner from './ItemFormatBanner';

    export default {
        name: 'TheInfoListBanner',
        components: {
            ItemBanner,
            ItemFormatBanner
        },
        data() {
            return {
                mediaMM: null
            }
        },
        computed: {
            ...mapGetters(MODULE_MODULE_NOI_BAT, [
                'settingBanner',
                'settingBannerFormat'
            ]),
            _getBannerList() {
                return this.settingBanner.value;
            },
            _getBannerFormatList() {
                return this.settingBannerFormat.value;
            }
        },
        mounted() {
            const self = this;

            this.mediaMM = new MM({
                el: '#media-info-banner-manager',
                api: {
                    baseUrl: window.origin + '/api/mmedia',
                    listUrl: 'list',
                    downloadUrl: 'download', 
                    uploadUrl: 'upload',      
                    deleteUrl: 'delete' 
                },
                input: {
                    el: '#file-banner-input',
                    multiple: false
                },
                onSelect: function (event) {
                    self._changeImage(event);
                }
            });
        },
        methods: {
            ...mapActions(MODULE_MODULE_NOI_BAT, [
                'updateSettingByKey'
            ]),
            _changeImage(fi) {
                if (typeof fi === "object") {
                    if (fi.hasOwnProperty('selected') && fi.selected) {
                        if (fi.selected.hasOwnProperty('path')) {
                            console.log(fi.selected)
                            this.$emit('select-multiple-banner-img', {
                                filePath: fi.selected.path
                            }); 
                        }
                    }
                }
            },
            _updateBanner() {
                this.updateSettingByKey({
                    banner: this.settingBanner,
                    format: this.settingBannerFormat
                });
            }
        },
        setting: {
            image_title: 'Banner',
            image_url_title: 'Url hình'
        }
    };
</script>
