<template>
    <div class="tab-content">
        <div class="form-group">
            <div class="col-sm-12">
                <div id="media-info-manager"></div>
            </div>
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <td class="text-left">{{$options.setting.image_main_txt}}</td>
                            <td>{{$options.setting.image_main_path_txt}}</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-left">
                                <div class="file animated fadeIn" style="height: 61px">
                                    <div class="file-preview">
                                        <img :src="_getImgUrl()" class="thumb"/>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <input type="text" class="form-control" id="file-input" disabled>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="form-group">
            <info-image class="col-sm-12"
                        :info-images="groupData.multi_images"></info-image>
        </div>
    </div>
</template>

<script>
    require('@app/tools/mm/dist/style.css');
    import {MM} from '@app/tools/mm/dist/mm.min';
    import {EventBus} from '@app/api/utils/event-bus';
    import {
        fn_get_base_url_image
    } from '@app/api/utils/fn-helper';
    import InfoImage from './Images/InfoImage';

    export default {
        name: 'TabImageForm',
        components: {
            InfoImage
        },
        props: {
            groupData: {
                type: Object
            }
        },
        data() {
            return {
                mediaMM: null
            }
        },
        computed: {
            _isShowImgThumb() {
                return this._isEditForm();
            }
        },
        mounted() {
            const self = this;

            this.mediaMM = new MM({
                el: '#media-info-manager',
                api: {
                    baseUrl: window.origin + '/api/mmedia',
                    listUrl: 'list',
                    downloadUrl: 'download',  // optional
                    uploadUrl: 'upload',      // optional
                    deleteUrl: 'delete'       // optional
                },
                input: {
                    el: '#file-input',
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
                    if (fi.hasOwnProperty('selected')) {
                        EventBus.$emit('on-selected-image', fi);
                    }
                }
            },
            _getImgUrl() {
                if (this.groupData.image.thumb && this.groupData.image.thumb.length) {
                    return this.groupData.image.thumb;
                } else {
                    return fn_get_base_url_image();
                }

            },
            _isEditForm() {
                return (Object.keys(this.groupData).length) ? (this.groupData.id ? true : false) : false;
            }
        },
        setting: {
            image_main_txt: 'Hình ảnh',
            image_main_path_txt: 'Tên tập tin',
        }
    };
</script>
