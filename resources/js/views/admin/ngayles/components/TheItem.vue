<template>
  <tr>
    <!-- thong tin trong table -->
    <td>{{ _getNo() }}</td>
    <td class="text-left">{{ info.code }}</td>
    <td class="text-center">{{ info.ten_le }}</td>
    <td class="text-left">{{ info.solar_day }}</td>
    <td class="text-left">{{ info.solar_month }}</td>
    <td class="text-left">{{ info.lunar_day }}</td>
    <td class="text-left">{{ info.lunar_month }}</td>
    <td class="text-right">
      <a
        href="javascript:void(0);"
        data-toggle="tooltip"
        @click.prevent="_showModal"
        class="btn btn-default cms-btn"
        data-original-title="Sửa Tin"
        ><i class="fa fa-edit" />
      </a>
      <btn-delete :info-id="info.id" :no="no"></btn-delete>
    </td>
  </tr>
</template>

<script>
import { mapState } from 'vuex'
import BtnDelete from './TheBtnDelete'

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
      meta: (state) => state.cfApp.collectionData,
    }),
  },
  methods: {
    _getNo() {
      return parseInt(this.no) + parseInt(this.meta.from)
    },
    _showModal() {
      this.$emit('show-modal-edit', this.info)
    },
  },
}
</script>