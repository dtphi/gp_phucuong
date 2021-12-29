<template>
  <div class="tab-content">
    <div class="form-group">
      <label for="input-info-duc-cha" class="col-sm-2 control-label"
        >Chức Vụ</label
      >
      <div class="col-sm-10">
        <label>Là đức cha</label>
        <input
          v-model="generalData.is_duc_cha"
          type="checkbox"
          id="input-info-duc-cha"
          class="form-control"
        />
      </div>
    </div>
    <div class="form-group">
      <label for="input-info-duc-cha" class="col-sm-2 control-label"
        >Hình ảnh</label
      >
      <div class="col-sm-2">
        <input
          @click="_selectImage"
          type="button"
          value="Image"
          id="input-info-image"
          class="form-control"
        />
      </div>
      <div class="col-sm-3">
        <div class="file animated fadeIn" style="height: 61px">
          <div class="file-preview">
            <img :src="_getImageAvatar" class="thumb" />
          </div>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="input-info-so-dien-thoai" class="col-sm-2 control-label"
        >Sô điện thoại</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_so_dien_thoai"
          rules="max:20"
          v-slot="{ errors }"
        >
          <input
            v-model="generalData.phone"
            type="text"
            id="input-info-so-dien-thoai"
            class="form-control"
            placeholder="Số điện thoại"
          />

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <label for="input-info-email" class="col-sm-2 control-label">Email</label>
      <div class="col-sm-10">
        <validation-provider
          name="info_email"
          rules="email|max:200"
          v-slot="{ errors }"
        >
          <input
            autocomplete="off"
            v-model="generalData.email"
            type="text"
            id="input-info-email"
            class="form-control"
            placeholder="Email"
          />

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <label for="input-info-pass" class="col-sm-2 control-label"
        >Password</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_pass"
          rules="max:20"
          v-slot="{ errors }"
        >
          <input
            autocomplete="off"
            v-model="generalData.password"
            type="password"
            id="input-info-pass"
            class="form-control"
            placeholder="Mật khẩu"
          />

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <label for="input-info-so-cmnd" class="col-sm-2 control-label"
        >Số CMND</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_so_cmnd"
          rules="max:200"
          v-slot="{ errors }"
        >
          <input
            v-model="generalData.so_cmnd"
            type="text"
            id="input-info-so-cmnd"
            class="form-control"
            placeholder="Số Cmnd"
          />

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <label for="input-info-noicap-cmnd" class="col-sm-2 control-label"
        >Nơi cấp CMND:</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_noicap_cmnd"
          rules="max:500"
          v-slot="{ errors }"
        >
          <input
            v-model="generalData.noi_cap_cmnd"
            type="text"
            id="input-info-noicap-cmnd"
            class="form-control"
            placeholder="Nơi cấp Cmnd"
          />

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <label for="input-info-ngay-cap-cmnd" class="col-sm-2 control-label"
        >Ngày cấp CMND:</label
      >
      <div class="col-sm-10">
        <cms-date-picker
          value-type="format"
          format="YYYY-MM-DD"
          v-model="generalData.ngay_cap_cmnd"
          type="date"
        ></cms-date-picker>
      </div>
    </div>
    <div class="form-group">
      <label for="input-info-ghi-chu" class="col-sm-2 control-label"
        >Ghi chú</label
      >
      <div class="col-sm-10">
        <tinymce
          id="input-ghi-chu"
          :other_options="options"
          v-model="generalData.ghi_chu"
        ></tinymce>
      </div>
    </div>
    <div class="form-group">
      <label for="input-info-sort" class="col-sm-2 control-label">Thứ tự</label>
      <div class="col-sm-10">
        <validation-provider
          name="info_sort"
          rules="max:200"
          v-slot="{ errors }"
        >
          <input
            v-model="generalData.sort_id"
            type="text"
            id="input-info-sort"
            class="form-control"
            placeholder="Thứ tự"
          />

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-info-status"
        >Trạng thái</label
      >
      <div class="col-sm-10">
        <select
          v-model="generalData.active"
          id="input-info-active"
          class="form-control"
        >
          <option value="1" :selected="generalData.active == 1">Xảy ra</option>
          <option value="0" :selected="generalData.active == 0">Ẩn</option>
        </select>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, } from 'vuex'
import { MODULE_MODULE_LINH_MUC_ADD, } from 'store@admin/types/module-types'
import { ACTION_SET_IMAGE, } from 'store@admin/types/action-types'
import linhMucMix from '@app/mixins/admin/linhmuc'

export default {
  name: 'TabMoRongForm',
  mixins: [linhMucMix.tabData],
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC_ADD, [ACTION_SET_IMAGE]),
  },
  
}
</script>
