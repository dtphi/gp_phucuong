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
import { MODULE_INFO_MODAL, } from 'store@admin/types/module-types'
import { ACTION_SHOW_MODAL, } from 'store@admin/types/action-types'
import { fn_redirect_url, } from '@app/api/utils/fn-helper'

export default {
  name: 'TheButtonAdd',
  props: {
    isRedirect: {
      type: Boolean,
      default: true,
    },
  },
  methods: {
    ...mapActions(MODULE_INFO_MODAL, {
      showModal: ACTION_SHOW_MODAL,
    }),
    _showModal() {
      if (this.isRedirect) {
        return this._redirectUrl()
      } else {
        this.showModal('add')
      }
    },
    _redirectUrl() {
      return fn_redirect_url(`${this.$cmsCfg.adminPrefix}/informations/add`)
    },
    _pushAddPage() {
      this.$router.push(`/${this.$cmsCfg.adminPrefix}/informations/add`)
    },
  },
}
</script>
