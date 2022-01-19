<template>
  <tr>
    <td>{{ _getNo() }}</td>
    <td class="text-center">
      <input
        type="checkbox"
        name="selected[]"
        :id="`info_select_id_${info.id}`"
        :value="info.id"
      />
    </td>
    <td class="text-left">{{ info.name }}</td>
    <td>
      {{ $cmsCfg.loaiChucVus[info.type_giao_xu] }}
    </td>
    <td class="text-center">{{ info.sort_id }}</td>
    <td class="text-center">{{ info.active_text }}</td>
    <td class="text-right">
      <a
        href="javascript:void(0);"
        data-toggle="tooltip"
        @click.prevent="_showModal"
        class="btn btn-default cms-btn"
        data-original-title="Sửa Tin"
        ><i class="fa fa-edit" />
      </a>
      <btn-delete :info-id="info.id"></btn-delete>
    </td>
  </tr>
</template>

<script>
import { mapActions, mapState, } from 'vuex'
import BtnDelete from './TheBtnDelete'
import {
  fn_get_base_url_image,
  fn_format_dd_mm_yyyy,
} from '@app/api/utils/fn-helper'
import { MODULE_MODULE_CHUC_VU_EDIT, } from 'store@admin/types/module-types'
import {
  ACTION_GET_INFO_BY_ID,
} from 'store@admin/types/action-types'

export default {
  name: 'TheItem',
  components: {
    BtnDelete,
  },
  props: {
    info: {
      type: Object,
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
  },
  methods: {
    ...mapActions(MODULE_MODULE_CHUC_VU_EDIT, [ACTION_GET_INFO_BY_ID]),
    _getImgUrl() {
      return fn_get_base_url_image(this.info.image)
    },
    _getNo() {
      return parseInt(this.no) + parseInt(this.meta.from)
    },
    _formatDate(date) {
      return fn_format_dd_mm_yyyy(date)
    },
    async _showModal() {
      if (this.info?.id) {
        await this[ACTION_GET_INFO_BY_ID](this.info.id)
        this.$emit('show-modal-edit')
      }
    },
  },
}
</script>
