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
    <td class="text-left">{{ info.code }}</td>
    <td class="text-left">{{ info.name }}</td>
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
import { MODULE_MODULE_LE_CHINH_EDIT, } from 'store@admin/types/module-types'
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
    _getNo() {
      return parseInt(this.no) + parseInt(this.meta.from)
    },
    _showModal() {
      if (this.info?.id) {
        this.$emit('show-modal-edit', this.info)
      }
      this.$store.commit(`${MODULE_MODULE_LE_CHINH_EDIT}/${INFOS_MODAL_SET_INFO}`, this.info)
    },
  },
}
</script>
