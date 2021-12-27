<template>
  <modal name="modal-linh-muc-thuyen-chuyen-add" :height="455">
    <div class="panel panel-default" style="height: 100%; overflow: auto">
      <div class="panel-heading">
        <h3 class="panel-title">
          <i class="fa fa-plus"></i>Thêm thuyên chuyển
        </h3>
        <div slot="top-right" class="pull-right">
          <button @click="_hideModalEdit">❌</button>
        </div>
      </div>
      <div class="panel-body">
        <form class="form-horizontal">
          <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Linh mục</label
            >
            <div class="col-sm-10">
              {{ info.ten_linh_muc }}
            </div>
          </div>
          <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Từ</label
            >
            <div class="col-sm-10">
              <info-giao-xu-autocomplete
                @on-select-giao-xu="_selectThuyenChuyenFromGiaoXu"
                :name="info.fromGiaoXuName"
                :key="`from_giao_xu_${info.id}`"
              ></info-giao-xu-autocomplete>
            </div>
          </div>
          <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Từ</label
            >
            <div class="col-sm-10">
              <info-chuc-vu-autocomplete
                @on-select-chuc-vu="_selectThuyenChuyenFromChucVu"
                :name="info.fromchucvuName"
                :key="`from_chuc_vu_${info.id}`"
              ></info-chuc-vu-autocomplete>
            </div>
          </div>
          <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Từ ngày</label
            >
            <div class="col-sm-10">
              <cms-date-picker
                value-type="format"
                format="YYYY-MM-DD"
                v-model="info.from_date"
                type="date"
              ></cms-date-picker>
            </div>
          </div>
          <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Linh mục</label
            >
            <div class="col-sm-10">
              <info-duc-cha-autocomplete
                @on-select-chuc-cha="_selectThuyenChuyenDucCha"
                :name="info.ducchaName"
                :key="`duc_cha_${info.id}`"
              ></info-duc-cha-autocomplete>
            </div>
          </div>
          <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Đến ngày</label
            >
            <div class="col-sm-10">
              <cms-date-picker
                value-type="format"
                format="YYYY-MM-DD"
                v-model="info.to_date"
                type="date"
              ></cms-date-picker>
            </div>
          </div>
          <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Chức vụ đến</label
            >
            <div class="col-sm-10">
              <info-chuc-vu-autocomplete
                @on-select-chuc-vu="_selectThuyenChuyenToChucVu"
                :name="info.chucvuName"
                :key="`to_chuc_vu_${info.id}`"
              ></info-chuc-vu-autocomplete>
            </div>
          </div>
          <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Đến</label
            >
            <div class="col-sm-10">
              <info-giao-xu-autocomplete
                @on-select-giao-xu="_selectThuyenChuyenToGiaoXu"
                :name="info.giaoxuName"
                :key="`to_giao_xu_${info.id}`"
              ></info-giao-xu-autocomplete>
            </div>
          </div>
          <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Cơ sở</label
            >
            <div class="col-sm-10">
              <info-co-so-giao-phan-autocomplete
                @on-select-co-so-giao-phan="_selectThuyenChuyenCoSoGiaoPhan"
                :name="info.cosogpName"
                :key="`co_so_giao_phan_${info.id}`"
              ></info-co-so-giao-phan-autocomplete>
            </div>
          </div>
          <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Là</label
            >
            <div class="col-sm-10">
              <info-dong-autocomplete
                @on-select-dong="_selectThuyenChuyenDong"
                :name="info.dongName"
                :key="`dong_${info.id}`"
              ></info-dong-autocomplete>
            </div>
          </div>
          <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Là</label
            >
            <div class="col-sm-10">
              <info-ban-chuyen-trach-autocomplete
                @on-select-ban-chuyen-trach="_selectThuyenChuyenBanChuyenTrach"
                :name="info.banchuyentrachName"
                :key="`ban_chuyen_trach_${info.id}`"
              ></info-ban-chuyen-trach-autocomplete>
            </div>
          </div>
          <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Ghi chú</label
            >
            <div class="col-sm-10">
              <validation-provider
                name="info_ghi_chu"
                rules="max:200"
                v-slot="{ errors }"
              >
                <textarea
                  class="form-control"
                  v-model="info.ghi_chu"
                ></textarea>
                <span class="cms-text-red">{{ errors[0] }}</span>
              </validation-provider>
            </div>
          </div>
          <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Trạng thái</label
            >
            <div class="col-sm-10">
              <select class="form-control" v-model="info.active">
                <option value="1" :selected="info.active == 1">Xảy ra</option>
                <option value="0" :selected="info.active == 0">Ẩn</option>
              </select>
            </div>
          </div>
        </form>
      </div>
      <div class="container-fluid">
        <div class="pull-right">
          <input
            type="button"
            value="Hủy"
            class="btn btn-default"
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
  </modal>
