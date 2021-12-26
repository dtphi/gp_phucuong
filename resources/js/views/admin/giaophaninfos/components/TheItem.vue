<template>
  <tr>
    <td>{{ _getNo() }}</td>
    <td class="text-center">
      <input
        type="checkbox"
        name="selected[]"
        :id="`info_select_id_${info.information_id}`"
        :value="info.information_id"
      />
    </td>
    <td class="text-left">{{ info.name }}</td>
    <td class="text-center" style="width: 7%">
      <img :src="info.imgThum" class="img-thumbnail" />
    </td>
    <td class="text-center">{{ _formatDate(info.date_available) }}</td>
    <td class="text-center">{{ _formatDate(info.created_at) }}</td>
    <td class="text-center">{{ info.status_text }}</td>
    <td class="text-center">
      <input
        type="checkbox"
        @change="_infoSpecialChange"
        :checked="_module_special_info_ids"
      />
    </td>
    <td class="text-right">
      <btn-edit :info-id="info.information_id"></btn-edit>
      <btn-delete :info-id="info.information_id"></btn-delete>
    </td>
  </tr>
</template>

<script>
import { mapState, mapActions, } from 'vuex'
import { MODULE_INFO, } from 'store@admin/types/module-types'
import { ACTION_UPDATE_INFO_SPECIAL, } from 'store@admin/types/action-types'
import BtnEdit from './TheBtnEdit'
import BtnDelete from './TheBtnDelete'
import {
  fn_get_base_url_image,
  fn_format_dd_mm_yyyy,
} from '@app/api/utils/fn-helper'

export default {
  name: 'TheItemGiaoPhanTinTuc',
  components: {
    BtnEdit,
    BtnDelete,
  },
  props: {
    info: {
      type: Object,
      validator: function(value) {
        var id = value.information_id && Number.isInteger(value.information_id)
        var name = value.name && value.name.length
        
        return id && name
      },
    },
    no: {
      default: 1,
    },
  },
  data() {
    return {}
  },
  computed: {
    ...mapState({
      meta: state => state.cfApp.collectionData,
    }),
    ...mapState(MODULE_INFO, {
      module_special_info_ids: state => state.module_special_info_ids,
    }),
    _module_special_info_ids() {
      return this.module_special_info_ids.includes(this.info.information_id)
    },
  },
  methods: {
    ...mapActions(MODULE_INFO, [ACTION_UPDATE_INFO_SPECIAL, 'addSpecial']),
    _getImgUrl() {
      return fn_get_base_url_image(this.info.image)
    },
    _getNo() {
      return parseInt(this.no) + parseInt(this.meta.from)
    },
    _formatDate(date) {
      return fn_format_dd_mm_yyyy(date)
    },
    _infoSpecialChange(event) {
      const data = {
        info: this.info,
        isChecked: event.target.checked,
      }
      this.addSpecial(data)
    },
  },
}
</script>
