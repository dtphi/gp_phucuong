<template>
  <transition name="modal">
    <div :class="classShow" :style="styleCss" data-keyboard="false" data-backdrop="static">
      <div class="modal-dialog modal-lg">
        <ValidationObserver ref="observerInfo" @submit.prevent="_submitInfo">
          <div class="modal-content">
            <LoadingOverLay :active.sync="loading" :is-full-page="fullPage" />
            <div class="modal-header">
              <h4 class="modal-title">{{title}}</h4>
              <button type="button" class="close" aria-label="Close" @click="_close">
                <span aria-hidden="true">
                  <font-awesome-icon icon="times" />
                </span>
              </button>
            </div>
            <NewsGroupCurrent v-if="parentInfo" :parent-info="parentInfo"/>
            <div class="modal-body">
              <!-- form start -->
              <div class="form-horizontal">
                <div class="card-body">
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10" v-if="newsGroup">
                      <ValidationProvider name="News Group Name" rules="required|max:191" v-slot="{ errors }">
                        <input v-model="newsGroup.name" type="text" class="form-control" placeholder="News Group Name">
                        <span class="text-red">{{ errors[0] }}</span>
                      </ValidationProvider>
                    </div>
                    <div class="col-sm-10" v-if="parentInfo">
                      <ValidationProvider name="News Group Name" rules="required|max:191" v-slot="{ errors }">
                        <input v-model="parentInfo.name" type="text" class="form-control" placeholder="News Group Name">
                        <span class="text-red">{{ errors[0] }}</span>
                      </ValidationProvider>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" @click="_close">Close</button>
              <button type="button" class="btn btn-success" @click="_submitInfo">{{btnSubmitTxt}}</button>
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
    import { mapGetters, mapActions } from 'vuex';
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
        name: 'TheModalAddForm',
        components: {NewsGroupCurrent},
        data() {
            return {
              name: '',
              fullPage: false,
              title: '',
              btnSubmitTxt: ''
            };
        },
        computed: {
          ...mapGetters(MODULE_NEWS_GROUP_MODAL, [
            'classShow',
            'styleCss',
            'action',
            'newsGroup',
            'parentInfo',
            'loading',
            'updateSuccess'
          ])
        },
        created() {
          this.title = this.$options.setting.AddTitle;
          this.btnSubmitTxt = this.$options.setting.BtnSaveText;
        },
        beforeDestroy() {console.log('destroy')
          if (this.updateSuccess) {
            this.[ACTION_RELOAD_GET_NEWS_GROUP_LIST](this.updateSuccess);
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
            _self.$refs.observerInfo.validate().then((isValid) => {
              if (isValid) {
                if (_self.newsGroup) {
                  _self.[ACTION_UPDATE_NEWS_GROUP]({
                    name: _self.name
                  });
                } else {
                  _self.[ACTION_INSERT_NEWS_GROUP]({
                    name: _self.name
                  });
                }
              } else {
                _self.[ACTION_SET_LOADING](false);

                return false;
              }
            });
          }
        },
        setting: {
          EditTitle: 'Edit News Group',
          AddTitle: 'Add News Group',
          BtnSaveText: 'Save',
          BtnUpdateText: 'Update'
        }
    };
</script>