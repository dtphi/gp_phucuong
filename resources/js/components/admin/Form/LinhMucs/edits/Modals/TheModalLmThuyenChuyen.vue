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
        <label class="col-sm-3 control-label"
          >Loại địa điểm</label
        >
        <div class="col-sm-9">
          <select class="form-control" v-model="dia_diem_loai">
            <option v-for="(item, idx) in $cmsCfg.loaiDiaDiems" :key="idx" :value="idx">{{ item }}</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-12">
          <info-giao-xu-autocomplete
            v-if="_showDiaDiem === isGiaoXu"
            @on-select-giao-xu="_selectThuyenChuyenFromGiaoXu"
            :name="diaDiemName"
            :key="`giao_xu_${dia_diem_loai}`"
          ></info-giao-xu-autocomplete>
          <info-co-so-giao-phan-autocomplete
            v-if="_showDiaDiem === isCoSo"
            @on-select-co-so-giao-phan="_selectThuyenChuyenCoSoGiaoPhan"
            :name="diaDiemName"
            :key="`co_so_giao_phan_${dia_diem_loai}`"
          ></info-co-so-giao-phan-autocomplete>
          <info-dong-autocomplete
            v-if="_showDiaDiem === isDong"
            @on-select-dong="_selectThuyenChuyenDong"
            :name="diaDiemName"
            :key="`dong_${dia_diem_loai}`"
          ></info-dong-autocomplete>
          <info-ban-chuyen-trach-autocomplete
            v-if="_showDiaDiem === isBanChuyenTrach"
            @on-select-ban-chuyen-trach="_selectThuyenChuyenBanChuyenTrach"
            :name="diaDiemName"
            :key="`ban_chuyen_trach_${dia_diem_loai}`"
          ></info-ban-chuyen-trach-autocomplete>
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
            v-model="tu_ngay_thang_nam"
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
            v-model="den_ngay_thang_nam"
            type="date"
          ></cms-date-picker>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">Trạng thái</label>
        <div class="col-sm-9">
          <select class="form-control" v-model="active">
            <option value="1" :selected="active == 1">Xảy ra</option>
            <option value="0" :selected="active == 0">Ẩn</option>
          </select>
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
        @click.prevent="_addInfo"
      />
    </template>
  </the-modal-resizable>
</template>

<script>
import { mapActions, } from 'vuex'
import { MODULE_MODULE_LINH_MUC_EDIT, } from 'store@admin/types/module-types'
import TheModalResizable from 'com@admin/Modal/TheModalResizable'
import InfoChucVuAutocomplete from '../../Groups/InfoChucVuAutocomplete'
import InfoGiaoXuAutocomplete from '../../Groups/InfoGiaoXuAutocomplete'
import InfoCoSoGiaoPhanAutocomplete from '../../Groups/InfoCoSoGiaoPhanAutocomplete'
import InfoDongAutocomplete from '../../Groups/InfoDongAutocomplete'
import InfoBanChuyenTrachAutocomplete from '../../Groups/InfoBanChuyenTrachAutocomplete'
const thuyenChuyen = {
  chucVuName: '',
  chuc_vu_id: '',
  diaDiemName: '',
  dia_diem_id: '',
  dia_diem_loai: '',
  dia_diem_tu_ngay: '',
  dia_diem_tu_thang: '',
  dia_diem_tu_nam: '',
  tu_ngay_thang_nam: '',
  dia_diem_den_ngay: '',
  dia_diem_den_thang: '',
  dia_diem_den_nam: '',
  den_ngay_thang_nam: '',
  active: 1,
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
  },
  props: {
    typeChucVu: {
      default() {
        return 1
      } 
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
    tu_ngay_thang_nam(val) {
      if (val) {
        this._setTuNgayThangNam(val)
      }
    },
    den_ngay_thang_nam(val) {
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
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC_EDIT, ['addLmThuyenChuyen']),
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
    _selectThuyenChuyenFromGiaoXu(giaoXu) {
      this.$data.diaDiemName = giaoXu.name
      this.$data.dia_diem_id = giaoXu.id
    },
    _selectThuyenChuyenCoSoGiaoPhan(coso) {
      this.$data.diaDiemName = coso.name
      this.$data.dia_diem_id = coso.id
    },
    _selectThuyenChuyenDong(dong) {
      this.$data.diaDiemName = dong.name
      this.$data.dia_diem_id = dong.id
    },
    _selectThuyenChuyenBanChuyenTrach(bcTrach) {
      this.$data.diaDiemName = bcTrach.name
      this.$data.dia_diem_id = bcTrach.id
    },
    _resetModal() {
      this.$data.chucVuName = ''
      this.$data.chuc_vu_id = ''
      this.$data.dia_diem_loai = ''
      this.$data.diaDiemName = ''
      this.$data.dia_diem_id = ''
      this.$data.dia_diem_tu_ngay = ''
      this.$data.dia_diem_tu_thang = ''
      this.$data.dia_diem_tu_nam = ''
      this.$data.tu_ngay_thang_nam = ''
      this.$data.dia_diem_den_ngay = ''
      this.$data.dia_diem_den_thang = ''
      this.$data.dia_diem_den_nam = ''
      this.$data.den_ngay_thang_nam = ''
      this.$data.active = 1
    },
    async _addInfo() {
      const data = this.$data
      if (data.chuc_vu_id) {
        await this.addLmThuyenChuyen({
          action: 'addLmThuyenChuyen',
          data: data
        })
        this._resetModal()
        this.$modal.hide(this.$options.setting.modal_name)
      } else {
        alert('Nhập thông tin thuyên chuyển')
      }
    },
  },
  setting: {
    modal_title: 'Thêm Lm Thuyên Chuyển',
    modal_name: 'modal-linh-muc-thuyen-chuyen-add',
    keyChucVu: 'chuc_vu_thuyen_chuyen',
  },
}
</script>