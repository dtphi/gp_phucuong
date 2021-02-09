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
                <span aria-hidden="true"><font-awesome-icon icon="times" /></span>
              </button>
            </div>
            <div class="modal-body">
              <!-- form start -->
              <div class="form-horizontal">
                <div class="card-body">
                  <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                      <ValidationProvider name="Name" rules="required|max:191" v-slot="{ errors }">
                        <input v-model="name" type="text" class="form-control" placeholder="Name">
                        <span class="text-red">{{ errors[0] }}</span>
                      </ValidationProvider>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                      <ValidationProvider name="Email" rules="required|max:191" v-slot="{ errors }">
                        <input v-model="email" type="email" class="form-control" placeholder="Email">
                      <span class="text-red">{{ errors[0] }}</span>
                      </ValidationProvider>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                      <ValidationProvider name="Password" rules="required|minLength:8|max:191" v-slot="{ errors }">
                        <input v-model="password" type="password" class="form-control" placeholder="Password">
                      <span class="text-red">{{ errors[0] }}</span>
                      </ValidationProvider>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" @click="_close">{{$options.setting.btnCancelTxt}}</button>
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
              name: '',
              email: '',
              password: '',
              fullPage: false
            };
        },
        computed: {
          ...mapState(MODULE_INFO_MODAL, {
            formAction: state => state.action
          }),
          ...mapGetters(MODULE_INFO_MODAL, [
            'classShow',
            'styleCss',
            'info',
            'loading'
          ]),

          getSetForm() {console.log('getSetForm')
            return this.formAction?this.$options.setting[this.formAction]:this.$options.setting.add
          }
        },

        methods: {
          ...mapActions(MODULE_INFO_MODAL, [
            ACTION_CLOSE_MODAL,
            ACTION_SET_LOADING,
            ACTION_INSERT_INFO,
            ACTION_UPDATE_INFO
          ]),

          _close() {
            this.[ACTION_CLOSE_MODAL]()
          },

          async _submitInfo() {
            const _self = this;
            _self.[ACTION_SET_LOADING](true);
            _self.$refs.observerInfo.validate().then((isValid) => {
              if (isValid) {
                if (_self.info) {
                  _self.[ACTION_UPDATE_INFO]({
                    name: _self.name,
                    email: _self.email,
                    password: _self.password
                  });
                } else {
                  _self.[ACTION_INSERT_INFO]({
                    name: _self.name,
                    email: _self.email,
                    password: _self.password
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
          btnCancelTxt: 'Close',
          add: {
            title: 'Add News',
            btnSubmitTxt: 'Save'
          },
          edit: {
            title: 'Edit News',
            btnSubmitTxt: 'Update'
          }
        }
    };
</script>