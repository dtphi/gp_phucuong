<template>
    <div class="panel panel-default" style="height: 100%; overflow: auto">
      <div class="panel-body">
        <form class="form-horizontal cms-modal-form">
          <div class="form-group">
            <label class="col-sm-3 control-label">Chức vụ:</label>
            <div class="col-sm-12">
              <select
                v-model="select_chuc_vu"
                class="custom-select" 
              >
                <option
                  v-for="(item, idx) in dropdownChucVus"
                  :key="idx"
                  :value="item.id"
                  :selected="item.id === select_chuc_vu"
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
              value="Cập nhật"
              class="btn btn-primary"
              @click.prevent="_submitUpdate"
            />
          </div>
        </div>
      </div>
    </div>
</template>
<script>
import { mapState, mapActions } from 'vuex'
import { MODULE_LINH_MUC_DETAIL_PAGE } from '@app/stores/front/types/module-types'

export default {
  name: 'TheModalBoNhiemKhacEdit',
  props: {
		info: {
				type: Object,
				require: true,
		},
  },
  data() {
    return {
      	id: '',
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
        select_status: '' ,
    }
  },
	computed: {
		...mapState(MODULE_LINH_MUC_DETAIL_PAGE, {
      dropdownChucVus: (state) => state.dropdownChucVus,
	  }),
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
	created() {
			this.id = this.info.id
			this.select_chuc_vu = this.info.chuc_vu_id
			this.tu_ngay_thang_nam = this.info.label_from_date
			this.den_ngay_thang_nam = this.info.label_to_date
			this.cong_viec = this.info.ghi_chu
      this.select_status = this.info.active
      console.log(this.select_chuc_vu, 'select')
	},
  mounted() {
    this.getDropdownChucVus()
  },
  methods: {
    ...mapActions(MODULE_LINH_MUC_DETAIL_PAGE, [
        'GET_LIST_CHUC_VU', 
				'UPDATE_BO_NHIEM',
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
      this.$modal.hide('modal-bo-nhiem-khac-edit')
    },
    _submitUpdate() {
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
        	this.UPDATE_BO_NHIEM({
          action: 'update.bo.nhiem',
          data: bo_nhiem,
          id: this.id
        })
      } else {
        alert('Nhập thông tin bổ nhiệm')
      }
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