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
          <label class="col-sm-4"
            >Thời gian đến</label
          >
          <div class="col-sm-8" style="display: inline-flex">
            <span style="font-size: 15px;">Năm-</span>
            <select class="form-select form-select-lg" v-model="cong_viec_tu_nam">
                <option selected hidden>Năm</option>
                <option value="0" ></option>
                <option v-for="year in Array.from(new Array(151), (x, i) => i + 1900)">{{year}}</option>
              </select>
            <!-- <input
              v-model="cong_viec_tu_ngay"
              type="number"
              max="2"
              min="0"
              class="form-control"
              style="max-width: 30%; text-align: right"
            /> -->
            <span style="font-size: 15px;">-Tháng-</span>
            <select class="form-select form-select-lg" @change="onTuThang($event)" v-model="cong_viec_tu_thang">
                <option selected hidden>Tháng</option>
                <option value="0" ></option>
                <option v-for="month in months">{{month}}</option>
              </select>
            <!-- <input
              v-model="cong_viec_tu_thang"
              type="number"
              max="2"
              min="0"
              class="form-control"
              style="max-width: 30%; text-align: right"
            /> -->
            <span style="font-size: 15px; ">-Ngày-</span>
            <select class="form-select form-select-lg" :disabled="cong_viec_tu_thang==='0'?true:false"  v-model="cong_viec_tu_ngay">
                <option selected hidden>Ngày</option>
                <option value="0" ></option>
                <option v-for="day in days">{{day}}</option>
              </select>
            <!-- <input
              v-model="cong_viec_tu_nam"
              type="number"
              max="4"
              min="0"
              class="form-control"
              style="max-width: 35%; text-align: right"
            /> -->
            <!-- <cms-date-picker
              value-type="format"
              format="YYYY-MM-DD"
              v-model="from_date"
              type="date"
            ></cms-date-picker> -->
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4"
            >Thời gian đi</label>
            <div class="col-sm-8" style="display: inline-flex">
            <span style="font-size: 15px;">Năm-</span>
            <select class="form-select form-select-lg" v-model="cong_viec_den_nam">
                <option selected hidden>Năm</option>
                <option value="0" ></option>
                <option v-for="year in Array.from(new Array(151), (x, i) => i + 1900)">{{year}}</option>
              </select>
            <!-- <input
              v-model="cong_viec_tu_ngay"
              type="number"
              max="2"
              min="0"
              class="form-control"
              style="max-width: 30%; text-align: right"
            /> -->
            <span style="font-size: 15px;">-Tháng-</span>
            <select class="form-select form-select-lg" @change="onDenThang($event)" v-model="cong_viec_den_thang">
                <option selected hidden>Tháng</option>
                <option value="0" ></option>
                <option v-for="month in months">{{month}}</option>
              </select>
            <!-- <input
              v-model="cong_viec_tu_thang"
              type="number"
              max="2"
              min="0"
              class="form-control"
              style="max-width: 30%; text-align: right"
            /> -->
            <span style="font-size: 15px; ">-Ngày-</span>
            <select class="form-select form-select-lg" :disabled="cong_viec_den_thang!='0'?false:true" v-model="cong_viec_den_ngay">
                <option selected hidden>Ngày</option>
                <option value="0" ></option>
                <option v-for="day in days">{{day}}</option>
              </select>
            <!-- <input
              v-model="cong_viec_tu_nam"
              type="number"
              max="4"
              min="0"
              class="form-control"
              style="max-width: 35%; text-align: right"
            /> -->
            <!-- <cms-date-picker
              value-type="format"
              format="YYYY-MM-DD"
              v-model="from_date"
              type="date"
            ></cms-date-picker> -->
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
import { mapState, mapActions } from 'vuex'
import {
    ACTION_RESET_NOTIFICATION_INFO 
} from 'store@admin/types/action-types';
import { MODULE_MODULE_LINH_MUC_EDIT, } from 'store@admin/types/module-types'
import TheModalResizable from 'com@admin/Modal/TheModalResizable'
import InfoChucVuAutocomplete from '../../Groups/InfoChucVuAutocomplete'
const boNhiem = {
  chucVuName: '',
  chuc_vu_id: '',
  cong_viec: '',
  cong_viec_tu_ngay: '0',
  cong_viec_tu_thang: '0',
  cong_viec_tu_nam: '0',
  tu_ngay_thang_nam: '',
  cong_viec_den_ngay: '0',
  cong_viec_den_thang: '0',
  cong_viec_den_nam: '0',
  den_ngay_thang_nam: '',
  active: 1,
}

export default {
  name: 'TheModalBoNhiemKhac',
  components: {
    TheModalResizable,
    InfoChucVuAutocomplete,
  },
  props: {
    typeChucVu: {
      default() {
        return 0
      } 
    },
		info: {
				type: Object,
				require: true,
		},
  },
  data() {
    return {
      ...boNhiem,
      days:['01','02','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'],
      months:['01','02','04','05','06','07','08','09','10','11','12'],
    }
  },
	computed: {
		...mapState(MODULE_MODULE_LINH_MUC_EDIT, [
			'updateSuccess',
		]),
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
		'updateSuccess'(newValue, oldValue) {
				if (newValue) {
						this._notificationUpdate(newValue);
				}
		},
  },
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC_EDIT, ['addBoNhiem']),
    _setTuNgayThangNam(val) {
      const arrDate = this.$helper.fn_split_date_time(val)
      this.$data.cong_viec_tu_nam = arrDate[0]
      this.$data.cong_viec_tu_thang = arrDate[1]?arrDate[1]:'0'
      this.$data.cong_viec_tu_ngay = arrDate[2]?arrDate[2]:'0'
    },
    _setDenNgayThangNam(val) {
      const arrDate = this.$helper.fn_split_date_time(val)
      this.$data.cong_viec_den_nam = arrDate[0]
      this.$data.cong_viec_den_thang = arrDate[1]?arrDate[1]:'0'
      this.$data.cong_viec_den_ngay = arrDate[2]?arrDate[2]:'0'
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
      this.$data.cong_viec_tu_ngay = '0'
      this.$data.cong_viec_tu_thang = '0'
      this.$data.cong_viec_tu_nam = '0'
      this.$data.tu_ngay_thang_nam = ''
      this.$data.cong_viec_den_ngay = '0'
      this.$data.cong_viec_den_thang = '0'
      this.$data.cong_viec_den_nam = '0'
      this.$data.den_ngay_thang_nam = ''
      this.$data.active = 1
    },
    onTuThang(event){ 
      if(event.target.value=="0")
      this.cong_viec_tu_ngay='0' 
    },
    onDenThang(event){ 
      if(event.target.value=="0")
      this.cong_viec_den_ngay='0' 
    },
    async _addInfo() {
      const data = this.$data
      if (data.chuc_vu_id) {
        await this.addBoNhiem({
          action: 'addBoNhiem',
          data: data
        })
        this._resetModal()
        this.$modal.hide(this.$options.setting.modal_name)
      } else {
        alert('Nhập thông tin bổ nhiệm')
      }
    },
  },
  setting: {
    modal_title: 'Thêm Bổ Nhiệm Khác',
    modal_name: 'modal-lm-bo-nhiem-add',
    keyChucVu: 'chuc_vu_bo_nhiem',
  },
}
</script>