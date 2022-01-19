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
    <td class="text-left">{{ info.albums_name }}</td>
    <td class="text-left">{{ info.name_group_albums }}</td>
    <td class="text-center">
      <button @click="changeStatus">
        <i v-if="info.status == 1" class="fa fa-check-circle btn_blue"></i>
        <i v-else class="fa fa-minus-circle btn_red"></i>
      </button>
    </td>
    <td class="text-center" style="width: 7%">
      <img :src="info.imgThum" class="img-thumbnail" />
    </td>
    <td class="text-right">
      <btn-edit :info-id="info.id" :href-edit="info.hrefDetail"></btn-edit>
      <btn-delete :info-id="info.id" :no="no"></btn-delete>
    </td>
  </tr>
</template>

<script>
import BtnEdit from './TheBtnEdit'
import BtnDelete from './TheBtnDelete'
import { mapState, mapActions, } from 'vuex'
import { MODULE_MODULE_ALBUMS, } from 'store@admin/types/module-types'
import { ACTION_CHANGE_STATUS, } from 'store@admin/types/action-types'

export default {
  name: 'TheItem',
  components: {
    BtnEdit,
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
      perPage: state => state.cfApp.perPage,
    }),
  },
  methods: {
    _getNo() {
      return parseInt(this.no) + parseInt(this.meta.from)
    },
    ...mapActions(MODULE_MODULE_ALBUMS, {
      'changeStatusItem': ACTION_CHANGE_STATUS,
    }),
    changeStatus() {
      if(this.info.status == 1) {
        this.info.status = 0
      }else {this.info.status = 1}
      this.changeStatusItem({ id: this.info.id, status: this.info.status, perPage: this.perPage, })
    },
  },
}
</script>
<style scoped>
  .btn_blue{
    color: blue;
  }
  .btn_red{
    color: red;
  }
</style>
