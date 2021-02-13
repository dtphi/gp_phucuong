<template>
  <transition name="modal-news-add">
    <div :class="classShow" :style="styleCss" data-keyboard="false">
      <div class="modal-dialog modal-lg">
        <ValidationObserver ref="observerInfo" @submit.prevent="_submitInfo">
          <div class="modal-content">
            <LoadingOverLay :active.sync="loading" :is-full-page="fullPage" />
            <div class="modal-header">
              <h4 class="modal-title">{{_getSetForm.title}}</h4>
              <button type="button" class="close" @click="_close">
                <span aria-hidden="true"><font-awesome-icon icon="times" /></span>
              </button>
            </div>
            <div class="modal-body">
              <!-- form start -->
              <div class="form-horizontal">
                <div class="card-body" v-if="_isShowBody">
                  <div class="form-group row">
                    <label for="news_name" class="col-sm-2 col-form-label">{{$options.setting.nameTxt}}</label>
                    <div class="col-sm-10">
                      <ValidationProvider name="news_name" rules="required|max:191" v-slot="{ errors }">
                        <input v-model="newsData.news_name" type="text" class="form-control" :placeholder="$options.setting.nameTxt">
                        <span class="text-red">{{ errors[0] }}</span>
                      </ValidationProvider>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="news_description" class="col-sm-2 col-form-label">{{$options.setting.descriptionTxt}}</label>
                    <div class="col-sm-10">
                      <ValidationProvider name="news_description" rules="required|max:191" v-slot="{ errors }">
                        <input v-model="newsData.news_description" class="form-control" :placeholder="$options.setting.descriptionTxt">
                        <span class="text-red">{{ errors[0] }}</span>
                      </ValidationProvider>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="news_newslink" class="col-sm-2 col-form-label">{{$options.setting.newslinkTxt}}</label>
                    <div class="col-sm-10">
                      <ValidationProvider name="news_newslink" rules="required|minLength:8|max:191" v-slot="{ errors }">
                        <input v-model="newsData.newslink" class="form-control" :placeholder="$options.setting.newslinkTxt">
                      <span class="text-red">{{ errors[0] }}</span>
                      </ValidationProvider>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" @click="_close">{{$options.setting.btnCancelTxt}}</button>
              <button type="button" class="btn btn-success" @click="_submitInfo">{{_getSetForm.btnSubmitTxt}}</button>
            </div>
          </div>
        </ValidationObserver>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
  </transition>
</template>

<script>
    import { mapState, mapGetters, mapActions } from 'vuex';
    import {
      MODULE_INFO_MODAL
    } from 'store@admin/types/module-types';
    import {
      ACTION_CLOSE_MODAL,
      ACTION_SET_LOADING,
      ACTION_INSERT_INFO,
      ACTION_UPDATE_INFO
    } from 'store@admin/types/action-types';

    export default {
        name: 'TheModalAddForm',
        data() {
            return {
              fullPage: false,
              newsData: {}
            };
        },
        computed: {
          ...mapState(MODULE_INFO_MODAL, {
            formAction: state => state.action,
            loading: state => state.loading
          }),

          ...mapGetters(MODULE_INFO_MODAL, [
            'classShow',
            'styleCss',
            'info',
          ]),

          _getSetForm() {console.log('getSetForm')
            let setting = this.$options.setting.add;

            if (this.formAction) {
              setting = this.$options.setting[this.formAction];

              if (this._isModalClose()) {
                this.newsData = {}
              } else {
                this.newsData = {...this.info}
              }
            }

            return setting;
          }
        },

        updated() {
          if (this._isModalClose()) {
            this._resetModalClose()
          }
        },

        methods: {
          ...mapActions(MODULE_INFO_MODAL, [
            ACTION_CLOSE_MODAL,
            ACTION_SET_LOADING,
            ACTION_INSERT_INFO,
            ACTION_UPDATE_INFO
          ]),

          async _resetModalClose() {
            this.$data.newsData = {};
            requestAnimationFrame(() => {
              this.$refs.observerInfo.reset()
            });
          },

          _isShowBody() {
            return (this._isAddAction() || this._isEditAction())
          },

          _isAddAction() {
            return (this.formAction === this.$options.setting.add.actionName)
          },

          _isEditAction() {
            return (this.formAction === this.$options.setting.edit.actionName)
          },

          _isModalClose() {
            return (this.formAction === this.$options.setting.closeModal.actionName)
          },

          _close() {
            this.[ACTION_CLOSE_MODAL]()
          },

          async _submitInfo() {
            const _self = this;
            _self.[ACTION_SET_LOADING](true);
            _self.$refs.observerInfo.validate().then((isValid) => {
              if (isValid) {
                if (_self._isEditAction()) {
                  _self.[ACTION_UPDATE_INFO](_self.newsData)
                } else {
                  _self.[ACTION_INSERT_INFO](_self.newsData)
                }
              } else {
                _self.[ACTION_SET_LOADING](false)

                return false;
              }
            });
          }
        },
        setting: {
          btnCancelTxt: 'Close',
          nameTxt: 'Name',
          descriptionTxt: 'Description',
          newslinkTxt: 'News Link',
          add: {
            actionName: 'add',
            isAddFrom: true,
            title: 'Add News',
            btnSubmitTxt: 'Save'
          },
          edit: {
            actionName: 'edit',
            isAddFrom: false,
            title: 'Edit News',
            btnSubmitTxt: 'Update'
          },
          closeModal: {
            actionName: 'close_modal',
            isAddFrom: false,
            title: '',
            btnSubmitTxt: ''
          }
        }
    };
</script>