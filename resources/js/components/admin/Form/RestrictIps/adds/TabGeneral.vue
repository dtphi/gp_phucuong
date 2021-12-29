<template>
  <div class="tab-content">
    <!-- IP -->
    <div class="form-group required">
      <label for="input-info-ip" class="col-sm-2 control-label">{{
        $options.setting.name_txt
      }}</label>
      <div class="col-sm-10">
        <validation-provider
          name="info_ip"
          :rules="{required: true, max: 16, regex:/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/}"
          v-slot="{ errors }"
        >
          <input
            v-model="groupData.ip"
            type="text"
            id="input-info-ip"
            class="form-control"
            :placeholder="$options.setting.name_txt"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <!-- ACTIVE -->
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-info-active"
        >Trạng thái</label
      >
      <div class="col-sm-10">
        <select
          v-model="groupData.active"
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
import { config, } from '@app/common/config'
import { extend, } from 'vee-validate'
import { regex, } from 'vee-validate/dist/rules'
extend('regex', {
  ...regex,
  message: 'IP Invalid',
})
export default {
  name: 'TabGeneralForm',
  props: {
    groupData: {
      type: Object,
    },
  },
  data() {
    return {
    }
  },
  setting: {
    cf: config,
    name_txt: 'IP',
  },
}
</script>
