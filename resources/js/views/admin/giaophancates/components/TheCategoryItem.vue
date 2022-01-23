<template>
  <tr>
    <td class="text-center">
      <input
        type="checkbox"
        name="selected[]"
        :id="`cate_select_id_${categoryItem.category_id}`"
        :value="categoryItem.category_id"
      />
    </td>
    <td class="text-left">{{ categoryItem.category_name }}</td>
    <td class="text-center">{{ categoryItem.sort_order }}</td>
    <td class="text-right">
      <the-btn-edit :category-id="categoryItem.category_id"></the-btn-edit>
      <the-btn-delete-confirm
        :category-id="categoryItem.category_id"
      ></the-btn-delete-confirm>
    </td>
  </tr>
</template>

<script>
import TheBtnEdit from './TheBtnEdit'
import TheBtnDeleteConfirm from './TheBtnDeleteConfirm'
import { mapState, } from 'vuex'

export default {
  name: 'DanhmucGiaophanItem',
  components: {
    TheBtnEdit,
    TheBtnDeleteConfirm,
  },
  props: {
    categoryItem: {
      type: Object,
      validator: function(value) {
        var id = value.category_id && Number.isInteger(value.category_id)
        var name = value.category_name && value.category_name.length
        
        return id && name
      },
    },
    no: {
      default: 1,
    },
  },
  computed: {
    ...mapState({
      meta: state => state.cfApp.meta,
    }),
  },
  data() {
    return {}
  },
  methods: {
    _getNo() {
      return this.no + this.meta.from
    },
  },
}
</script>
