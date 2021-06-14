<template>
    <div class="tab-content">
        <div>
            <info-ten-thanh-autocomplete></info-ten-thanh-autocomplete>
        </div>
        <div class="form-group required">
            <label
                for="input-info-name"
                class="col-sm-2 control-label">{{$options.setting.name_txt}}</label>
            <div class="col-sm-10">
                <validation-provider
                    name="info_name"
                    rules="required|max:200"
                    v-slot="{ errors }">
                    <input
                        v-model="generalData.ten"
                        type="text"
                        id="input-info-name"
                        class="form-control"
                        :placeholder="$options.setting.name_txt">

                    <span class="cms-text-red">{{ errors[0] }}</span>
                </validation-provider>
            </div>
        </div>
        <div class="form-group required">
            <label
                for="input-info-ngay-thang-nam-sinh"
                class="col-sm-2 control-label">Ngày sinh:</label>
            <div class="col-sm-10">
                <validation-provider
                    name="info_ngay_thang_nam_sinh"
                    rules="required|max:500"
                    v-slot="{ errors }">
                    <cms-date-picker v-model="generalData.ngay_thang_nam_sinh" type="datetime"></cms-date-picker>
                    <span class="cms-text-red">{{ errors[0] }}</span>
                </validation-provider>
            </div>
        </div>
        <div class="form-group required">
            <label
                for="input-info-noi-sinh"
                class="col-sm-2 control-label">Nơi sinh</label>
            <div class="col-sm-10">
                <validation-provider
                    name="info_noi_sinh"
                    rules="required|max:500"
                    v-slot="{ errors }">
                        <textarea
                            id="input-info-noi-sinh"
                            v-model="generalData.noi_sinh"
                            class="form-control"
                            :placeholder="$options.setting.info_sort_description_txt"></textarea>

                    <span class="cms-text-red">{{ errors[0] }}</span>
                </validation-provider>
            </div>
        </div>
        <div>
            <info-giao-xu-autocomplete @on-select-giao-xu="_selectGiaoXu"></info-giao-xu-autocomplete>
        </div>
        <div class="form-group required">
            <label
                for="input-info-ho-ten-cha"
                class="col-sm-2 control-label">Họ tên cha</label>
            <div class="col-sm-10">
                <validation-provider
                    name="info_ho_ten_cha"
                    rules="required|max:200"
                    v-slot="{ errors }">
                    <input
                        v-model="generalData.ho_ten_cha"
                        type="text"
                        id="input-info-ho-ten-cha"
                        class="form-control"
                        :placeholder="$options.setting.name_txt">

                    <span class="cms-text-red">{{ errors[0] }}</span>
                </validation-provider>
            </div>
        </div>
        <div class="form-group required">
            <label
                for="input-info-ho-ten-me"
                class="col-sm-2 control-label">Họ tên mẹ</label>
            <div class="col-sm-10">
                <validation-provider
                    name="info_ho_ten_me"
                    rules="required|max:200"
                    v-slot="{ errors }">
                    <input
                        v-model="generalData.ho_ten_me"
                        type="text"
                        id="input-info-ho-ten-me"
                        class="form-control"
                        :placeholder="$options.setting.name_txt">

                    <span class="cms-text-red">{{ errors[0] }}</span>
                </validation-provider>
            </div>
        </div>
        <div class="form-group required">
            <label
                for="input-info-noi-rua-toi"
                class="col-sm-2 control-label">Nơi rửa tội</label>
            <div class="col-sm-10">
                <validation-provider
                    name="info_noi_rua_toi"
                    rules="required|max:200"
                    v-slot="{ errors }">
                    <input
                        v-model="generalData.noi_rua_toi"
                        type="text"
                        id="input-info-noi-rua-toi"
                        class="form-control"
                        :placeholder="$options.setting.name_txt">

                    <span class="cms-text-red">{{ errors[0] }}</span>
                </validation-provider>
            </div>
        </div>
        <div class="form-group required">
            <label
                for="input-info-ngay-rua-toi"
                class="col-sm-2 control-label">Ngày rửa tội:</label>
            <div class="col-sm-10">
                <validation-provider
                    name="info_ngay_rua_toi"
                    rules="required|max:500"
                    v-slot="{ errors }">
                    <cms-date-picker v-model="generalData.ngay_rua_toi" type="datetime"></cms-date-picker>
                    <span class="cms-text-red">{{ errors[0] }}</span>
                </validation-provider>
            </div>
        </div>
        <div class="form-group required">
            <label
                for="input-info-noi-them-suc"
                class="col-sm-2 control-label">Nơi thêm sức</label>
            <div class="col-sm-10">
                <validation-provider
                    name="info_noi_them_suc"
                    rules="required|max:200"
                    v-slot="{ errors }">
                    <input
                        v-model="generalData.noi_them_suc"
                        type="text"
                        id="input-info-noi-them-suc"
                        class="form-control"
                        :placeholder="$options.setting.name_txt">

                    <span class="cms-text-red">{{ errors[0] }}</span>
                </validation-provider>
            </div>
        </div>
        <div class="form-group required">
            <label
                for="input-info-ngay-them-suc"
                class="col-sm-2 control-label">Ngày thêm sức:</label>
            <div class="col-sm-10">
                <validation-provider
                    name="info_ngay_them_suc"
                    rules="required|max:500"
                    v-slot="{ errors }">
                    <cms-date-picker v-model="generalData.ngay_them_suc" type="datetime"></cms-date-picker>
                    <span class="cms-text-red">{{ errors[0] }}</span>
                </validation-provider>
            </div>
        </div>
        <div class="form-group required">
            <label
                for="input-info-tieu-chung-vien"
                class="col-sm-2 control-label">Tiểu chủng viện</label>
            <div class="col-sm-10">
                <validation-provider
                    name="info_tieu_chung_vien"
                    rules="required|max:200"
                    v-slot="{ errors }">
                    <input
                        v-model="generalData.tieu_chung_vien"
                        type="text"
                        id="input-info-tieu-chung-vien"
                        class="form-control"
                        :placeholder="$options.setting.name_txt">

                    <span class="cms-text-red">{{ errors[0] }}</span>
                </validation-provider>
            </div>
        </div>
        <div class="form-group required">
            <label
                for="input-info-ngay-tieu-chung-vien"
                class="col-sm-2 control-label">Ngày tiểu chủng viện:</label>
            <div class="col-sm-10">
                <validation-provider
                    name="info_ngay_tieu_chung_vien"
                    rules="required|max:500"
                    v-slot="{ errors }">
                    <cms-date-picker v-model="generalData.ngay_tieu_chung_vien" type="datetime"></cms-date-picker>
                    <span class="cms-text-red">{{ errors[0] }}</span>
                </validation-provider>
            </div>
        </div>
        <div class="form-group required">
            <label
                for="input-info-dai-chung-vien"
                class="col-sm-2 control-label">Đại chủng viện</label>
            <div class="col-sm-10">
                <validation-provider
                    name="info_dai_chung_vien"
                    rules="required|max:200"
                    v-slot="{ errors }">
                    <input
                        v-model="generalData.dai_chung_vien"
                        type="text"
                        id="input-info-dai-chung-vien"
                        class="form-control"
                        :placeholder="$options.setting.name_txt">

                    <span class="cms-text-red">{{ errors[0] }}</span>
                </validation-provider>
            </div>
        </div>
        <div class="form-group required">
            <label
                for="input-info-ngay-dai-chung-vien"
                class="col-sm-2 control-label">Ngày đại chủng viện:</label>
            <div class="col-sm-10">
                <validation-provider
                    name="info_ngay_dai_chung_vien"
                    rules="required|max:500"
                    v-slot="{ errors }">
                    <cms-date-picker v-model="generalData.ngay_dai_chung_vien" type="datetime"></cms-date-picker>
                    <span class="cms-text-red">{{ errors[0] }}</span>
                </validation-provider>
            </div>
        </div>
        <div class="form-group required">
            <label
                for="input-info-trieu-dong"
                class="col-sm-2 control-label">Triệu dòng:</label>
            <div class="col-sm-10">
                <validation-provider
                    name="info_trieu_dong"
                    rules="required|max:200"
                    v-slot="{ errors }">
                    <select class="form-control" 
                        id="input-info-trieu-dong"
                        v-model="generalData.trieu_dong">
                        <option 
                            :selected="(generalData.trieu_dong==idx)?'selected':''" 
                            :value="idx" v-for="(item, idx) in $options.setting.cf.trieuDongs" 
                            :key="idx">{{item}}</option>
                    </select>

                    <span class="cms-text-red">{{ errors[0] }}</span>
                </validation-provider>
            </div>
        </div>
         <div class="form-group required">
            <label
                for="input-info-ten-dong-id"
                class="col-sm-2 control-label">Tên dòng:</label>
            <div class="col-sm-10">
                <validation-provider
                    name="info_ten_dong_id"
                    rules="required|max:200"
                    v-slot="{ errors }">
                    <input
                        v-model="generalData.ten_dong_id"
                        type="text"
                        id="input-info-ten-dong-id"
                        class="form-control"
                        :placeholder="$options.setting.name_txt">

                    <span class="cms-text-red">{{ errors[0] }}</span>
                </validation-provider>
            </div>
        </div>
        <div class="form-group required">
            <label
                for="input-info-ngay-trieu-dong"
                class="col-sm-2 control-label">Ngày triệu dòng:</label>
            <div class="col-sm-10">
                <validation-provider
                    name="info_ngay_trieu_dong"
                    rules="required|max:500"
                    v-slot="{ errors }">
                    <cms-date-picker v-model="generalData.ngay_cap_cmnd" type="datetime"></cms-date-picker>
                    <span class="cms-text-red">{{ errors[0] }}</span>
                </validation-provider>
            </div>
        </div>
        <div class="form-group required">
            <label
                for="input-info-ngay-khan"
                class="col-sm-2 control-label">Ngày khấn:</label>
            <div class="col-sm-10">
                <validation-provider
                    name="info_ngay_khan"
                    rules="required|max:500"
                    v-slot="{ errors }">
                    <cms-date-picker v-model="generalData.ngay_khan" type="datetime"></cms-date-picker>
                    <span class="cms-text-red">{{ errors[0] }}</span>
                </validation-provider>
            </div>
        </div>
        <div class="form-group required">
            <label
                for="input-info-ngay-rip"
                class="col-sm-2 control-label">Ngày Rip:</label>
            <div class="col-sm-10">
                <validation-provider
                    name="info_ngay_rip"
                    rules="required|max:500"
                    v-slot="{ errors }">
                    <cms-date-picker v-model="generalData.ngay_rip" type="datetime"></cms-date-picker>
                    <span class="cms-text-red">{{ errors[0] }}</span>
                </validation-provider>
            </div>
        </div>
        <div>
            <info-giao-xu-autocomplete></info-giao-xu-autocomplete>
        </div>
        <div class="form-group required">
            <label
                for="input-info-rip-ghi-chu"
                class="col-sm-2 control-label">Rip ghi chú</label>
            <div class="col-sm-10">
                <validation-provider
                    name="info_rip_ghi_chu"
                    rules="required"
                    v-slot="{ errors }">
                    <tinymce 
                        id="input-rip-ghi-chu"
                        :other_options="options"
                        v-model="generalData.rip_ghi_chu"></tinymce>

                    <span class="cms-text-red">{{ errors[0] }}</span>
                </validation-provider>
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
            _selectGiaoXu(giaoxu) {
                console.log('giao xu', giaoxu)
            }
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
