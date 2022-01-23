<template>
  <div class="tab-content">
    <!-- GROUP NAME -->
    <div class="form-group required">
      <label for="input-info-group-name" class="col-sm-2 control-label">{{
        $options.setting.name_txt
      }}</label>
      <div class="col-sm-10">
        <validation-provider
          name="input-info-group-name"
          rules="required|max:100"
          v-slot="{ errors }"
        >
          <input
            v-model="groupData.group_name"
            type="text"
            id="input-info-group-name"
            class="form-control"
            :placeholder="$options.setting.name_txt"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <!-- SORT ORDER -->
    <div class="form-group">
        <label class="col-sm-2 control-label"
                for="input-info-sort-id">Thứ tự</label>
        <div class="col-sm-10">
            <validation-provider
                name="sort_order"
                rules="numeric|max:191"
                v-slot="{ errors }">
                <input type="text"
                        v-model="groupData.sort_id"
                        name="sort_order"
                        placeholder="Thứ tự hiển thị"
                        id="input-info-sort-id"
                        class="form-control"/>

                <span class="cms-text-red">{{ errors[0] }}</span>
            </validation-provider>
        </div>
    </div> 
    <!-- STATUS -->
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-info-active"
        >Trạng thái</label
      >
      <div class="col-sm-10">
        <select
          v-model="groupData.status"
          id="input-info-active"
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
import { mapState, } from 'vuex'
import { MODULE_MODULE_GROUP_ALBUMS_EDIT, } from 'store@admin/types/module-types'

export default {
  name: 'TabGeneralForm',
  data() {
    return {
    }
  },
  computed: {
    ...mapState(MODULE_MODULE_GROUP_ALBUMS_EDIT, {
      groupData: (state) => state.info.data || {},
    }),
    _errors() {
      return this.errors.length
    },
  },
  setting: {
    name_txt: 'Group Name',
  },
}
</script>
