<template>
		<div class="panel panel-default" style="height: 100%; overflow: auto">
      <div class="panel-heading cms-modal-heading">
        <h3 class="panel-title"><i :class="icon"></i>{{ title }}</h3>
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
						@click.prevent="_submitUpdate"
					/>
          </div>
        </div>
      </div>
    </div>
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
	id: '',
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
		icon: {
      default: 'fa fa-plus',
    },
    title: {
      default: 'Tiêu Để',
    },
  },
  data() {
    return boNhiem
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
	created() {
			console.log(this.info, 'info');
			this.$data.id = this.info.id
			this.$data.chuc_vu_id = this.info.chuc_vu_id
			this.$data.chucVuName = this.info.chucvuName
			this.$data.tu_ngay_thang_nam = this.info.label_from_date
			this.$data.den_ngay_thang_nam = this.info.label_to_date
			this.$data.cong_viec = this.info.ghi_chu
	},
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC_EDIT, [
				'updateBoNhiem',
				ACTION_RESET_NOTIFICATION_INFO
		]),
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
			this.$data.id = '',
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
    _submitUpdate() {
      const data = this.$data
      if (data.chuc_vu_id) {
        	this.updateBoNhiem({
          action: 'update.bo.nhiem',
          data: data,
					id_bo_nhiem: this.info.id,
					linhMucId: this.$route.params.linhmucId,
        })
        this._resetModal
				this.$nextTick(() => {
          this.$emit('update-info-success');
      	});
      } else {
        alert('Nhập thông tin bổ nhiệm')
      }
    },
		_notificationUpdate(notification) {
				if (notification.type == 'success') {
						this.$emit('update-info-success');
				}
				this.$notify(notification);
				this.resetNotification();
		},
  },
  setting: {
    modal_title: 'Thêm Bổ Nhiệm Khác',
    modal_name: 'modal-lm-bo-nhiem-edit',
    keyChucVu: 'chuc_vu_bo_nhiem',
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