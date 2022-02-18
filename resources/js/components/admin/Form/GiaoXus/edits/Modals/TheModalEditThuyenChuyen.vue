<template>
  <the-modal-resizable
    :title="$options.setting.modal_title"
    :modal-name="$options.setting.modal_name"
  >
    <template #cms_modal_form_group>
      <div class="form-group">
        <div class="col-sm-12">
          <info-chuc-vu-autocomplete
            @on-select-chuc-vu="_selectThuyenChuyenFromChucVu"
            :name="chucVuName"
            :key="$options.setting.keyChucVu"
            :type-chuc-vu="typeChucVu"
          ></info-chuc-vu-autocomplete>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-12">
          <info-linh-muc-autocomplete
            @on-select-linh-muc="_selectThuyenChuyenFromLinhMuc"
            :name="linhMucName"
          ></info-linh-muc-autocomplete>
        </div>
      </div>  
      <div class="form-group">
        <label class="col-sm-3 control-label">Thời gian đến <br> (ngày tháng năm)</label>
        <div class="col-sm-9" style="display: inline-flex">
          <input
            v-model="dia_diem_tu_ngay"
            type="number"
            max="2"
            min="0"
            class="form-control"
            style="max-width: 30%; text-align: right"
          />
          <label style="font-size: 20px">-</label>
          <input
            v-model="dia_diem_tu_thang"
            type="number"
            max="2"
            min="0"
            class="form-control"
            style="max-width: 30%; text-align: right"
          />
          <label style="font-size: 20px">-</label>
          <input
            v-model="dia_diem_tu_nam"
            type="number"
            max="4"
            min="0"
            class="form-control"
            style="max-width: 35%; text-align: right"
          />
          <cms-date-picker
            value-type="format"
            format="YYYY-MM-DD"
            v-model="from_date"
            type="date"
          ></cms-date-picker>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">Thời gian đi <br> (ngày tháng năm)</label>
        <div class="col-sm-9" style="display: inline-flex">
          <input
            v-model="dia_diem_den_ngay"
            type="number"
            max="2"
            min="0"
            class="form-control"
            style="max-width: 30%; text-align: right"
          />
          <label style="font-size: 20px">-</label>
          <input
            v-model="dia_diem_den_thang"
            type="number"
            max="2"
            min="0"
            class="form-control"
            style="max-width: 30%; text-align: right"
          />
          <label style="font-size: 20px">-</label>
          <input
            v-model="dia_diem_den_nam"
            type="number"
            max="4"
            min="0"
            class="form-control"
            style="max-width: 38%; text-align: right"
          />
          <cms-date-picker
            value-type="format"
            format="YYYY-MM-DD"
            v-model="to_date"
            type="date"
          ></cms-date-picker>
        </div>
      </div>
    </template>
    <template #cms_modal_btn_group>
      <input
        type="button"
        value="Đóng"
        class="btn btn-danger"
        @click="_hideModalEdit"
      />
      <input
        type="button"
        value="Thêm"
        class="btn btn-primary"
        @click.prevent="_updateInfo"
      />
    </template>
  </the-modal-resizable>
</template>

<script>
import { mapActions, mapGetters} from 'vuex'
import { MODULE_MODULE_GIAO_XU_EDIT, } from 'store@admin/types/module-types'
import TheModalResizable from 'com@admin/Modal/TheModalResizable'
import InfoChucVuAutocomplete from '../../Groups/InfoChucVuAutocomplete'
import InfoGiaoXuAutocomplete from '../../Groups/InfoGiaoXuAutocomplete'
import InfoCoSoGiaoPhanAutocomplete from '../../Groups/InfoCoSoGiaoPhanAutocomplete'
import InfoDongAutocomplete from '../../Groups/InfoDongAutocomplete'
import InfoBanChuyenTrachAutocomplete from '../../Groups/InfoBanChuyenTrachAutocomplete'
import InfoLinhMucAutocomplete from '../../Groups/InfoLinhMucAutocomplete'
const thuyenChuyen = {
  chucVuName: '',
  chuc_vu_id: '',
	linhMucName: '',
	linh_muc_id: '',
  diaDiemName: '',
  giao_xu_id: '',
  dia_diem_loai: '',
  dia_diem_tu_ngay: '',
  dia_diem_tu_thang: '',
  dia_diem_tu_nam: '',
  from_date: '',
  dia_diem_den_ngay: '',
  dia_diem_den_thang: '',
  dia_diem_den_nam: '',
  to_date: '',
  active: 1,
	chuc_vu_active: 1,
	co_so_gp_id: 0,
	dong_id: 0,
	ban_chuyen_trach_id: 0,
	ghi_chu: '',
	du_hoc: 0,
}

