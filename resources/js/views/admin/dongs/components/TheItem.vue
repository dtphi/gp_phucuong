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
    <td class="text-left">{{ info.dia_chi }}</td>
    <td class="text-center">{{ info.email }}</td>
    <td class="text-center">{{ info.active }}</td>
    <td class="text-right">
      <btn-edit :info-id="info.id"></btn-edit>
    </td>
  </tr>
</template>

<script>
import { mapState, } from 'vuex'
import BtnEdit from './TheBtnEdit'

export default {
  name: 'TheItemDongs',
  components: {
    BtnEdit,
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
  },
}
</script>
