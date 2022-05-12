<template>
    <div class="panel panel-default" style="height: 100%; overflow: auto">
      <div class="panel-body">
        <form class="form-horizontal cms-modal-form">
          <div class="form-group">
            <label class="col-sm-3 control-label">Chức vụ:</label>
            <div class="col-sm-12">
              <select
                class="custom-select"
                v-model="select_chuc_vu"
              >
                <option
                  v-for="(item, idx) in dropdownChucVus"
                  :key="idx"
                  :value="item.id"
                  :selected="item.id == select_chuc_vu"
                >
                  {{ item.name }}
                </option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Loại địa điểm</label>
            <div class="col-sm-9">
              <select class="form-control" v-model="dia_diem_loai">
                <option
                  v-for="(item, idx) in loaiDiaDiems"
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
              <!-- Giao_xu -->
              <select
                v-if="_showDiaDiem === isGiaoXu"
                v-model="thuyenChuyen.select_giao_xu"
                @change="onChange()"
                class="custom-select"
              >
                <option
                  v-for="(item, idx) in dropdownGiaoXus"
                  :key="idx"
                  :value="item.id"
                  :selected="item.id === thuyenChuyen.select_giao_xu"
                >
                  {{ item.name }}
                </option>
              </select>
              <!-- Csgp  -->
              <select
                v-if="_showDiaDiem === isCoSo"
                v-model="thuyenChuyen.select_csgp"
                @change="onChange()"
                class="custom-select"
              >
                <option
                  v-for="(item, idx) in dropdownCoSoGiaoPhans"
                  :key="idx"
                  :value="item.id"
                  :selected="item.id === thuyenChuyen.select_csgp"
                >
                  {{ item.name }}
                </option>
              </select>
              <!-- Dong -->
              <select
                v-if="_showDiaDiem === isDong"
                v-model="thuyenChuyen.select_dong"
                @change="onChange()"
                class="custom-select"
              >
                <option
                  v-for="(item, idx) in dropdownDongs"
                  :key="idx"
                  :value="item.id"
                  :selected="item.id === thuyenChuyen.select_dong"
                >
                  {{ item.name }}
                </option>
              </select>
              <!-- Ban_chuyen_trach -->
              <select
                v-if="_showDiaDiem === isBanChuyenTrach"
                v-model="thuyenChuyen.select_bct"
                @change="onChange()"
                class="custom-select"
              >
                <option
                  v-for="(item, idx) in dropdownBanChuyenTrachs"
                  :key="idx"
                  :value="item.id"
                  :selected="item.id === thuyenChuyen.select_bct"
                >
                  {{ item.name }}
                </option>
              </select>
              <!-- Cong_doan_ngoai_giao_phan -->
              <select
                v-if="_showDiaDiem === isCongDoanNgoai"
                v-model="thuyenChuyen.select_csgp"
                @change="onChange()"
                class="custom-select"
              >
                <option
                  v-for="(item, idx) in dropdownCongDoanNgoaiGiaoPhans"
                  :key="idx"
                  :value="item.id"
                  :selected="item.id === thuyenChuyen.select_csgp"
                >
                  {{ item.name }}
                </option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label"
              >Thời gian đến <br />
              ( năm tháng ngày )</label
            >
            <div class="col-sm-9" style="display: inline-flex">
              <input
                v-model="dia_diem_tu_ngay"
                type="number"
                max="2"
                min="0"
                class="form-control"
                style="max-width: 25%; text-align: right"
              />
              <label style="font-size: 20px">-</label>
              <input
                v-model="dia_diem_tu_thang"
                type="number"
                max="2"
                min="0"
                class="form-control"
                style="max-width: 25%; text-align: right"
              />
              <label style="font-size: 20px">-</label>
              <input
                v-model="dia_diem_tu_nam"
                type="number"
                max="4"
                min="0"
                class="form-control"
                style="max-width: 25%; text-align: right"
              />
              <cms-date-picker
                value-type="format"
                format="YYYY-MM-DD"
                v-model="from_date"
                type="date"
                class="form-control"
              ></cms-date-picker>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Thời gian đi <br> ( năm tháng ngày )</label>
            <div class="col-sm-9" style="display: inline-flex">
              <input
                v-model="dia_diem_den_ngay"
                type="number"
                max="2"
                min="0"
                class="form-control"
                style="max-width: 25%; text-align: right"
              />
              <label style="font-size: 20px">-</label>
              <input
                v-model="dia_diem_den_thang"
                type="number"
                max="2"
                min="0"
                class="form-control"
                style="max-width: 25%; text-align: right"
              />
              <label style="font-size: 20px">-</label>
              <input
                v-model="dia_diem_den_nam"
                type="number"
                max="4"
                min="0"
                class="form-control"
                style="max-width: 25%; text-align: right"
              />
              <cms-date-picker
                value-type="format"
                format="YYYY-MM-DD"
                v-model="to_date"
                type="date"
              ></cms-date-picker>
            </div>
          </div>
          <div class="form-group">
            <label for="input-info-status" class="col-sm-3 control-label"
              >Trạng thái chức vụ</label
            >
            <div class="col-sm-10">
              <select class="form-control" v-model="select_status">
                <option value="1" :selected="select_status == 1">Hiện đang giữ</option>
                <option value="0" :selected="select_status == 0">Đã xảy ra</option>
              </select>
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
              value="Thêm"
              class="btn btn-primary"
              @click.prevent="_addInfo"
            />
          </div>
        </div>
      </div>
    </div>
