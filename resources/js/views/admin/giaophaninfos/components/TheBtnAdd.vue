<template>
  <button
    @click="_showModal()"
    data-toggle="tooltip"
    title=""
    class="btn btn-primary"
    data-original-title="Thêm Tin Tức"
  >
    <i class="fa fa-plus"></i>
  </button>
</template>

<script>
import { mapActions, } from 'vuex'
import { MODULE_TINTUC_GIAOPHAN_MODAL, } from 'store@admin/types/module-types'
import { ACTION_SHOW_MODAL, } from 'store@admin/types/action-types'
import { fn_redirect_url, } from '@app/api/utils/fn-helper'

export default {
  name: 'TheButtonAddGiaoPhanTinTuc',
  props: {
    isRedirect: {
      type: Boolean,
      default: true,
    },
  },
  methods: {
    ...mapActions(MODULE_TINTUC_GIAOPHAN_MODAL, [ACTION_SHOW_MODAL]),
    _showModal() {
      if (this.isRedirect) {
        return this._redirectUrl()
      } else {
        this[ACTION_SHOW_MODAL]('add')
      }
    },
    _redirectUrl() {
      return fn_redirect_url(`${this.$cmsCfg.adminPrefix}/giao-phan/tin-tucs/add`)
    },
    _pushAddPage() {
      this.$router.push(`/${this.$cmsCfg.adminPrefix}/giao-phan/tin-tucs/add`)
    },
  },
}
</script>
