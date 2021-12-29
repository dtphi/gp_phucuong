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
            v-model="groupData.sort_order"
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
          v-model="groupData.information_type"
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
          v-model="groupData.status"
          id="input-info-status"
          class="form-control"
        >
          <option value="1" selected="selected">Xảy ra</option>
          <option value="0">Ẩn</option>
        </select>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters, } from 'vuex'
import {
  MODULE_MODULE_DANHMUC_GIAOPHAN,
  MODULE_MODULE_DANHMUC_GIAOPHAN_ADD,
} from 'store@admin/types/module-types'
import InfoDateAvailable from './Datapicker/InfoDateAvailable'

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
    ...mapState(MODULE_MODULE_DANHMUC_GIAOPHAN, ['newsGroups']),
    ...mapGetters(MODULE_MODULE_DANHMUC_GIAOPHAN, ['loading']),
    ...mapGetters(MODULE_MODULE_DANHMUC_GIAOPHAN_ADD, ['isOpen']),
  },
}
</script>