</template>

<script>
import { MODULE_LINH_MUC_DETAIL_PAGE } from '@app/stores/front/types/module-types'
import { mapState, mapActions } from 'vuex'

export default {
  name: 'TheCmsModalResizableEdit',
  props: {
    icon: {
      default: 'fa fa-plus',
    },
    modalName: {
      default: 'modal-resizable',
    },
    info: {
      type: Object,
      require: true
    }
  },
  data() {
    return {
      dia_diem_loai: '',
      isGiaoXu: 1,
      isCoSo: 2,
      isDong: 3,
      isBanChuyenTrach: 4,
      isCongDoanNgoai: 5,
      select_chuc_vu: 0,
      thuyenChuyen: {
        select_giao_xu: 0,
        select_csgp: 0,
        select_dong: 0,
        select_bct: 0,
      },
      select_status: 0,
      loaiDiaDiems: [
        '',
        'Giáo Xứ',
        'Cơ Sở Giáo Phận',
        'Dòng',
        'Ban Chuyên Trách',
        'Cơ sở ngoài giáo phận',
      ],
      from_date: '',
      to_date: '',
      dia_diem_tu_nam: '',
			dia_diem_tu_thang: '',
			dia_diem_tu_ngay: '',
			dia_diem_den_nam: '',
			dia_diem_den_thang: '',
			dia_diem_den_ngay: '',
    }
  },
  created() {
    this.select_chuc_vu = this.info.chuc_vu_id
    this.from_date = this.info.label_from_date
    this.to_date = this.info.label_to_date
    if (this.info.giao_xu_id !== 0) {
      this.dia_diem_loai = 1
      this.thuyenChuyen.select_giao_xu = this.info.giao_xu_id
    } else if (this.info.co_so_gp_id !== 0  && this.info.co_so_status === 1) {
      this.dia_diem_loai = 2
      this.thuyenChuyen.select_csgp = this.info.co_so_gp_id
    } else if (this.info.dong_id !== 0) {
      this.dia_diem_loai = 3
      this.thuyenChuyen.select_dong = this.info.dong_id
    } else if (this.info.co_so_gp_id !== 0 && this.info.co_so_status === 0) {
      this.dia_diem_loai = 5
      this.thuyenChuyen.select_csgp = this.info.co_so_gp_id
    } else {
      this.$data.dia_diem_loai = 4
      this.thuyenChuyen.select_bct = this.info.ban_chuyen_trach_id
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
    ...mapState(MODULE_LINH_MUC_DETAIL_PAGE, {
      dropdownGiaoXus: (state) => state.dropdownGiaoXus,
      dropdownThanhs: (state) => state.dropdownThanhs,
      dropdownChucVus: (state) => state.dropdownChucVus,
      dropdownDucChas: (state) => state.dropdownDucChas,
      dropdownCoSoGiaoPhans: (state) => state.dropdownCoSoGiaoPhans,
      dropdownBanChuyenTrachs: (state) => state.dropdownBanChuyenTrachs,
      dropdownDongs: (state) => state.dropdownDongs,
      dropdownCongDoanNgoaiGiaoPhans: (state) => state.dropdownCongDoanNgoaiGiaoPhans,
    }),
    _showDiaDiem() {
      return this.dia_diem_loai
    },
  },
  mounted() {
    this.getDropdownChucVus()
    this.getDropdownBanChuyenTrachs()
    this.getDropdownGiaoXus()
    this.getDropdownCSGPs()
    this.getDropdownDongs()
    this.getDropdownCSNGPs()
  },
  methods: {
    ...mapActions(MODULE_LINH_MUC_DETAIL_PAGE, [
      'GET_LIST_GIAO_XU',
      'GET_LIST_BAN_CHUYEN_TRACH',
      'GET_LIST_DONG',
      'GET_LIST_CSGP',
      'GET_LIST_DUC_CHA',
      'GET_LIST_CHUC_VU',
      'GET_LIST_THANH',
      'GET_LIST_CSNGP',
      'ADD_THUYEN_CHUYEN',
      'UPDATE_THUYEN_CHUYEN',
    ]),
    resetThuyenChuyen() {
      if(this.dia_diem_loai === 1) {
        this.thuyenChuyen.select_csgp = 0
        this.thuyenChuyen.select_dong = 0
        this.thuyenChuyen.select_bct = 0
        this.thuyenChuyen.select_cdn = 0
      }else if (this.dia_diem_loai === 2 || this.dia_diem_loai === 5) {
        this.thuyenChuyen.select_giao_xu = 0
        this.thuyenChuyen.select_dong = 0
        this.thuyenChuyen.select_bct = 0
        this.thuyenChuyen.select_cdn = 0
      }else if (this.dia_diem_loai === 3) {
        this.thuyenChuyen.select_giao_xu = 0
        this.thuyenChuyen.select_csgp = 0
        this.thuyenChuyen.select_bct = 0
        this.thuyenChuyen.select_cdn = 0
      }else {
        this.thuyenChuyen.select_giao_xu = 0
        this.thuyenChuyen.select_csgp = 0
        this.thuyenChuyen.select_dong = 0
        this.thuyenChuyen.select_cdn = 0
      }
    },
    _hideModalEdit() {
      this.$modal.hide('modal-hoat-dong-su-vu-edit')
    },
    onChange() {
      if(this.dia_diem_loai === 1) {
        this.thuyenChuyen.select_csgp = 0
        this.thuyenChuyen.select_dong = 0
        this.thuyenChuyen.select_bct = 0
        this.thuyenChuyen.select_cdn = 0
      }else if (this.dia_diem_loai === 2 || this.dia_diem_loai === 5) {
        this.thuyenChuyen.select_giao_xu = 0
        this.thuyenChuyen.select_dong = 0
        this.thuyenChuyen.select_bct = 0
        this.thuyenChuyen.select_cdn = 0
      }else if (this.dia_diem_loai === 3) {
        this.thuyenChuyen.select_giao_xu = 0  
        this.thuyenChuyen.select_csgp = 0
        this.thuyenChuyen.select_bct = 0
        this.thuyenChuyen.select_cdn = 0
      }else {
        this.thuyenChuyen.select_giao_xu = 0
        this.thuyenChuyen.select_csgp = 0
        this.thuyenChuyen.select_dong = 0
        this.thuyenChuyen.select_cdn = 0
      }
    },
    _addInfo() {
      const id_chuc_vu = this.select_chuc_vu
      const id_bct = this.thuyenChuyen.select_bct
      const id_giaoxu = this.thuyenChuyen.select_giao_xu
      const id_csgp = this.thuyenChuyen.select_csgp
      const id_dong = this.thuyenChuyen.select_dong
      const dia_diem_tu_nam = this.dia_diem_tu_nam
			const dia_diem_tu_thang = this.dia_diem_tu_thang
			const dia_diem_tu_ngay = this.dia_diem_tu_ngay
			const dia_diem_den_nam = this.dia_diem_den_nam
			const dia_diem_den_thang = this.dia_diem_den_thang
			const dia_diem_den_ngay = this.dia_diem_den_ngay
      const status = this.select_status
      const data = {
        id_chuc_vu, id_bct, id_giaoxu, id_csgp, id_dong, 
        dia_diem_tu_nam, dia_diem_tu_thang, dia_diem_tu_ngay,
        dia_diem_den_nam, dia_diem_den_thang, dia_diem_den_ngay, status
      }
      if(id_chuc_vu) {
        this.UPDATE_THUYEN_CHUYEN({
          data: data,
          id: this.info.id,
          action: 'update.thuyen.chuyen'
        })
      }
      this._hideModalEdit()
    },
    resetModal() {
      this.dia_diem_loai = ''
      this.select_chuc_vu = 0
      this.thuyenChuyen.select_giao_xu = 0
      this.thuyenChuyen.select_csgp = 0
      this.thuyenChuyen.select_dong = 0
      this.thuyenChuyen.select_bct = 0
      this.thuyenChuyen.select_cdn = 0
      this.select_status = 0
      this.from_date = ''
      this.to_date = ''
      this.dia_diem_tu_nam = ''
		  this.dia_diem_tu_thang = ''
			this.dia_diem_tu_ngay = ''
			this.dia_diem_den_nam = ''
			this.dia_diem_den_thang = ''
			this.dia_diem_den_ngay = ''
    },
    /* GET DROPDOWN CATEGORIES */
    getDropdownGiaoXus() {
      this.resetThuyenChuyen()
      this.GET_LIST_GIAO_XU()
    },
    getDropdownBanChuyenTrachs() {
      this.resetThuyenChuyen()
      this.GET_LIST_BAN_CHUYEN_TRACH()
    },
    getDropdownDongs() {
      this.resetThuyenChuyen()
      this.GET_LIST_DONG()
    },
    getDropdownCSGPs() {
      this.resetThuyenChuyen()
      this.GET_LIST_CSGP()
    },
    getDropdownDucChas() {
      this.GET_LIST_DUC_CHA()
    },
    getDropdownChucVus() {
      this.GET_LIST_CHUC_VU()
    },
    getDropdownThanhs() {
      this.GET_LIST_THANH()
    },
    getDropdownCSNGPs() {
      this.GET_LIST_CSNGP()
    },
    /* SET DATE */
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
}
</style>