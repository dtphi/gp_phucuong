<template style="width:fit-content;" >
  <div class="panel panel-default" style="height: 100%; overflow: auto">
    <div class="panel-heading cms-modal-heading">
      <h3 class="panel-title">{{ title }}</h3>
    </div>
    <div class="panel-body">
      <form class="form-horizontal cms-modal-form">
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
          <label class="col-sm-3">Loại địa điểm</label>
          <div class="col-sm-9">
            <select class="form-control" v-model="dia_diem_loai">
              <option
                v-for="(item, idx) in $cmsCfg.loaiDiaDiems"
                :key="idx"
                :value="idx"
              >
                {{ item }}
              </option>
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
            <info-cong-doan-ngoai-autocomplete
              v-if="_showDiaDiem === isCongDoanNgoai"
              @on-select-cong-doan-ngoai-giao-phan="
                _selectThuyenChuyenCongDoanNgoai
              "
              :name="diaDiemName"
              :key="`cong_doan_ngoai${dia_diem_loai}`"
            ></info-cong-doan-ngoai-autocomplete>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4"
            >Thời gian đến</label
          >
          <div class="col-sm-8" style="display: inline-flex">
            <span style="font-size: 15px;">Năm-</span>
            <select class="form-select form-select-lg" v-model="dia_diem_tu_nam">
                <option selected hidden>Năm</option>
                <option value="0" ></option>
                <option v-for="year in 3000">{{year}}</option>
              </select>
            <!-- <input
              v-model="dia_diem_tu_ngay"
              type="number"
              max="2"
              min="0"
              class="form-control"
              style="max-width: 30%; text-align: right"
            /> -->
            <span style="font-size: 15px;">-Tháng-</span>
            <select class="form-select form-select-lg" @change="onTuThang($event)" v-model="dia_diem_tu_thang">
                <option selected hidden>Tháng</option>
                <option value="0" ></option>
                <option v-for="month in months">{{month}}</option>
              </select>
            <!-- <input
              v-model="dia_diem_tu_thang"
              type="number"
              max="2"
              min="0"
              class="form-control"
              style="max-width: 30%; text-align: right"
            /> -->
            <span style="font-size: 15px; ">-Ngày-</span>
            <select class="form-select form-select-lg" :disabled="dia_diem_tu_thang==='0'?true:false"  v-model="dia_diem_tu_ngay">
                <option selected hidden>Ngày</option>
                <option value="0" ></option>
                <option v-for="day in days">{{day}}</option>
              </select>
            <!-- <input
              v-model="dia_diem_tu_nam"
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
            <select class="form-select form-select-lg" v-model="dia_diem_den_nam">
                <option selected hidden>Năm</option>
                <option value="0" ></option>
                <option v-for="year in 3000">{{year}}</option>
              </select>
            <!-- <input
              v-model="dia_diem_tu_ngay"
              type="number"
              max="2"
              min="0"
              class="form-control"
              style="max-width: 30%; text-align: right"
            /> -->
            <span style="font-size: 15px;">-Tháng-</span>
            <select class="form-select form-select-lg" @change="onDenThang($event)" v-model="dia_diem_den_thang">
                <option selected hidden>Tháng</option>
                <option value="0" ></option>
                <option v-for="month in months">{{month}}</option>
              </select>
            <!-- <input
              v-model="dia_diem_tu_thang"
              type="number"
              max="2"
              min="0"
              class="form-control"
              style="max-width: 30%; text-align: right"
            /> -->
            <span style="font-size: 15px; ">-Ngày-</span>
            <select class="form-select form-select-lg" :disabled="dia_diem_den_thang!='0'?false:true" v-model="dia_diem_den_ngay">
                <option selected hidden>Ngày</option>
                <option value="0" ></option>
                <option v-for="day in days">{{day}}</option>
              </select>
            <!-- <input
              v-model="dia_diem_tu_nam"
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
      </form>
      <div class="cms-modal-footer-btn">
        <div class="text-center cms-modal-group-btn">
          <input
            type="button"
            value="Đóng"
            class="btn btn-danger"
            @click="_hideModalEdit"
          />
          <input
            type="button"
            value="Sửa"
            class="btn btn-primary"
            @click.prevent="_submitUpdate"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapState } from 'vuex'
