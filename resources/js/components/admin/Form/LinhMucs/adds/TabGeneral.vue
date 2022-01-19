<template>
  <div class="tab-content">
    <div>
      <info-ten-thanh-autocomplete
        @on-select-ten-thanh="_selectGeneralTenThanh"
        :ten-thanh="ten_thanh_name"
        :key="ten_thanh_linh_muc"
      ></info-ten-thanh-autocomplete>
    </div>
    <div>
      <info-giao-xu-autocomplete
        @on-select-giao-xu="_selectGiaoXu"
        :name="giao_xu_name"
        :key="giao_xu_linh_muc"
      ></info-giao-xu-autocomplete>
    </div>
    <div class="form-group">
      <label for="input-info-name" class="col-sm-2 control-label">{{
        $options.setting.name_txt
      }}</label>
      <div class="col-sm-10">
        <validation-provider
          name="info_name"
          rules="max:200"
          v-slot="{ errors }"
        >
          <input
            v-model="ten"
            type="text"
            id="input-info-name"
            class="form-control"
            :placeholder="$options.setting.name_txt"
          />

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <label for="input-info-ngay-thang-nam-sinh" class="col-sm-2 control-label"
        >Ngày sinh:</label
      >
      <div class="col-sm-10">
          <cms-date-picker
            value-type="format"
            format="YYYY-MM-DD"
            v-model="ngay_thang_nam_sinh"
            type="date"
          ></cms-date-picker>
      </div>
    </div>
    <div class="form-group">
      <label for="input-info-noi-sinh" class="col-sm-2 control-label"
        >Nơi sinh</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_noi_sinh"
          rules="max:500"
          v-slot="{ errors }"
        >
          <textarea
            id="input-info-noi-sinh"
            v-model="noi_sinh"
            class="form-control"
            placeholder="Nơi sinh"
          ></textarea>

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <label for="input-info-ho-ten-cha" class="col-sm-2 control-label"
        >Họ tên cha</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_ho_ten_cha"
          rules="max:200"
          v-slot="{ errors }"
        >
          <input
            v-model="ho_ten_cha"
            type="text"
            id="input-info-ho-ten-cha"
            class="form-control"
            placeholder="Họ tên cha"
          />

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <label for="input-info-ho-ten-me" class="col-sm-2 control-label"
        >Họ tên mẹ</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_ho_ten_me"
          rules="max:200"
          v-slot="{ errors }"
        >
          <input
            v-model="ho_ten_me"
            type="text"
            id="input-info-ho-ten-me"
            class="form-control"
            placeholder="Họ tên mẹ"
          />

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <label for="input-info-noi-rua-toi" class="col-sm-2 control-label"
        >Nơi rửa tội</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_noi_rua_toi"
          rules="max:500"
          v-slot="{ errors }"
        >
          <input
            v-model="noi_rua_toi"
            type="text"
            id="input-info-noi-rua-toi"
            class="form-control"
            placeholder="Nơi rửa tội"
          />

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <label for="input-info-ngay-rua-toi" class="col-sm-2 control-label"
        >Ngày rửa tội:</label
      >
      <div class="col-sm-10">
          <cms-date-picker
            value-type="format"
            format="YYYY-MM-DD"
            v-model="ngay_rua_toi"
            type="date"
          ></cms-date-picker>
      </div>
    </div>
    <div class="form-group">
      <label for="input-info-noi-them-suc" class="col-sm-2 control-label"
        >Nơi thêm sức</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_noi_them_suc"
          rules="max:500"
          v-slot="{ errors }"
        >
          <input
            v-model="noi_them_suc"
            type="text"
            id="input-info-noi-them-suc"
            class="form-control"
            placeholder="Nơi thêm sức"
          />

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <label for="input-info-ngay-them-suc" class="col-sm-2 control-label"
        >Ngày thêm sức:</label
      >
      <div class="col-sm-10">
        <cms-date-picker
          value-type="format"
          format="YYYY-MM-DD"
          v-model="ngay_them_suc"
          type="date"
        ></cms-date-picker>
      </div>
    </div>
    <div class="form-group">
      <label for="input-info-tieu-chung-vien" class="col-sm-2 control-label"
        >Tiểu chủng viện</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_tieu_chung_vien"
          rules="max:200"
          v-slot="{ errors }"
        >
          <input
            v-model="tieu_chung_vien"
            type="text"
            id="input-info-tieu-chung-vien"
            class="form-control"
            placeholder="Tiểu chủng viện"
          />

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <label
        for="input-info-ngay-tieu-chung-vien"
        class="col-sm-2 control-label"
        >Ngày tiểu chủng viện:</label
      >
      <div class="col-sm-10">
        <cms-date-picker
          value-type="format"
          format="YYYY-MM-DD"
          v-model="ngay_tieu_chung_vien"
          type="date"
        ></cms-date-picker>
      </div>
    </div>
    <div class="form-group">
      <label for="input-info-dai-chung-vien" class="col-sm-2 control-label"
        >Đại chủng viện</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_dai_chung_vien"
          rules="max:200"
          v-slot="{ errors }"
        >
          <input
            v-model="dai_chung_vien"
            type="text"
            id="input-info-dai-chung-vien"
            class="form-control"
            placeholder="Đại chủng viện"
          />

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <label for="input-info-ngay-dai-chung-vien" class="col-sm-2 control-label"
        >Ngày đại chủng viện:</label
      >
      <div class="col-sm-10">
        <cms-date-picker
          value-type="format"
          format="YYYY-MM-DD"
          v-model="ngay_dai_chung_vien"
          type="date"
        ></cms-date-picker>
      </div>
    </div>
    <div class="form-group">
      <label for="input-info-trieu-dong" class="col-sm-2 control-label"
        >Triệu dòng:</label
      >
      <div class="col-sm-10">
          <select
            class="form-control"
            id="input-info-trieu-dong"
            v-model="trieu_dong"
          >
            <option
              :selected="trieu_dong == idx ? 'selected' : ''"
              :value="idx"
              v-for="(item, idx) in $options.setting.cf.trieuDongs"
              :key="idx"
            >
              {{ item }}
            </option>
          </select>
      </div>
    </div>
    <div class="form-group">
      <info-dong-autocomplete
        @on-select-dong="_selectDong"
        :name="ten_dong_name"
        :key="ten_dong_linh_muc"
      ></info-dong-autocomplete>
    </div>
    <div class="form-group">
      <label for="input-info-ngay-trieu-dong" class="col-sm-2 control-label"
        >Ngày triệu dòng:</label
      >
      <div class="col-sm-10">
        <cms-date-picker
          value-type="format"
          format="YYYY-MM-DD"
          v-model="ngay_trieu_dong"
          type="date"
        ></cms-date-picker>
      </div>
    </div>
    <div class="form-group">
      <label for="input-info-ngay-khan" class="col-sm-2 control-label"
        >Ngày khấn:</label
      >
      <div class="col-sm-10">
        <cms-date-picker
          v-model="ngay_khan"
          type="datetime"
        ></cms-date-picker>
      </div>
    </div>
    <div class="form-group">
      <label for="input-info-ngay-rip" class="col-sm-2 control-label"
        >Ngày Rip:</label
      >
      <div class="col-sm-10">
        <cms-date-picker
          value-type="format"
          format="YYYY-MM-DD"
          v-model="ngay_rip"
          type="date"
        ></cms-date-picker>
      </div>
    </div>
    <div>
      <info-giao-xu-autocomplete
        @on-select-giao-xu="_selectRipGiaoXu"
        :name="rip_giaoxu_name"
        :key="giao_xu_rip"
      ></info-giao-xu-autocomplete>
    </div>
    <div class="form-group">
      <label for="input-info-rip-ghi-chu" class="col-sm-2 control-label"
        >Rip ghi chú</label
      >
      <div class="col-sm-10">
        <tinymce
          id="input-rip-ghi-chu"
          :other_options="options"
          v-model="rip_ghi_chu"
        ></tinymce>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, } from 'vuex'
