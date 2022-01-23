<template>
  <a
    href="javascript:void(0);"
    data-toggle="tooltip"
    @click="_showModal()"
    class="btn btn-default cms-btn"
    data-original-title="Sửa Tin"
  >
    <font-awesome-layers size="1x" style="background: honeydew">
      <font-awesome-icon icon="edit" />
    </font-awesome-layers>
  </a>
</template>

<script>
import { fn_redirect_url, } from '@app/api/utils/fn-helper'

export default {
  name: 'TheButtonEdit',
  props: {
    isRedirect: {
      type: Boolean,
      default: true,
    },
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
    _showModal() {
      if (this.isRedirect) {
        this._redirectUrl()
      }
    },
    _redirectUrl() {
      return fn_redirect_url(`${this.$cmsCfg.adminPrefix}/dongs/edit/${this.infoId}`)
    },
  },
}
</script>
