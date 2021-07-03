import Breadcrumb from 'com@admin/Breadcrumb';
import TheBtnBackListPage from 'v@admin/linhmucs/components/TheBtnBackListPage';

import {
    config
} from '@app/common/config';
import tinymce from 'vue-tinymce-editor';
import {
    fn_get_tinymce_langs_url,
    fn_get_href_base_url
} from '@app/api/utils/fn-helper';
import {
    ACTION_SET_IMAGE,
    ACTION_RESET_NOTIFICATION_INFO
} from 'store@admin/types/action-types';

export default {
    form: {
        data: () => {
            return {
                fullPage: true
            }
        },
        components: {
            Breadcrumb,
            TheBtnBackListPage
        },
        computed: {
            _errors() {
                return this.errors.length;
            }
        },
        watch: {
            'insertSuccess'(newValue, oldValue) {
                if (newValue) {
                    this._notificationUpdate(newValue);
                }
            },
            'updateSuccess'(newValue, oldValue) {
                if (newValue) {
                    this._notificationUpdate(newValue);
                }
            }
        },
        methods: {
            _errorToArrs() {
                let errs = [];
                if (this.errors.length && typeof this.errors[0].messages !== "undefined") {
                    errs = Object.values(this.errors[0].messages);
                }
                if (Object.entries(errs).length === 0 && this.errors.length) {
                    errs.push(this.$options.setting.error_msg_system);
                }
                return errs;
            },
            _submitInfo() {
                const _self = this;
                _self.$refs.observerInfo.validate().then((isValid) => {
                    if (isValid) {
                        _self.$refs.formLinhMuc._submitInfo();
                    }
                });
            },
            _submitInfoBack() {
                const _self = this;
                _self.$refs.observerInfo.validate().then((isValid) => {
                    if (isValid) {
                        _self.$refs.formLinhMuc._submitInfoBack();
                    }
                });
            },
            _notificationUpdate(notification) {
                this.$notify(notification);
                this.[ACTION_RESET_NOTIFICATION_INFO]('');
            }
        }
  },
  tabData: {
    components: {
        tinymce
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
                                if (_self.fn) {
                                    _self.fn('Image/NewPicture/' + fi.selected.path);
                                }
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
                                                if (_self.fn) {
                                                    _self.fn('Image/NewPicture/' + fi.selected.path);
                                                }
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
    computed: {
        _getImageAvatar() {
            if (this.generalData.image != '') {
                return fn_get_href_base_url(this.generalData.image);
            } 

            return '/images/no-photo.jpg';
        }
    },
    watch: {
        'generalData': {
            immediate: true,
            deep: true,
            handler(newValue, oldValue) {
                if (newValue && Object.keys(newValue).length) {
                    newValue.ghi_chu = (newValue.ghi_chu === null) ? "" : newValue.ghi_chu;
                    newValue.rip_ghi_chu = (newValue.rip_ghi_chu === null) ? "" : newValue.rip_ghi_chu;
                    return newValue;
                }
            }
        }
    },
    methods: {
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
        },
        _selectImage() {
            const _self = this;
            if (this.fn == null) {
                this.fn = function(file) {
                    if (typeof _self.[ACTION_SET_IMAGE] === "function") { 
                        _self.[ACTION_SET_IMAGE](file);
                    }
                }
            }
            
            document.getElementById('media-file-manager-content').style="display:block";
        },
        _selectGeneralTenThanh(thanh) {
            this.ACTION_UPDATE_DROPDOWN_TEN_THANH_LIST({
                tenThanh: thanh
            });
        },
        _removeThuyenChuyenItem() {
            this.removeThuyenChuyen({
                action: 'removeThuyenChuyen',
                item: this.item
            });
        },
        _selectThuyenChuyenCoSoGiaoPhan(coso) {
            this.ACTION_UPDATE_DROPDOWN_CO_SO_GIAO_PHAN({
                coso: coso,
                thuyenChuyen: this.item
            });
        },
        _selectThuyenChuyenFromGiaoXu(giaoxu) {
            this.ACTION_UPDATE_DROPDOWN_FROM_GIAO_XU({
                giaoXu: giaoxu,
                thuyenChuyen: this.item
            });
        },
        _selectThuyenChuyenToGiaoXu(giaoxu) {
            this.ACTION_UPDATE_DROPDOWN_TO_GIAO_XU({
                giaoXu: giaoxu,
                thuyenChuyen: this.item
            });
        },
        _selectThuyenChuyenFromChucVu(chucvu) {
            this.ACTION_UPDATE_DROPDOWN_FROM_CHUC_VU({
                chucVu: chucvu,
                thuyenChuyen: this.item
            });
        },
        _selectThuyenChuyenToChucVu(chucvu) {
            this.ACTION_UPDATE_DROPDOWN_TO_CHUC_VU({
                chucVu: chucvu,
                thuyenChuyen: this.item
            });
        },
        _selectThuyenChuyenDucCha(duccha) {
            this.ACTION_UPDATE_DROPDOWN_FROM_DUC_CHA({
                ducCha: duccha,
                thuyenChuyen: this.item
            });
        },
        _selectThuyenChuyenDong(dong) {
            this.ACTION_UPDATE_DROPDOWN_THUYEN_CHUYEN_DONG({
                dong: dong,
                thuyenChuyen: this.item
            });
        },
        _selectThuyenChuyenBanChuyenTrach(banchuyentrach) {
            this.ACTION_UPDATE_DROPDOWN_THUYEN_CHUYEN_BAN_CHUYEN_TRACH({
                banChuyenTrach: banchuyentrach,
                thuyenChuyen: this.item
            });
        },
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
    }
  }
};
  