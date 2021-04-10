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
                                        <img :src="_getImgUrl()" class="thumb" />
                                    </div>
                                </div>
                                <input type="hidden" name="image" value="/" id="input-image"/>
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
            <div class=" col-sm-12 table-responsive">
                <table id="images" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <td class="text-left">{{$options.setting.image_sub_txt}}</td>
                            <td class="text-left">{{$options.setting.image_sub_sort_order_txt}}</td>
                            <td class="text-right">{{$options.setting.image_sub_action_txt}}</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="image-row">
                            <td class="text-left">
                                <div class="file animated fadeIn" style="height: 61px">
                                    <div class="file-preview">
                                        <img :src="_getImgUrl()" class="thumb" />
                                    </div>
                                </div>
                                <input type="hidden" name="news_image[]"
                                       value="/"
                                       id="input-image"/>
                            </td>
                            <td class="text-left">
                                <input type="text"
                                  name="news_image[][sort_order]"
                                  value="0"
                                  :placeholder="$options.setting.image_sub_sort_order_txt"
                                  class="form-control"/>
                            </td>
                            <td class="text-right">
                                <button type="button" onclick="$('#image-row').remove();"
                                        data-toggle="tooltip" :title="$options.setting.btn_image_sub_remove_txt"
                                        class="btn btn-default cms-btn">

                                    <font-awesome-layers size="1x" style="background:MistyRose">
                                        <font-awesome-icon icon="circle" style="color:Tomato"/>
                                        <font-awesome-icon icon="times" class="fa-inverse" transform="shrink-4"/>
                                    </font-awesome-layers>
                                </button>
                            </td>
                        </tr>
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="2"></td>
                            <td class="text-right">
                                <button type="button" data-toggle="tooltip"
                                        :title="$options.setting.btn_image_sub_add_txt" class="btn btn-default cms-btn">
                                        <font-awesome-layers style="background:honeydew">
                                            <font-awesome-icon size="1x" icon="plus"/>
                                        </font-awesome-layers>
                                </button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    require ('@app/tools/mm/dist/style.css');
    import { MM } from '@app/tools/mm/dist/mm.min';
    import { EventBus } from '@app/api/utils/event-bus';
    import {
        fn_get_base_url_image
    } from '@app/api/utils/fn-helper';

    export default {
        name: 'TabImageForm',

        props: {
            groupData: {
                type: Object
            },
            configForm: {}
        },

        data() {
            return {
                mediaMM : null
            }
        },

        computed: {
            _isShowImgThumb() {
                return this._isEditForm();
            }
        },

        mounted () {
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
                onSelect : function(event) {
                    self._changeImage(event);
                }
            });
            console.log(this)
        },

        methods: {
            _changeImage(fi) {
                EventBus.$emit('on-selected-image', fi)
            },
            _getImgUrl() {
                return fn_get_base_url_image(this.groupData.picture);
            },
            _isEditForm() {
                return (Object.keys(this.groupData).length) ? (this.groupData.id ? true: false): false;
            }
        },

        setting: {
            image_main_txt: 'Hình ảnh',
            image_main_path_txt: 'Tên tập tin',
            image_sub_txt: 'Hình ảnh bổ sung',
            image_sub_sort_order_txt: 'Sắp xếp',
            image_sub_action_txt: 'Thực hiện',
            btn_image_sub_remove_txt: 'Xóa',
            btn_image_sub_add_txt: 'Thêm hình ảnh'
        }
    };
</script>