import { MODULE_MODULE_LINH_MUC_ADD, } from 'store@admin/types/module-types'
import {
  ACTION_SET_IMAGE,
} from 'store@admin/types/action-types'
import linhMucMix from '@app/mixins/admin/linhmuc'
import InfoGiaoXuAutocomplete from '../Groups/InfoGiaoXuAutocomplete'
import InfoTenThanhAutocomplete from '../Groups/InfoTenThanhAutocomplete'
import InfoDongAutocomplete from '../Groups/InfoDongAutocomplete'
import { createHelpers, } from 'vuex-map-fields'
import { MAP_PC_LINHMUCS, } from 'store@admin/types/model-map-fields'
const { mapFields, } = createHelpers({
  getterType: `${MODULE_MODULE_LINH_MUC_ADD}/getInfoField`,
  mutationType: `${MODULE_MODULE_LINH_MUC_ADD}/updateInfoField`,
})

export default {
  name: 'TabGeneralForm',
  mixins: [linhMucMix.tabData],
  components: {
    InfoGiaoXuAutocomplete,
    InfoTenThanhAutocomplete,
    InfoDongAutocomplete,
  },
  computed: {
    ...mapFields(MAP_PC_LINHMUCS),
  },
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC_ADD, [
      ACTION_SET_IMAGE,
      'ACTION_UPDATE_DROPDOWN_GIAO_XU',
      'ACTION_UPDATE_DROPDOWN_RIP_GIAO_XU',
      'ACTION_UPDATE_DROPDOWN_DONG',
      'ACTION_UPDATE_DROPDOWN_TEN_THANH_LIST'
    ]),
  },
}
</script>
