<template>
  <transition name="modal">
    <div :class="classShow" :style="styleCss" data-keyboard="false">
      <div class="modal-dialog modal-lg">
        <ValidationObserver ref="observerInfo" @submit.prevent="_submitInfo">
          <div class="modal-content">
            <LoadingOverLay :active.sync="loading" :is-full-page="fullPage" />
            <div class="modal-header">
              <h4 class="modal-title">{{_getSetForm.title}}</h4>
              <button type="button" class="close" aria-label="Close" @click="_close">
                <span aria-hidden="true">
                  <font-awesome-icon icon="times" />
                </span>
              </button>
            </div>
            <transition v-if="_getSetForm.isAddFrom && (!itemRoot)">
              <NewsGroupCurrent :parent-info="parentInfo"/>
            </transition>
            <div class="modal-body" v-if="groupData">
              <!-- form start -->
              <div class="form-horizontal">

                <transition name="card-body-add" v-if="_getSetForm.isAddFrom">
                  <div class="card-body">
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Name</label>
                      <div class="col-sm-10">
                        <ValidationProvider name="news_group_name" rules="required|max:191" v-slot="{ errors }">
                          <input v-model="groupData.name" type="text" class="form-control" placeholder="News Group Name">
                          <span class="text-red">{{ errors[0] }}</span>
                        </ValidationProvider>
                      </div>
                    </div>
                  </div>
                </transition>

                <transition name="card-body-edit" class="card-body" v-else>
                  <div class="card-body">
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Name</label>
                      <div class="col-sm-10">
                        <ValidationProvider name="news_group_name" rules="required|max:191" v-slot="{ errors }">
                          <input v-model="groupData.name" type="text" class="form-control" placeholder="News Group Name">
                          <span class="text-red">{{ errors[0] }}</span>
                        </ValidationProvider>
                      </div>
                    </div>
                  </div>
                </transition>

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
    import NewsGroupCurrent from './TheGroupInfo';
    import {
      MODULE_NEWS_GROUP,
      MODULE_NEWS_GROUP_MODAL
    } from 'store@admin/types/module-types';
    import {
      ACTION_CLOSE_MODAL,
      ACTION_SET_LOADING,
      ACTION_INSERT_NEWS_GROUP,
      ACTION_UPDATE_NEWS_GROUP,
      ACTION_GET_NEWS_GROUP_LIST,
      ACTION_RELOAD_GET_NEWS_GROUP_LIST,
    } from 'store@admin/types/action-types';

    export default {
        name: 'ModalAddForm',
        components: {NewsGroupCurrent},
        data() {
            return {
              fullPage: false,
              groupData: null
            };
        },
        computed: {
          ...mapState(MODULE_NEWS_GROUP_MODAL, {
            formAction: state => state.action,
            loading: state => state.loading,
            itemRoot: state => state.itemRoot
          }),
          ...mapGetters(MODULE_NEWS_GROUP_MODAL, [
            'classShow',
            'styleCss',
            'newsGroup',
            'parentInfo',
            'newsGroupAdd'
          ]),

          _getSetForm() {
            let setting = this.$options.setting.add;

            if (this.formAction) {
              setting = this.$options.setting[this.formAction];

              if (this.formAction === 'edit') this.groupData = {...this.newsGroup};

              if (this.formAction === 'add') this.groupData = {...this.newsGroupAdd};
            }

            return setting;
          }
        },
        updated() {
          if (this.formAction == 'close_modal') {
            requestAnimationFrame(() => {
              this.$refs.observerInfo.reset()
            });
          }
        },
        methods: {
          ...mapActions(MODULE_NEWS_GROUP_MODAL, [
            ACTION_CLOSE_MODAL,
            ACTION_SET_LOADING,
            ACTION_INSERT_NEWS_GROUP,
            ACTION_UPDATE_NEWS_GROUP
          ]),
          ...mapActions(MODULE_NEWS_GROUP, [
            ACTION_GET_NEWS_GROUP_LIST, 
            ACTION_RELOAD_GET_NEWS_GROUP_LIST
          ]),

          _close() {
            this.[ACTION_CLOSE_MODAL]()
          },

          async _submitInfo() {
            const _self = this;
            _self.[ACTION_SET_LOADING](true);
            await _self.$refs.observerInfo.validate().then((isValid) => {
              if (isValid) {
                if (_self.newsGroup) {
                  _self.[ACTION_UPDATE_NEWS_GROUP](_self.newsGroupAdd);
                } else {
                  _self.[ACTION_INSERT_NEWS_GROUP](_self.newsGroup);
                }
              } else {
                _self.[ACTION_SET_LOADING](false);
              }
            });
          }
        },
        setting: {
          btnCancelTxt: 'Close',
          add: {
            isParentShow: true,
            isAddFrom: true,
            title: 'Add News Group',
            btnSubmitTxt: 'Save'
          },
          edit: {
            isParentShow: false,
            isAddFrom: false,
            title: 'Edit News Group',
            btnSubmitTxt: 'Update'
          },
          close_modal: {
            isParentShow: false,
            isAddFrom: false,
            title: '',
            btnSubmitTxt: ''
          }
        }
    };
</script>