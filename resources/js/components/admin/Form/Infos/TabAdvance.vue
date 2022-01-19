<template>
  <div class="tab-content">
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-info-date-available"
        >Ngày hoạt động</label
      >
      <info-date-available
        class="col-sm-10"
        id="input-info-date-available"
        :group-data="groupData"
      ></info-date-available>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-info-sort-order"
        >Thứ tự</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="sort_order"
          rules="numeric|max:191"
          v-slot="{ errors }"
        >
          <input
            type="text"
            v-model="sort_order"
            name="sort_order"
            placeholder="Thứ tự hiển thị"
            id="input-info-sort-order"
            class="form-control"
          />

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-info-type"
        >Loại Tin</label
      >
      <div class="col-sm-10">
        <select
          v-model="information_type"
          id="input-info-type"
          class="form-control"
        >
          <option value="1" selected="selected">Tin tức</option>
          <option value="2">Video</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-info-status"
        >Trạng thái</label
      >
      <div class="col-sm-10">
        <select
          v-model="status"
          id="input-info-status"
          class="form-control"
        >
          <option value="1" selected="selected">Xảy ra</option>
          <option value="0">Ẩn</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-info-album"
        >Album hình ảnh</label
      >
      <div class="col-sm-10">
        <select
          v-model="album"
          id="input-info-album"
          class="form-control"
        >
          <option value="0" selected="selected">-- Chọn Album --</option>
          <option
            v-for="album in albumDropdowns"
            :key="album.album_id"
            :value="album.album_id"
          >
            {{ album.name }}
          </option>
        </select>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions, } from 'vuex'
import {
  MODULE_NEWS_CATEGORY,
  MODULE_NEWS_CATEGORY_ADD,
  MODULE_INFO_ADD,
} from 'store@admin/types/module-types'
import InfoDateAvailable from './Datapicker/InfoDateAvailable'
import { createHelpers, } from 'vuex-map-fields'
import { MAP_PC_INFORMATIONS, } from 'store@admin/types/model-map-fields'
const { mapFields, } = createHelpers({
  getterType: `${MODULE_INFO_ADD}/getInfoField`,
  mutationType: `${MODULE_INFO_ADD}/updateInfoField`,
})

export default {
  name: 'TabAdvanceForm',
  components: {
    InfoDateAvailable,
  },
  props: {
    groupData: {
      type: Object,
    },
  },
  computed: {
    ...mapFields(MAP_PC_INFORMATIONS),
    ...mapState(MODULE_NEWS_CATEGORY, ['newsGroups']),
    ...mapState(MODULE_INFO_ADD, ['albumDropdowns']),
    ...mapGetters(MODULE_NEWS_CATEGORY, ['loading']),
    ...mapGetters(MODULE_NEWS_CATEGORY_ADD, ['isOpen']),
  },
  methods: {
    ...mapActions(MODULE_INFO_ADD, ['ACTION_GET_DROPDOWN_ALBUM_LIST']),
  },
  mounted() {
    this.ACTION_GET_DROPDOWN_ALBUM_LIST({
      action: 'info.album.dropdown',
    })
  },
}
</script>
