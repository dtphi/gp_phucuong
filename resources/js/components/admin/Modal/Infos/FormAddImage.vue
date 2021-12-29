<template>
    <div id="user-add-modal" class="modal-open">
        <div  :class="classShow" :style="styleCss">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <validation-observer ref="observerUser" @submit.prevent="_submitUser">
                        <div class="modal-header">
                          <button type="button" class="close" @click="_close" aria-hidden="true">&times;</button>
                          <h4 class="modal-title">{{$options.setting.modal_title}}</h4>
                        </div>

                        <div class="modal-body">
                            <template v-if="_errors">
                                <div class="alert alert-danger">
                                    <i class="fa fa-exclamation-circle"></i>
                                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                                  <p v-for="(err, idx) in _errorToArrs()" :key="idx">{{err}}</p>
                                </div>
                            </template>
                            <template v-if="loading">
                                <div style="height: 100px">
                                    <loading-over-lay 
                                    :active.sync="loading" 
                                    :is-full-page="fullPage"></loading-over-lay>
                                </div>
                            </template>

                            <template>
                                <div class="form-horizontal">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                          <div id="modal-media-info-manager"></div>
                                          <input type="hidden" class="form-control" id="multi-file-input" disabled>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default"
                                    @click="_close">{{$options.setting.btnCancelTxt}}
                            </button>
                        </div>
                    </validation-observer>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {
  mapGetters,
  mapState,
  mapActions,
} from 'vuex'
import {
  MODULE_USER_MODAL,
} from 'store@admin/types/module-types'
import {
  ACTION_CLOSE_MODAL,
  ACTION_INSERT_USER,
} from 'store@admin/types/action-types'
import { MM, } from '@app/tools/mm/dist/mm.min'
import { EventBus, } from '@app/api/utils/event-bus'

export default {
  name: 'UserAddForm',
  data() {
    return {
      fullPage: false,
      mediaMM : null,
    }
  },
  computed: {
    ...mapState(MODULE_USER_MODAL, {
      loading: state => state.loading,
      errors: state => state.errors,
    }),
    ...mapGetters(MODULE_USER_MODAL, [
      'classShow',
      'styleCss',
      'user'
    ]),
    _errors() {
      return this.errors.length
    },
  },
  mounted() {
    const self = this

    this.mediaMM = new MM({
      el: '#modal-media-info-manager',
      api: {
        baseUrl: window.origin + '/api/mmedia',
        listUrl: 'list',
        downloadUrl: 'download',  // optional
        uploadUrl: 'upload',      // optional
        deleteUrl: 'delete',       // optional
      },
      input: {
        el: '#multi-file-input',
        multiple: true,
      },
      onSelect : function(event) {
        self._changeImage(event)
      },
    })
    console.log(this)
    this._close()
  },
  methods: {
    ...mapActions(MODULE_USER_MODAL, [
      ACTION_CLOSE_MODAL,
      ACTION_INSERT_USER
    ]),
    _changeImage(fi) {
      EventBus.$emit('on-multi-selected-image', fi)
    },
    async _resetModal() {
      requestAnimationFrame(() => {
        this.$refs.observerUser.reset()
      })
    },
    _isShowBody() {
      return (this.user != null)
    },
    _close() {
      this[ACTION_CLOSE_MODAL]()
    },
    _errorToArrs() {
      let errs = []
      if (this.errors.length && typeof this.errors[0].messages !== 'undefined') {
        errs = Object.values(this.errors[0].messages)
      }
      if (Object.entries(errs).length === 0 && this.errors.length) {
        errs.push(this.$options.setting.error_msg_system)
      }

      return errs
    },
    async _submitUser() {
      const _self = this
      await _self.$refs.observerUser.validate().then((isValid) => {
        if (isValid) {
          _self[ACTION_INSERT_USER](_self.user)
          _self._resetModal()
        }
      })
    },
  },
  setting: {
    btnCancelTxt: 'Thoát',
    modal_title: 'Thêm hình ảnh bổ sung',
    error_msg_system: 'Lỗi hệ thống !',
  },
}
</script>
