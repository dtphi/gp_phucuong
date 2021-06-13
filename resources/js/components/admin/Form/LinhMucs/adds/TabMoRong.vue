<template>
    <div class="tab-content">
        <div class="form-group required">
            <label
                for="input-info-duc-cha"
                class="col-sm-2 control-label">Chức Vụ</label>
            <div class="col-sm-10">
                <label>Là đức cha</label>
                <input
                    type="checkbox"
                    id="input-info-duc-cha"
                    class="form-control">
            </div>
        </div>
        <div class="form-group required">
            <label
                for="input-info-so-cmnd"
                class="col-sm-2 control-label">Số CMND</label>
            <div class="col-sm-10">
                <validation-provider
                    name="info_so_cmnd"
                    rules="required|max:200"
                    v-slot="{ errors }">
                    <input
                        v-model="generalData.so_cmnd"
                        type="text"
                        id="input-info-so-cmnd"
                        class="form-control"
                        :placeholder="$options.setting.name_txt">

                    <span class="cms-text-red">{{ errors[0] }}</span>
                </validation-provider>
            </div>
        </div>
        <div class="form-group required">
            <label
                for="input-info-noicap-cmnd"
                class="col-sm-2 control-label">Nơi cấp CMND:</label>
            <div class="col-sm-10">
                <validation-provider
                    name="info_noicap_cmnd"
                    rules="required|max:200"
                    v-slot="{ errors }">
                    <input
                        v-model="generalData.noicap_cmnd"
                        type="text"
                        id="input-info-noicap-cmnd"
                        class="form-control"
                        :placeholder="$options.setting.name_txt">

                    <span class="cms-text-red">{{ errors[0] }}</span>
                </validation-provider>
            </div>
        </div>
        <div class="form-group required">
            <label
                for="input-info-ngay-cap-cmnd"
                class="col-sm-2 control-label">Ngày cấp CMND:</label>
            <div class="col-sm-10">
                <validation-provider
                    name="info_ngay_cap_cmnd"
                    rules="required|max:500"
                    v-slot="{ errors }">
                    <cms-date-picker v-model="generalData.ngay_cap_cmnd" type="datetime"></cms-date-picker>
                    <span class="cms-text-red">{{ errors[0] }}</span>
                </validation-provider>
            </div>
        </div>
        <div class="form-group required">
            <label
                for="input-info-ghi-chu"
                class="col-sm-2 control-label">Ghi chú</label>
            <div class="col-sm-10">
                <validation-provider
                    name="info_ghi_chu"
                    rules="required"
                    v-slot="{ errors }">
                    <tinymce 
                        id="input-ghi-chu"
                        :other_options="options"
                        v-model="generalData.ghi_chu"></tinymce>

                    <span class="cms-text-red">{{ errors[0] }}</span>
                </validation-provider>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"
                   for="input-info-status">Trạng thái</label>
            <div class="col-sm-10">
                <select
                    v-model="generalData.active"
                    id="input-info-active"
                    class="form-control">
                    <option value="1" selected="selected">Xảy ra</option>
                    <option value="0">Ẩn</option>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
    import {
        config
    } from '@app/common/config';
    import tinymce from 'vue-tinymce-editor';
    import {
        fn_get_tinymce_langs_url
    } from '@app/api/utils/fn-helper';
    import InfoGiaoXuAutocomplete from './Groups/InfoGiaoXuAutocomplete';
    import InfoTenThanhAutocomplete from './Groups/InfoTenThanhAutocomplete';

    export default {
        name: 'TabGeneralForm',
        components: {
            tinymce,
            InfoGiaoXuAutocomplete,
            InfoTenThanhAutocomplete
        },
        props: {
            generalData: {
                type: Object
            }
        },
        data() {
            const _self = this;
            return {
                editor: null,
                fn: null,
                mm: new MM({
                    el: '#modal-general-info-manager',
                    api: {
                        baseUrl: window.origin + '/api/mmedia',
                        listUrl: 'list',
                        uploadUrl: 'upload',      // optional
                    },
                    onSelect : function(fi) {
                        if (typeof fi === "object") {
                            if (fi.hasOwnProperty('selected') && fi.selected) {
                                if (fi.selected.hasOwnProperty('path')) {
                                    _self.fn('Image/NewPicture/' + fi.selected.path, fi.selected);
                                    document.getElementById('media-file-manager-content').style="display:none";
                                }
                            }
                        }
                    }
                }),
                options: {
                    language_url: fn_get_tinymce_langs_url('vi_VN'),
                    height: "200",
                    //toolbar_mode: 'sliding',
                    //image_caption: true,
                    //image_list: [],
                    //image_advtab: false,
                    image_prepend_url: window.origin + '/',
                    //images_upload_url: window.origin + '/api/mmedia/upload',
                    /*images_upload_handler: function(editor) {
                        console.log(editor.filename());
                    },*/
                    referrer_policy: 'strict-origin-when-cross-origin',

                    /*init_instance_callback: function(editor) {
                        _self.editor = editor;
                    },*/
                    //importcss_append: true,
                    /* Show button select image */
                    file_picker_callback: function (callback, value, meta) {
                        if (meta.filetype === 'file') {
                            _self.fn = callback;
                            document.getElementById('media-file-manager-content').style="display:block";
                        }

                        if (meta.filetype === 'image') {
                            if (_self.mm == null) {
                                _self.mm = new MM({
                                    el: '#modal-general-info-manager',
                                    api: {
                                        baseUrl: window.origin + '/api/mmedia',
                                        listUrl: 'list',
                                        uploadUrl: 'upload',      // optional
                                    },
                                    onSelect : function(fi) {
                                        if (typeof fi === "object") {
                                            if (fi.hasOwnProperty('selected') && fi.selected) {
                                                if (fi.selected.hasOwnProperty('path')) {
                                                    _self.fn('Image/NewPicture/' + fi.selected.path, fi.selected);
                                                    document.getElementById('media-file-manager-content').style="display:none";
                                                }
                                            }
                                        }
                                    }
                                });

                                document.getElementById('media-file-manager-content').style="display:block";
                            } else {
                                _self.fn = callback;
                                document.getElementById('media-file-manager-content').style="display:block";
                            }
                        }

                        if (meta.filetype === 'media') {
                            _self.fn = callback;
                            document.getElementById('media-file-manager-content').style="display:block";
                        }
                    },
                    toolbar2: "undo redo | styleselect | fontsizeselect | fontselect | image ",
                    font_formats: "Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
                },
            };
        },
        watch: {
            'generalData': {
                immediate: true,
                deep: true,
                handler(newValue, oldValue) {
                    if (Object.keys(newValue).length) {
                        return newValue.context = (newValue.context === null) ? "" : newValue.context;
                    }
                }
            }
        },
        methods: {
        },
        setting: {
            cf: config,
            name_txt: 'Tên',
            info_sort_description_txt: 'Mô tả',
            info_description_txt: 'Nội dung',
            info_key_word_txt: 'Từ khóa mô tả',
            info_meta_title_txt: 'Thẻ meta tiêu đề',
            info_meta_description_txt: 'Thẻ meta mô tả',
            info_tag_txt: 'Tags',
            info_tag_tooltip_txt: 'Ngăn cách bởi dấu phẩy'
        },
        mounted() {
        }
    };
</script>
