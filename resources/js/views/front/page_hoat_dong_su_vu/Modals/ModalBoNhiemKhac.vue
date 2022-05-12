<template>
  <modal name="modal-bo-nhiem-khac-add" width="800" height="570">
    <div class="panel panel-default" style="height: 100%; overflow: auto">
      <div class="panel-body">
        <form class="form-horizontal cms-modal-form">
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
                style="max-width: 25%; text-align: right"
              />
              <label style="font-size: 20px">-</label>
              <input
                v-model="cong_viec_tu_thang"
                type="number"
                max="2"
                min="0"
                class="form-control"
                style="max-width: 25%; text-align: right"
              />
              <label style="font-size: 20px">-</label>
              <input
                v-model="cong_viec_tu_nam"
                type="number"
                max="4"
                min="0"
                class="form-control"
                style="max-width: 25%; text-align: right"
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
                style="max-width: 25%; text-align: right"
              />
              <label style="font-size: 20px">-</label>
              <input
                v-model="cong_viec_den_thang"
                type="number"
                max="2"
                min="0"
                class="form-control"
                style="max-width: 25%; text-align: right"
              />
              <label style="font-size: 20px">-</label>
              <input
                v-model="cong_viec_den_nam"
                type="number"
                max="4"
                min="0"
                class="form-control"
                style="max-width: 25%; text-align: right"
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
  </modal>
</template>

<script>
import { mapState, mapActions } from 'vuex'
import { MODULE_LINH_MUC_DETAIL_PAGE } from '@app/stores/front/types/module-types'

export default {
  name: 'ModalBoNhiemKhac',

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
      select_chuc_vu: '',
      cong_viec: '',
      cong_viec_tu_ngay: '',
      cong_viec_tu_thang: '',
      cong_viec_tu_nam: '',
      tu_ngay_thang_nam: '',
      cong_viec_den_ngay: '',
      cong_viec_den_thang: '',
      cong_viec_den_nam: '',
      den_ngay_thang_nam: '',
      select_status: 0,
    }
  },
	computed: {
		...mapState(MODULE_LINH_MUC_DETAIL_PAGE, {
      dropdownChucVus: (state) => state.dropdownChucVus,
	  }),
  },
  watch: {
  tu_ngay_thang_nam(val){
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
    ...mapActions(MODULE_LINH_MUC_DETAIL_PAGE, [
      'GET_LIST_CHUC_VU', 
      'ADD_BO_NHIEM'
    ]), 
    getDropdownChucVus() {
      this.GET_LIST_CHUC_VU()
    },
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
      this.$modal.hide('modal-bo-nhiem-khac-add')
    },
    _selectThuyenChuyenFromChucVu(chucVu) {
      this.$data.chucVuName = chucVu.name
      this.$data.chuc_vu_id = chucVu.id
    },
    async _addInfo() {
      const bo_nhiem = {
        id_chucvu : this.select_chuc_vu,
        cong_viec : this.cong_viec,
        cong_viec_tu_nam : this.cong_viec_tu_nam,
        cong_viec_tu_thang : this.cong_viec_tu_thang,
        cong_viec_tu_ngay : this.cong_viec_tu_ngay,
        cong_viec_den_nam : this.cong_viec_den_nam,
        cong_viec_den_thang : this.cong_viec_den_thang,
        cong_viec_den_ngay : this.cong_viec_den_ngay,
        select_status: this.select_status
      }
      if (bo_nhiem.id_chucvu) {
        await this.ADD_BO_NHIEM({
          data: bo_nhiem,
          id: this.$route.params.linhMucId,
          action: 'add.bo.nhiem'
        })
        this._hideModalEdit()
      } else {
        alert('Nhập thông tin bổ nhiệm')
      } 
    },
  },
  setting: {
    modal_title: 'Thêm Bổ Nhiệm Khác',
    modal_name: 'modal-bo-nhiem-khac-add',
  },
}
</script>