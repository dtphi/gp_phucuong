<template>
  <modal name="modal-hoat-dong-su-vu-add" width="800" height="600">
    <div class="panel panel-default" style="height: 100%; overflow: auto">
      <div class="panel-body">
        <form class="form-horizontal cms-modal-form">
          <div class="form-group">
            <label for="input-info-status" class="col-sm-3 control-label"
              >Loại hoạt động</label
            >
            <div class="col-sm-10">
              <select class="form-control" v-model="select_action">
                <option :value="1" :selected="select_action == 1">Bổ nhiệm khác</option>
                <option :value="0" :selected="select_action == 0">Hoạt động sứ vụ</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Chức vụ:</label>
            <div class="col-sm-12">
              <select
                v-model="select_chuc_vu"
                @click="getDropdownChucVus()"
                class="custom-select"
              >
                <option
                  v-for="(item, idx) in dropdownChucVus"
                  :key="idx"
                  :value="item.id"
                >
                  {{ item.name }}
                </option>
              </select>
            </div>
          </div>
          <div class="form-group" v-if="select_action == 1">
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
                @click="getDropdownGiaoXus()"
                class="custom-select"
              >
                <option
                  v-for="(item, idx) in dropdownGiaoXus"
                  :key="idx"
                  :value="item.id"
                >
                  {{ item.name }}
                </option>
              </select>
              <!-- Csgp  -->
              <select
                v-if="_showDiaDiem === isCoSo"
                v-model="thuyenChuyen.select_csgp"
                @click="getDropdownCSGPs()"
                class="custom-select"
              >
                <option
                  v-for="(item, idx) in dropdownCoSoGiaoPhans"
                  :key="idx"
                  :value="item.id"
                >
                  {{ item.name }}
                </option>
              </select>
              <!-- Dong -->
              <select
                v-if="_showDiaDiem === isDong"
                v-model="thuyenChuyen.select_dong"
                @click="getDropdownDongs()"
                class="custom-select"
              >
                <option
                  v-for="(item, idx) in dropdownDongs"
                  :key="idx"
                  :value="item.id"
                >
                  {{ item.name }}
                </option>
              </select>
              <!-- Ban_chuyen_trach -->
              <select
                v-if="_showDiaDiem === isBanChuyenTrach"
                v-model="thuyenChuyen.select_bct"
                @click="getDropdownBanChuyenTrachs()"
                class="custom-select"
              >
                <option
                  v-for="(item, idx) in dropdownBanChuyenTrachs"
                  :key="idx"
                  :value="item.id"
                >
                  {{ item.name }}
                </option>
              </select>
              <!-- Cong_doan_ngoai_giao_phan -->
              <select
                v-if="_showDiaDiem === isCongDoanNgoai"
                v-model="thuyenChuyen.select_csgp"
                @click="getDropdownCSNGPs()"
                class="custom-select"
              >
                <option
                  v-for="(item, idx) in dropdownCongDoanNgoaiGiaoPhans"
                  :key="idx"
                  :value="item.id"
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
                <option :value="1" :selected="select_status == 1">Hiện đang giữ</option>
                <option :value="0" :selected="select_status == 0">Đã xảy ra</option>
              </select>
            </div>
          </div>
        </form>
        <div >
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
  </modal>
</template>

<script>
import { MODULE_LINH_MUC_DETAIL_PAGE } from '@app/stores/front/types/module-types'
import { mapState, mapActions } from 'vuex'

export default {
  name: 'ModalHoatDongSuVu',
  data() {
    return {
      dia_diem_loai: '',
      cong_viec: '',
      isGiaoXu: 1,
      isCoSo: 2,
      isDong: 3,
      isBanChuyenTrach: 4,
      isCongDoanNgoai: 5,
      select_chuc_vu: 0,
      select_action: 0,
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
      'ADD_THUYEN_CHUYEN'
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
      this.$modal.hide('modal-hoat-dong-su-vu-add')
    },
    _addInfo() {
      const data = this.$data;
      if(data.select_chuc_vu) {
        this.ADD_THUYEN_CHUYEN({
          data: data,
          id: this.$route.params.linhMucId,
          action: 'add.thuyen.chuyen'
        })
      }
      this.resetModal()
      this._hideModalEdit()
    },
    resetModal() {
      this.dia_diem_loai = ''
      this.select_chuc_vu = 0
      this.thuyenChuyen.select_giao_xu = 0
      this.thuyenChuyen.select_csgp = 0
      this.thuyenChuyen.select_dong = 0
      this.thuyenChuyen.select_bct = 0
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
      this.resetThuyenChuyen()
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
  mounted() {
    console.log('rersrerser')
  }
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