export default {
  name: 'TheModalLmThuyenChuyen',
  components: {
    TheModalResizable,
    InfoChucVuAutocomplete,
    InfoGiaoXuAutocomplete,
    InfoCoSoGiaoPhanAutocomplete,
    InfoDongAutocomplete,
    InfoBanChuyenTrachAutocomplete,
		InfoLinhMucAutocomplete
  },
  props: {
    typeChucVu: {
      default() {
        return 1
      } 
    },
		item: {
      default: {},
    },
  },
  data() {
    return {
      ...thuyenChuyen,
      isGiaoXu: 1,
      isCoSo: 2,
      isDong: 3,
      isBanChuyenTrach: 4,
    }
  },
  watch: {
    from_date(val) {
      if (val) {
        this._setTuNgayThangNam(val)
      }
    },
    to_date(val) {
      if (val) {
        this._setDenNgayThangNam(val)
      }
    },
  },
  computed: {
    _showDiaDiem() {
      return this.dia_diem_loai
    },
  },
	created() {
			this.$data.linhMucName = this.item.tenThanh + '|' + this.item.linhMucName 
      this.$data.linh_muc_id = this.item.linh_muc_id
			this.$data.chucVuName = this.item.chucvuName
			this.$data.chuc_vu_id = this.item.chuc_vu_id
			this.$data.from_date = this.item.label_from_date
			this.$data.to_date = this.item.label_to_date
			this._setTuNgayThangNam(this.item.label_from_date)
			this._setDenNgayThangNam(this.item.label_to_date)
	},
  methods: {
    ...mapActions(MODULE_MODULE_GIAO_XU_EDIT, ['updateThuyenChuyen']),
    _setTuNgayThangNam(val) {
      const arrDate = this.$helper.fn_split_date_time(val)
      this.$data.dia_diem_tu_nam = arrDate[0]
      this.$data.dia_diem_tu_thang = arrDate[1]
      this.$data.dia_diem_tu_ngay = arrDate[2]
    },
    _setDenNgayThangNam(val) {
      const arrDate = this.$helper.fn_split_date_time(val)
      this.$data.dia_diem_den_nam = arrDate[0]
      this.$data.dia_diem_den_thang = arrDate[1]
      this.$data.dia_diem_den_ngay = arrDate[2]
    },
    _hideModalEdit() {
      this.$modal.hide(this.$options.setting.modal_name)
    },
    _selectThuyenChuyenFromChucVu(chucVu) {
      this.$data.chucVuName = chucVu.name
      this.$data.chuc_vu_id = chucVu.id
    },
		_selectThuyenChuyenFromLinhMuc(chucVu) {
      this.$data.linhMucName = chucVu.name
      this.$data.linh_muc_id = chucVu.id
    },
    _selectThuyenChuyenFromGiaoXu(giaoXu) {
      this.$data.diaDiemName = giaoXu.name
      this.$data.giao_xu_id = giaoXu.id
    },
    _selectThuyenChuyenCoSoGiaoPhan(coso) {
      this.$data.diaDiemName = coso.name
      this.$data.co_so_gp_id = coso.id
    },
    _selectThuyenChuyenDong(dong) {
      this.$data.diaDiemName = dong.name
      this.$data.dong_id = dong.id
    },
    _selectThuyenChuyenBanChuyenTrach(bcTrach) {
      this.$data.diaDiemName = bcTrach.name
      this.$data.ban_chuyen_trach_id = bcTrach.id
    },
    _resetModal() {
      this.$data.chucVuName = ''
      this.$data.chuc_vu_id = ''
			this.$data.linhMucName = ''
      this.$data.linh_muc_id = ''
      this.$data.dia_diem_loai = ''
      this.$data.diaDiemName = ''
      this.$data.giao_xu_id = ''
      this.$data.dia_diem_tu_ngay = ''
      this.$data.dia_diem_tu_thang = ''
      this.$data.dia_diem_tu_nam = ''
      this.$data.from_date = ''
      this.$data.dia_diem_den_ngay = ''
      this.$data.dia_diem_den_thang = ''
      this.$data.dia_diem_den_nam = ''
      this.$data.to_date = ''
      this.$data.active = 1
			this.$data.chuc_vu_active = 1
			this.$data.co_so_gp_id = 0
			this.$data.dong_id = 0
			this.$data.ban_chuyen_trach_id = 0
			this.$data.ghi_chu = ''
			this.$data.du_hoc = 0
    },
    _updateInfo() {
      const data = this.$data
      if (data.chuc_vu_id && data.linh_muc_id) {
          this.updateThuyenChuyen({
          action: 'update.thuyen.chuyen',
          data: data,
					id_thuyen_chuyen: this.item.id,
					giaoxuId: this.$route.params.giaoxuId,
        })
        this._resetModal()
        this.$modal.hide(this.$options.setting.modal_name)
      } else {
        alert('Nhập thông tin thuyên chuyển')
      }
    },
  },
  setting: {
    modal_title: 'Cập nhật Thuyên Chuyển',
    modal_name: 'modal-thuyen-chuyen-edit',
    keyChucVu: 'chuc_vu_thuyen_chuyen',
  },
}
</script>