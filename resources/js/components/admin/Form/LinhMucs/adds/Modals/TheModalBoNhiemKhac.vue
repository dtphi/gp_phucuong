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
          ></info-chuc-vu-autocomplete>
        </div>
      </div>
      <div class="form-group">
        <label for="input-info-name" class="col-sm-3 control-label"
          >Công việc</label
        >
        <div class="col-sm-9">
          <validation-provider
            name="info_cong_viec"
            rules="max:200"
            v-slot="{ errors }"
          >
            <textarea
              rows="5"
              class="form-control"
              v-model="cong_viec"
            ></textarea>
            <span class="cms-text-red">{{ errors[0] }}</span>
          </validation-provider>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">Từ (ngày tháng năm)</label>
        <div class="col-sm-9" style="display: inline-flex">
          <input
            v-model="cong_viec_tu_ngay"
            type="number"
            max="2"
            min="0"
            class="form-control"
            style="max-width: 30%; text-align: right"
          />
          <label style="font-size: 20px">-</label>
          <input
            v-model="cong_viec_tu_thang"
            type="number"
            max="2"
            min="0"
            class="form-control"
            style="max-width: 30%; text-align: right"
          />
          <label style="font-size: 20px">-</label>
          <input
            v-model="cong_viec_tu_nam"
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
        <label class="col-sm-3 control-label">Đến (ngày tháng năm)</label>
        <div class="col-sm-9" style="display: inline-flex">
          <input
            v-model="cong_viec_den_ngay"
            type="number"
            max="2"
            min="0"
            class="form-control"
            style="max-width: 30%; text-align: right"
          />
          <label style="font-size: 20px">-</label>
          <input
            v-model="cong_viec_den_thang"
            type="number"
            max="2"
            min="0"
            class="form-control"
            style="max-width: 30%; text-align: right"
          />
          <label style="font-size: 20px">-</label>
          <input
            v-model="cong_viec_den_nam"
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
import { MODULE_MODULE_LINH_MUC_ADD, } from 'store@admin/types/module-types'
import TheModalResizable from 'com@admin/Modal/TheModalResizable'
import InfoChucVuAutocomplete from '../../Groups/InfoChucVuAutocomplete'
const boNhiem = {
  chucVuName: '',
  chuc_vu_id: '',
  cong_viec: '',
  cong_viec_tu_ngay: '',
  cong_viec_tu_thang: '',
  cong_viec_tu_nam: '',
  tu_ngay_thang_nam: '',
  cong_viec_den_ngay: '',
  cong_viec_den_thang: '',
  cong_viec_den_nam: '',
  den_ngay_thang_nam: '',
  active: 1,
}

export default {
  name: 'TheModalBoNhiemKhac',
  components: {
    TheModalResizable,
    InfoChucVuAutocomplete,
  },
  data() {
    return boNhiem
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
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC_ADD, ['addBoNhiem']),
    _setTuNgayThangNam(val) {
      const arrDate = this.$helper.fn_split_date_time(val)
      this.$data.cong_viec_tu_nam = arrDate[0]
      this.$data.cong_viec_tu_thang = arrDate[1]
      this.$data.cong_viec_tu_ngay = arrDate[2]
    },
    _setDenNgayThangNam(val) {
      const arrDate = this.$helper.fn_split_date_time(val)
      this.$data.cong_viec_den_nam = arrDate[0]
      this.$data.cong_viec_den_thang = arrDate[1]
      this.$data.cong_viec_den_ngay = arrDate[2]
    },
    _hideModalEdit() {
      this.$modal.hide(this.$options.setting.modal_name)
    },
    _selectThuyenChuyenFromChucVu(chucVu) {
      this.$data.chucVuName = chucVu.name
      this.$data.chuc_vu_id = chucVu.id
    },
    _resetModal() {
      this.$data.chucVuName = ''
      this.$data.chuc_vu_id = ''
      this.$data.cong_viec = ''
      this.$data.cong_viec_tu_ngay = ''
      this.$data.cong_viec_tu_thang = ''
      this.$data.cong_viec_tu_nam = ''
      this.$data.tu_ngay_thang_nam = ''
      this.$data.cong_viec_den_ngay = ''
      this.$data.cong_viec_den_thang = ''
      this.$data.cong_viec_den_nam = ''
      this.$data.den_ngay_thang_nam = ''
      this.$data.active = 1
    },
    async _addInfo() {
      const data = this.$data
      if (data.chuc_vu_id) {
        await this.addBoNhiem({
          action: 'addBoNhiem',
          data: data
        })
        this._resetModal()
      } else {
        alert('Nhập thông tin bổ nhiệm')
      }
    },
  },
  setting: {
    modal_title: 'Thêm Bổ Nhiệm Khác',
    modal_name: 'modal-linh-muc-bo-nhiem-add',
    keyChucVu: 'chuc_vu_bo_nhiem',
  },
}
</script>