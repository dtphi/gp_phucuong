import Breadcrumb from 'com@admin/Breadcrumb'
import TheBtnBackListPage from 'v@admin/linhmucs/components/TheBtnBackListPage'
import tinymce from 'vue-tinymce-editor'
import {
  fn_get_href_base_url,
} from '@app/api/utils/fn-helper'
import {
  ACTION_SET_IMAGE,
} from 'store@admin/types/action-types'

export default {
  form: {
    data: () => {
      return {
        fullPage: true,
      }
    },
    components: {
      Breadcrumb,
      TheBtnBackListPage,
    },
    computed: {
      _errors() {
        return this.errors.length
      },
    },
    watch: {
      'insertSuccess'(newValue) {
        if (newValue) {
          this._notificationUpdate(newValue)
        }
      },
      'updateSuccess'(newValue) {
        if (newValue) {
          this._notificationUpdate(newValue)
        }
      },
    },
    methods: {
      _errorToArrs() {
        let errs = []
        if (this.errors.length && typeof this.errors[0].messages !== 'undefined') {
          errs = Object.values(this.errors[0].messages)
        }
        if (Object.entries(errs).length === 0 && this.errors.length) {
          errs.push(this.$options.setting.error_msg_system)
        }
        
        return errs
      },
      _submitInfo() {
        this.$refs.observerInfo.validate().then((isValid) => {
          if (isValid) {
            this.$refs.formLinhMuc._submitInfo()
          }
        })
      },
      _submitInfoBack() {
        this.$refs.observerInfo.validate().then((isValid) => {
          if (isValid) {
            this.$refs.formLinhMuc._submitInfoBack()
          }
        })
      },
      _notificationUpdate(notification) {
        this.$notify(notification)
        this.resetNotification('')
      },
    },
  },
  tabData: {
    components: {
      tinymce,
    },
    props: {
      generalData: {
        type: Object,
      },
      mmSelected: {
        default() {
          return {}
        },
      },
      mmPath: {
        type: String,
        default() {
          return ''
        },
      },
    },
    data() {
      const elFileContent = document.getElementById('media-file-manager-content')
      const options = this.$cmsCfg.tinymce.options((callback) => {
        this.fn = callback
        elFileContent.style = this.$options.setting.cssDisplay
      })
      
      return {
        fn: null,
        options: options,
        ten_thanh_linh_muc: 'ten_thanh_linh_muc',
        giao_xu_linh_muc: 'giao_xu_linh_muc',
        giao_xu_rip: 'giao_xu_rip',
        ten_dong_linh_muc: 'ten_dong_linh_muc',
      }
    },
    computed: {
      _getImageAvatar() {
        if (this.generalData.image != '') {
          return fn_get_href_base_url(this.generalData.image)
        }
        
        return '/images/no-photo.jpg'
      },
    },
    watch: {
      'generalData': {
        immediate: true,
        deep: true,
        handler(newValue) {
          if (newValue && Object.keys(newValue).length) {
            newValue.ghi_chu = (newValue.ghi_chu === null) ? '' : newValue.ghi_chu
            newValue.rip_ghi_chu = (newValue.rip_ghi_chu === null) ? '' : newValue.rip_ghi_chu
            
            return newValue
          }
        },
      },
      mmPath(val) {
        this._updateImageField(val)
      },
    },
    methods: {
      _selectGiaoXu(giaoxu) {
        this.ACTION_UPDATE_DROPDOWN_GIAO_XU({
          giaoXu: giaoxu,
        })
      },
      _selectRipGiaoXu(giaoxu) {
        this.ACTION_UPDATE_DROPDOWN_RIP_GIAO_XU({
          giaoXu: giaoxu,
        })
      },
      _selectDong(dong) {
        this.ACTION_UPDATE_DROPDOWN_DONG({
          dong: dong,
        })
      },
      _selectImage() {
        this.fn = null
        document.getElementById('media-file-manager-content')
          .style = this.$options.setting.cssDisplay
      },
      _selectGeneralTenThanh(thanh) {
        this.ACTION_UPDATE_DROPDOWN_TEN_THANH_LIST({
          tenThanh: thanh,
        })
      },
      _removeThuyenChuyenItem() {
        this.removeThuyenChuyen({
          action: 'removeThuyenChuyen',
          item: this.item,
        })
      },
      _selectThuyenChuyenCoSoGiaoPhan(coso) {
        this.ACTION_UPDATE_DROPDOWN_CO_SO_GIAO_PHAN({
          coso: coso,
          thuyenChuyen: this.item,
        })
      },
      _selectThuyenChuyenFromGiaoXu(giaoxu) {
        this.ACTION_UPDATE_DROPDOWN_FROM_GIAO_XU({
          giaoXu: giaoxu,
          thuyenChuyen: this.item,
        })
      },
      _selectThuyenChuyenToGiaoXu(giaoxu) {
        this.ACTION_UPDATE_DROPDOWN_TO_GIAO_XU({
          giaoXu: giaoxu,
          thuyenChuyen: this.item,
        })
      },
      _selectThuyenChuyenFromChucVu(chucvu) {
        this.ACTION_UPDATE_DROPDOWN_FROM_CHUC_VU({
          chucVu: chucvu,
          thuyenChuyen: this.item,
        })
      },
      _selectThuyenChuyenToChucVu(chucvu) {
        this.ACTION_UPDATE_DROPDOWN_TO_CHUC_VU({
          chucVu: chucvu,
          thuyenChuyen: this.item,
        })
      },
      _selectThuyenChuyenDucCha(duccha) {
        this.ACTION_UPDATE_DROPDOWN_FROM_DUC_CHA({
          ducCha: duccha,
          thuyenChuyen: this.item,
        })
      },
      _selectThuyenChuyenDong(dong) {
        this.ACTION_UPDATE_DROPDOWN_THUYEN_CHUYEN_DONG({
          dong: dong,
          thuyenChuyen: this.item,
        })
      },
      _selectThuyenChuyenBanChuyenTrach(banchuyentrach) {
        this.ACTION_UPDATE_DROPDOWN_THUYEN_CHUYEN_BAN_CHUYEN_TRACH({
          banChuyenTrach: banchuyentrach,
          thuyenChuyen: this.item,
        })
      },
      _updateImageField(path) {
        if (typeof this.fn === 'function') {
          this.fn(path, this.mmSelected)
        } else {
          this[ACTION_SET_IMAGE](path)
        }
      },
    },
    setting: {
      cssDisplay: 'display:block',
      cssDisplayNone: 'display:none',
      name_txt: 'Tên',
      info_sort_description_txt: 'Mô tả',
      info_description_txt: 'Nội dung',
      info_key_word_txt: 'Từ khóa mô tả',
      info_meta_title_txt: 'Thẻ meta tiêu đề',
      info_meta_description_txt: 'Thẻ meta mô tả',
      info_tag_txt: 'Tags',
      info_tag_tooltip_txt: 'Ngăn cách bởi dấu phẩy',
    },
  },
}