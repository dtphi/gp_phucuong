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
    <td class="text-left">
      <a :href="info.linh_muc_url">{{ info.ten_linh_muc }}</a>
    </td>
    <td class="text-left">{{ info.fromgiaoxuName }}</td>
    <td class="text-left">{{ info.fromchucvuName }}</td>
    <td class="text-left">{{ info.label_from_date }}</td>
    <td class="text-left">{{ info.ducchaName }}</td>
    <td class="text-left">
      <a :href="info.giao_xu_url">{{ info.giaoxuName }}</a>
    </td>
    <td class="text-left">{{ info.label_to_date }}</td>
    <td class="text-left">
      {{ info.chucvuName }}
    </td>
    <td class="text-left">
      <div @click="changeStatus" style="cursor: pointer;">
        <i v-if="info.chucvu_active == 1" class="fa fa-check-circle btn_blue"></i>
        <i v-else class="fa fa-minus-circle btn_red"></i>
      </div>
    </td>
    <td class="text-right">
      <a
        href="javascript:void(0);"
        data-toggle="tooltip"
        @click.prevent="_showModal()"
        class="btn btn-default cms-btn"
        data-original-title="Sửa Tin"
        ><i class="fa fa-edit" />
      </a>
      <btn-delete :info-id="info.id"></btn-delete>
    </td>
  </tr>
</template>

<script>
import { mapState, mapActions} from 'vuex'
import BtnDelete from './TheBtnDelete'
import { MODULE_MODULE_THUYEN_CHUYEN, } from 'store@admin/types/module-types'
import { ACTION_CHANGE_STATUS, } from 'store@admin/types/action-types'

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
    ...mapActions(MODULE_MODULE_THUYEN_CHUYEN, {
      changeStatusItem: ACTION_CHANGE_STATUS,
    }),
    _getNo() {
      return parseInt(this.no) + parseInt(this.meta.from)
    },
    _showModal() {
      this.$emit('show-modal-edit', this.info)
    },
    changeStatus() {
      if (this.info.chucvu_active == 1) {
        this.info.chucvu_active = 0
      } else {
        this.info.chucvu_active = 1
      }
      this.changeStatusItem({
        id: this.info.id,
        status: this.info.chucvu_active,
        perPage: this.perPage,
      })
    },
  },
}
</script>
<style scoped>
.btn_blue {
  color: blue;
}
.btn_red {
  color: red;
}
</style>

