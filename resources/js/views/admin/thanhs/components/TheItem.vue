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
    <td>{{ info.latin }}</td>
    <td class="text-center">{{ info.bon_mang }}</td>
    <td>
      <div v-html="info.ghi_chu"></div>
    </td>
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
import { mapState, } from 'vuex'
import BtnDelete from './TheBtnDelete'
import { MODULE_MODULE_THANH_EDIT, } from 'store@admin/types/module-types'
import {
  INFOS_MODAL_SET_INFO,
} from 'store@admin/types/mutation-types'

export default {
  name: 'TheItem',
  components: {
    BtnDelete,
  },
  props: {
    info: {
      type: Object,
      validator: value => {
        var id = value.id && Number.isInteger(value.id)
        var name = value.name && value.name.length
        
        return id && name
      },
    },
    no: {
      default: 1,
    },
  },
  computed: {
    ...mapState({
      meta: state => state.cfApp.collectionData,
    }),
  },
  methods: {
    _getNo() {
      return parseInt(this.no) + parseInt(this.meta.from)
    },
    _showModal() {
      if (this.info?.id) {
        this.$emit('show-modal-edit', this.info)
      }
      this.$store.commit(`${MODULE_MODULE_THANH_EDIT}/${INFOS_MODAL_SET_INFO}`, this.info)
    },
  },
}
</script>
