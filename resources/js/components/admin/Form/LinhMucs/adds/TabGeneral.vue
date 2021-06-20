<template>
    <div class="tab-content">
        <div>
            <info-ten-thanh-autocomplete 
                :key="ten_thanh_linh_muc"></info-ten-thanh-autocomplete>
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
                    rules="required"
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
                            placeholder="Nơi sinh"></textarea>

                    <span class="cms-text-red">{{ errors[0] }}</span>
                </validation-provider>
            </div>
        </div>
        <div>
            <info-giao-xu-autocomplete 
                @on-select-giao-xu="_selectGiaoXu" 
                :name="generalData.giao_xu_name" 
                :key="giao_xu_linh_muc"></info-giao-xu-autocomplete>
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
                        placeholder="Họ tên cha">

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
                        placeholder="Họ tên mẹ">

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
                    rules="required|max:500"
                    v-slot="{ errors }">
                    <input
                        v-model="generalData.noi_rua_toi"
                        type="text"
                        id="input-info-noi-rua-toi"
                        class="form-control"
                        placeholder="Nơi rửa tội">

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
                    rules="required"
                    v-slot="{ errors }">
                    <cms-date-picker 
                        v-model="generalData.ngay_rua_toi" type="datetime"></cms-date-picker>

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
                    rules="required|max:500"
                    v-slot="{ errors }">
                    <input
                        v-model="generalData.noi_them_suc"
                        type="text"
                        id="input-info-noi-them-suc"
                        class="form-control"
                        placeholder="Nơi thêm sức">

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
                    <cms-date-picker 
                        v-model="generalData.ngay_them_suc" type="datetime"></cms-date-picker>

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
                        placeholder="Tiểu chủng viện">

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
                    <cms-date-picker 
                        v-model="generalData.ngay_tieu_chung_vien" type="datetime"></cms-date-picker>

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
                        placeholder="Đại chủng viện">

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
                    <cms-date-picker 
                        v-model="generalData.ngay_dai_chung_vien" type="datetime"></cms-date-picker>

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
                    rules="required"
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
            <info-dong-autocomplete 
                @on-select-dong="_selectDong" 
                :name="generalData.ten_dong_name" 
                :key="ten_dong_linh_muc"></info-dong-autocomplete>
        </div>
        <div class="form-group required">
            <label
                for="input-info-ngay-trieu-dong"
                class="col-sm-2 control-label">Ngày triệu dòng:</label>
            <div class="col-sm-10">
                <validation-provider
                    name="info_ngay_trieu_dong"
                    rules="required"
                    v-slot="{ errors }">
                    <cms-date-picker 
                        v-model="generalData.ngay_trieu_dong" type="datetime"></cms-date-picker>

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
                    rules="required"
                    v-slot="{ errors }">
                    <cms-date-picker 
                        v-model="generalData.ngay_khan" type="datetime"></cms-date-picker>

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
                    rules="required"
                    v-slot="{ errors }">
                    <cms-date-picker 
                        v-model="generalData.ngay_rip" type="datetime"></cms-date-picker>

                    <span class="cms-text-red">{{ errors[0] }}</span>
                </validation-provider>
            </div>
        </div>
        <div>
            <info-giao-xu-autocomplete 
                @on-select-giao-xu="_selectRipGiaoXu" 
                :name="generalData.rip_giaoxu_name" 
                :key="giao_xu_rip"></info-giao-xu-autocomplete>
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
        mapActions
    } from 'vuex';
    import {
        MODULE_MODULE_LINH_MUC_ADD
    } from 'store@admin/types/module-types';
    import {
        config
    } from '@app/common/config';
    import tinymce from 'vue-tinymce-editor';
    import {
        fn_get_tinymce_langs_url
    } from '@app/api/utils/fn-helper';
    import InfoGiaoXuAutocomplete from './Groups/InfoGiaoXuAutocomplete';
    import InfoTenThanhAutocomplete from './Groups/InfoTenThanhAutocomplete';
    import InfoDongAutocomplete from './Groups/InfoDongAutocomplete';

    export default {
        name: 'TabGeneralForm',
        components: {
            tinymce,
            InfoGiaoXuAutocomplete,
            InfoTenThanhAutocomplete,
            InfoDongAutocomplete
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
                    image_prepend_url: window.origin + '/',
                    referrer_policy: 'strict-origin-when-cross-origin',
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
                                        uploadUrl: 'upload',
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
                ten_thanh_linh_muc: 'ten_thanh_linh_muc',
                giao_xu_linh_muc: 'giao_xu_linh_muc',
                giao_xu_rip: 'giao_xu_rip',
                ten_dong_linh_muc: 'ten_dong_linh_muc'
            };
        },
        watch: {
            'generalData': {
                immediate: true,
                deep: true,
                handler(newValue, oldValue) {
                    if (Object.keys(newValue).length) {
                        return newValue.rip_ghi_chu = (newValue.rip_ghi_chu === null) ? "" : newValue.rip_ghi_chu;
                    }
                }
            }
        },
        methods: {
            ...mapActions(MODULE_MODULE_LINH_MUC_ADD, [
        		'ACTION_UPDATE_DROPDOWN_GIAO_XU',
                'ACTION_UPDATE_DROPDOWN_RIP_GIAO_XU',
                'ACTION_UPDATE_DROPDOWN_DONG'
        	]),
            _selectGiaoXu(giaoxu) {
                this.ACTION_UPDATE_DROPDOWN_GIAO_XU({
                    giaoXu: giaoxu
                });
            },
            _selectRipGiaoXu(giaoxu) {
                this.ACTION_UPDATE_DROPDOWN_RIP_GIAO_XU({
                    giaoXu: giaoxu
                });
            },
            _selectDong(dong) {
                this.ACTION_UPDATE_DROPDOWN_DONG({
                    dong: dong
                });
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