</template>

<script>
import { mapActions, mapState, } from 'vuex'
import { MODULE_MODULE_THUYEN_CHUYEN_ADD, } from 'store@admin/types/module-types'
import { ACTION_RESET_NOTIFICATION_INFO, } from 'store@admin/types/action-types'
import { config, } from '@app/common/config'
import InfoGiaoXuAutocomplete from 'com@admin/Form/LinhMucs/Groups/InfoGiaoXuAutocomplete'
import InfoChucVuAutocomplete from 'com@admin/Form/LinhMucs/Groups/InfoChucVuAutocomplete'
import InfoDucChaAutocomplete from 'com@admin/Form/LinhMucs/Groups/InfoDucChaAutocomplete'
import InfoCoSoGiaoPhanAutocomplete from 'com@admin/Form/LinhMucs/Groups/InfoCoSoGiaoPhanAutocomplete'
import InfoDongAutocomplete from 'com@admin/Form/LinhMucs/Groups/InfoDongAutocomplete'
import InfoBanChuyenTrachAutocomplete from 'com@admin/Form/LinhMucs/Groups/InfoBanChuyenTrachAutocomplete'

export default {
  name: 'TheModalAdd',
  components: {
    InfoGiaoXuAutocomplete,
    InfoChucVuAutocomplete,
    InfoDucChaAutocomplete,
    InfoCoSoGiaoPhanAutocomplete,
    InfoDongAutocomplete,
    InfoBanChuyenTrachAutocomplete,
  },
  data() {
    return {
      info: {},
    }
  },
  computed: {
    ...mapState(MODULE_MODULE_THUYEN_CHUYEN_ADD, ['loading', 'insertSuccess']),
  },
  methods: {
    ...mapActions(MODULE_MODULE_THUYEN_CHUYEN_ADD, {
      resetNotification: ACTION_RESET_NOTIFICATION_INFO,
    }),
    _hideModalEdit() {
      this.info = {}
      this.$modal.hide('modal-linh-muc-thuyen-chuyen-add')
    },
    _submitUpdate() {
      return 0
    },
    _selectThuyenChuyenFromGiaoXu(values) {
      this._changeForm(values, 'from.giao.xu')
    },
    _selectThuyenChuyenFromChucVu(values) {
      this._changeForm(values, 'from.chuc.vu')
    },
    _selectThuyenChuyenDucCha(values) {
      this._changeForm(values, 'from.duc.cha')
    },
    _selectThuyenChuyenToChucVu(values) {
      this._changeForm(values, 'to.chuc.vu')
    },
    _selectThuyenChuyenToGiaoXu(values) {
      this._changeForm(values, 'to.giao.xu')
    },
    _selectThuyenChuyenCoSoGiaoPhan(values) {
      this._changeForm(values, 'co.so.giao.phan')
    },
    _selectThuyenChuyenDong(values) {
      this._changeForm(values, 'dong')
    },
    _selectThuyenChuyenBanChuyenTrach(values) {
      this._changeForm(values, 'ban.chuyen.trach')
    },
    _changeForm(values, type) {
      this.$emit('change-form', { ...values, type, })
    },
    _notificationUpdate(notification) {
      if (notification.type == 'success') {
        this.$emit('insert-info-success')
      }
      this.$notify(notification)
      this.resetNotification()
    },
  },
  setting: {
    cf: config,
    list_title: 'Danh sách Linh mục',
  },
}
</script>
