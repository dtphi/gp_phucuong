<template>
  <a
    href="javascript:void(0);"
    data-toggle="tooltip"
    @click="_showDiaglogConfirm()"
    class="btn btn-default cms-btn"
    data-original-title="Xóa"
  >
    <font-awesome-layers size="xs" style="background: MistyRose">
      <font-awesome-icon icon="circle" style="color: Tomato" />
      <font-awesome-icon icon="times" class="fa-inverse" transform="shrink-4" />
    </font-awesome-layers>
  </a>
</template>

<script>
import { mapActions, } from 'vuex'
import { MODULE_MODULE_CO_SO, } from 'store@admin/types/module-types'
import {
  ACTION_SET_INFO_DELETE_BY_ID,
  ACTION_DELETE_INFO_BY_ID,
} from 'store@admin/types/action-types'

export default {
  name: 'TheButtonDelete',
  props: {
    infoId: {
      type: Number,
      default: 0,
      validator: function(value) {
        return value && Number.isInteger(value)
      },
    },
  },
  data() {
    return {}
  },
  methods: {
    ...mapActions(MODULE_MODULE_CO_SO, [
      ACTION_SET_INFO_DELETE_BY_ID,
      ACTION_DELETE_INFO_BY_ID
    ]),
    _showDiaglogConfirm() {
      this[ACTION_SET_INFO_DELETE_BY_ID](this.infoId)
      this.$modal.show('dialog', {
        title: 'Xóa cơ sở giáo phận',
        text: 'Bạn muốn xóa cơ sở giáo phận ?',
        buttons: [
          {
            title: 'Hủy',
            handler: () => {
              this.$modal.hide('dialog')
            },
          },
          {
            title: 'Xóa',
            handler: () => {
              this[ACTION_DELETE_INFO_BY_ID](this.infoId)
              this.$modal.hide('dialog')
            },
          }
        ],
      })
    },
  },
}
</script>
