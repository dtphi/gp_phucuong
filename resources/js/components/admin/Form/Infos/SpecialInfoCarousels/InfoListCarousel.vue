<template>
    <div>
        <div class="form-group">
            <div class="col-sm-12">
                <div id="media-info-banner-manager"></div>
                <input type="hidden" class="form-control" id="file-banner-input" disabled>
            </div>
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <td class="text-left">{{$options.setting.image_title}}</td>
                            <td>{{$options.setting.image_url_title}}</td>
                            <td>Width</td>
                            <td>Height</td>
                            <td>Trạng thái</td>
                            <td>Mở</td>
                            <td>Thực hiện </td>
                        </tr>
                        </thead>
                        <tbody v-if="_getBannerList.length">
                            <item-carousel v-for="(item, idx) in _getBannerList" 
                                :key="idx" :banner="item"></item-carousel>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {
        mapGetters,
    } from 'vuex';
    require('@app/tools/mm/dist/style.css');
    import {MM} from '@app/tools/mm/dist/mm.min';
    import {
        MODULE_MODULE_SPECIAL_INFO_CAROUSEL,
    } from 'store@admin/types/module-types';
    import lodash from 'lodash';
    import ItemCarousel from './ItemCarousel';

    export default {
        name: 'TheInfoListCarousel',
        components: {
            ItemCarousel
        },
        data() {
            return {
                mediaMM: null
            }
        },
        computed: {
            ...mapGetters(MODULE_MODULE_SPECIAL_INFO_CAROUSEL, [
                'settingBanner',
            ]),
            _getBannerList() {
                return this.settingBanner.value;
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
            
        },
        setting: {
            image_title: 'Banner',
            image_url_title: 'Url hình'
        }
    };
</script>
