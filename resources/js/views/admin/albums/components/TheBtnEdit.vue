<template>
    <a href="javascript:void(0);" data-toggle="tooltip"
       @click="_showModal()"
       class="btn btn-default cms-btn"
       data-original-title="Sửa Albums">
        <font-awesome-layers size="1x" style="background:honeydew">
            <font-awesome-icon icon="edit"/>
        </font-awesome-layers>
    </a>
</template>

<script>
import {
  MODULE_ALBUMS_MODAL,
} from 'store@admin/types/module-types'
import {
  ACTION_SHOW_MODAL_EDIT,
} from 'store@admin/types/action-types'
import {
  fn_redirect_url,
} from '@app/api/utils/fn-helper'
import {
  config,
} from '@app/common/config'
import { mapActions, } from 'vuex'

export default {
  name: 'TheButtonEditAlbums',
  props: {
    isRedirect: {
      type: Boolean,
      default: true,
    },
    infoId: {
      type: Number,
      default: 0,
      validator: function(value) {
        return (value && Number.isInteger(value))
      },
    },
    hrefEdit: {
      type: String,
      default: '',
    },
  },
  data() {
    return {}
  },
  methods: {
    ...mapActions(MODULE_ALBUMS_MODAL, {
      'showModal': ACTION_SHOW_MODAL_EDIT,
    }),
    _showModal() {
      if (this.isRedirect) {
        this._redirectUrl()
      } else {
        this.showModal(this.infoId)
      }
    },
    _redirectUrl() {
      if (this.hrefEdit) 
        return window.location.href = this.hrefEdit
      
      return fn_redirect_url(`${config.adminPrefix}/albums/edit/${this.infoId}`)
    },
  },
}
</script>