import { ACTION_RESET_NOTIFICATION_INFO } from 'store@admin/types/action-types'
import { MODULE_MODULE_LINH_MUC_EDIT } from 'store@admin/types/module-types'
import TheModalResizable from 'com@admin/Modal/TheModalResizable'
import InfoChucVuAutocomplete from '../../Groups/InfoChucVuAutocomplete'
import InfoGiaoXuAutocomplete from '../../Groups/InfoGiaoXuAutocomplete'
import InfoCoSoGiaoPhanAutocomplete from '../../Groups/InfoCoSoGiaoPhanAutocomplete'
import InfoDongAutocomplete from '../../Groups/InfoDongAutocomplete'
import InfoBanChuyenTrachAutocomplete from '../../Groups/InfoBanChuyenTrachAutocomplete'
import InfoCongDoanNgoaiAutocomplete from '../../Groups/InfoCongDoanNgoaiAutocomplete'
const thuyenChuyen = {
  chucVuName: '',
  chuc_vu_id: '',
  linhMucName: '',
  linh_muc_id: '',
  diaDiemName: '',
  giao_xu_id: '',
  dia_diem_loai: '',
  dia_diem_tu_ngay: '0',
  dia_diem_tu_thang: '0',
  dia_diem_tu_nam: '0',
  from_date: '',
  dia_diem_den_ngay: '0',
  dia_diem_den_thang: '0',
  dia_diem_den_nam: '0',
  to_date: '',
  active: 1,
  chuc_vu_active: 1,
  co_so_gp_id: 0,
  dong_id: 0,
  ban_chuyen_trach_id: 0,
  giao_xu_id: 0,
  ghi_chu: '',
  co_so_status: '',
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
    InfoCongDoanNgoaiAutocomplete,
  },
  props: {
    typeChucVu: {
      default() {
        return 1
      },
    },
    info: {
      type: Object,
      require: true,
    },
    icon: {
      default: 'fa fa-plus',
    },
    title: {
      default: 'Cập nhật Thuyên Chuyển',
    },
  },
  data() {
    return {
      ...thuyenChuyen,
      isGiaoXu: 1,
      isCoSo: 2,
      isDong: 3,
      isBanChuyenTrach: 4,
      isCongDoanNgoai: 5,
      days:['01','02','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'],
      months:['01','02','04','05','06','07','08','09','10','11','12'],
    }
  },
  computed: {
    ...mapState(MODULE_MODULE_LINH_MUC_EDIT, ['updateSuccess']),
    _showDiaDiem() {
      return this.dia_diem_loai
    },
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
    updateSuccess(newValue, oldValue) {
      if (newValue) {
        this._notificationUpdate(newValue)
      }
    },
  },
  created() {
    this.$data.id = this.info.id
    this.$data.chuc_vu_id = this.info.chuc_vu_id
    this.$data.chucVuName = this.info.chucvuName
    this.$data.from_date = this.info.label_from_date
    this.$data.to_date = this.info.label_to_date
    if (this.info.giao_xu_id !== 0) {
      this.$data.dia_diem_loai = 1
      this.$data.giao_xu_id = this.info.giao_xu_id
      this.$data.diaDiemName = this.info.giaoxuName
    } else if (this.info.co_so_gp_id !== 0  && this.info.co_so_status === 1) {
      this.$data.dia_diem_loai = 2
      this.$data.co_so_gp_id = this.info.co_so_gp_id
      this.$data.diaDiemName = this.info.cosogpName
      this.$data.is_co_so_giao_phan = this.info.is_co_so_giao_phan
    } else if (this.info.dong_id !== 0) {
      this.$data.dia_diem_loai = 3
      this.$data.dong_id = this.info.dong_id
      this.$data.diaDiemName = this.info.dongName
    } else if (this.info.co_so_gp_id !== 0 && this.info.co_so_status === 0) {
      this.$data.dia_diem_loai = 5
      this.$data.co_so_gp_id = this.info.co_so_gp_id
      this.$data.diaDiemName = this.info.cosogpName
    } else {
      this.$data.dia_diem_loai = 4
      this.$data.ban_chuyen_trach_id = this.info.ban_chuyen_trach_id
      this.$data.diaDiemName = this.info.banchuyentrachName
    }
  },
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC_EDIT, [
      'updateThuyenChuyen',
      ACTION_RESET_NOTIFICATION_INFO,
    ]),
    _setTuNgayThangNam(val) {
      const arrDate = this.$helper.fn_split_date_time(val)
      this.$data.dia_diem_tu_nam = arrDate[0]
      this.$data.dia_diem_tu_thang = arrDate[1]?arrDate[1]:'0'
      this.$data.dia_diem_tu_ngay = arrDate[2]?arrDate[2]:'0'
    },
    _setDenNgayThangNam(val) {
      const arrDate = this.$helper.fn_split_date_time(val)
      this.$data.dia_diem_den_nam = arrDate[0]
      this.$data.dia_diem_den_thang = arrDate[1]?arrDate[1]:'0'
      this.$data.dia_diem_den_ngay = arrDate[2]?arrDate[2]:'0'
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
      this.$data.giao_xu_id = giaoXu.id
      this.$data.co_so_gp_id = 0
      this.$data.dong_id = 0
      this.$data.ban_chuyen_trach_id = 0
    },
    _selectThuyenChuyenCoSoGiaoPhan(coso) {
      this.$data.diaDiemName = coso.name
      this.$data.co_so_gp_id = coso.id
      this.$data.co_so_status = 1
      this.$data.giao_xu_id = 0
      this.$data.dong_id = 0
      this.$data.ban_chuyen_trach_id = 0
    },
    _selectThuyenChuyenDong(dong) {
      this.$data.diaDiemName = dong.name
      this.$data.dong_id = dong.id
      this.$data.giao_xu_id = 0
      this.$data.co_so_gp_id = 0
      this.$data.ban_chuyen_trach_id = 0
    },
    _selectThuyenChuyenBanChuyenTrach(bcTrach) {
      this.$data.diaDiemName = bcTrach.name
      this.$data.ban_chuyen_trach_id = bcTrach.id
      this.$data.giao_xu_id = 0
      this.$data.co_so_gp_id = 0
      this.$data.dong_id = 0
    },
    _selectThuyenChuyenCongDoanNgoai(cdNgoai) {
      this.$data.diaDiemName = cdNgoai.name
      this.$data.co_so_gp_id = cdNgoai.id
      this.$data.co_so_status = 0
      this.$data.giao_xu_id = 0
      this.$data.dong_id = 0
      this.$data.ban_chuyen_trach_id = 0
    },

    _resetModal() {
      this.$data.chucVuName = ''
      this.$data.chuc_vu_id = ''
      this.$data.linhMucName = ''
      this.$data.linh_muc_id = ''
      this.$data.dia_diem_loai = ''
      this.$data.diaDiemName = ''
      this.$data.dia_diem_tu_ngay = '0'
      this.$data.dia_diem_tu_thang = '0'
      this.$data.dia_diem_tu_nam = '0'
      this.$data.from_date = ''
      this.$data.dia_diem_den_ngay = '0'
      this.$data.dia_diem_den_thang = '0'
      this.$data.dia_diem_den_nam = '0'
      this.$data.to_date = ''
      this.$data.active = 1
      this.$data.chuc_vu_active = 1
      this.$data.co_so_gp_id = 0
      this.$data.dong_id = 0
      this.$data.ban_chuyen_trach_id = 0
      this.$data.giao_xu_id = 0
      this.$data.ghi_chu = ''
      this.$data.du_hoc = 0
      this.$data.is_co_so_giao_phan = ''
    },
    _submitUpdate() {
      const data = this.$data
      console.log(this.dia_diem_tu_nam+'-'+this.dia_diem_tu_thang+'-'+this.dia_diem_tu_thang)
      if (data.chuc_vu_id) {
        this.updateThuyenChuyen({
          action: 'update.thuyen.chuyen',
          data: data,
          id_thuyen_chuyen: this.info.id,
          linhMucId: this.$route.params.linhmucId,
        })
        this._resetModal
        this.$nextTick(() => {
          this.$emit('update-info-success')
        })
      } else {
        alert('Nhập thông tin thuyên chuyển')
      }
    },
    _notificationUpdate(notification) {
      if (notification.type == 'success') {
        this.$emit('update-info-success')
      }
      this.$notify(notification)
      this.resetNotification()
    },
    onTuThang(event){ 
      if(event.target.value=="0")
      this.dia_diem_tu_ngay='0' 
    },
    onDenThang(event){ 
      if(event.target.value=="0")
      this.dia_diem_den_ngay='0' 
    },
  },
  setting: {
    modal_title: 'Cập nhật Thuyên Chuyển',
    modal_name: 'modal-lm-thuyen-chuyen-edit',
    keyChucVu: 'chuc_vu_thuyen_chuyen',
  },
}
</script>
<style scoped lang="scss">
.cms-modal-heading {
  color: #eeeeeee8;
  position: absolute;
  width: 100%;
  border-color: #784545;
  background: #2e2222b3;
  z-index: 999999;
}
.cms-modal-form {
  padding: 25px;
}
.cms-modal-footer-btn {
  position: absolute;
  right: 0px;
  bottom: 0px;
  width: 100%;
  background-color: #0e212a;

  .cms-modal-group-btn {
    padding: 10px;
  }
  .label-unbold {
    font-size: 1em;
    font-weight: unset;
    cursor: auto;
  }
}
</style>