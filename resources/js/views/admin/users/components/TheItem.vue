<template>
  <tr>
    <td>{{ _getNo() }}</td>
    <td class="text-center">
      <input
        type="checkbox"
        name="selected[]"
        :id="`user_select_id_${user.id}`"
        :value="user.id"
      />
    </td>
    <td>{{ user.name }}</td>
    <td class="text-center">{{ user.email }}</td>
    <td class="text-center">{{ user.last_logged_in_at }}</td>
    <td class="text-center">{{ $helper.fn_format_dd_mm_yyyy(user.created_at) }}</td>
    <td class="text-right">
      <div>
        <btn-edit :user-id="user.id"></btn-edit>
        <btn-delete :user-id="user.id"></btn-delete>
      </div>
    </td>
  </tr>
</template>

<script>
import { mapState, } from 'vuex'
import BtnEdit from './TheBtnEdit'
import BtnDelete from './TheBtnDelete'

export default {
  name: 'TheItemUser',
  components: {
    BtnEdit,
    BtnDelete,
  },
  props: {
    user: {
      type: Object,
      default: () => {
        return {}
      },
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
      meta: state => state.cfApp.meta,
    }),
  },
  methods: {
    _getNo() {
      return this.no + this.meta.from
    },
  },
}
</script>
