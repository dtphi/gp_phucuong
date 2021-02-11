<template>
  <transition name="modal-user-add">
    <div :class="classShow" :style="styleCss" data-keyboard="false">
      <div class="modal-dialog modal-lg">
        <ValidationObserver ref="observerUser" @submit.prevent="_submitUser">
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
            <div class="modal-body">
              <!-- form start -->
              <div class="form-horizontal">
                <div class="card-body" v-if="_isShowBody">
                  <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                      <ValidationProvider name="Name" rules="required|max:191" v-slot="{ errors }">
                        <input v-model="userData.name" type="text" class="form-control" placeholder="Name">
                        <span class="text-red">{{ errors[0] }}</span>
                      </ValidationProvider>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                      <ValidationProvider name="Email" rules="required|email|max:191" v-slot="{ errors }">
                        <input v-model="userData.email" type="email" class="form-control" placeholder="Email">
                        <span class="text-red">{{ errors[0] }}</span>
                      </ValidationProvider>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                      <ValidationProvider name="Password" rules="required|minLength:8|max:191" v-slot="{ errors }">
                        <input v-model="userData.password" type="password" class="form-control" placeholder="Password">
                        <span class="text-red">{{ errors[0] }}</span>
                      </ValidationProvider>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" @click="_close">Close</button>
              <button type="button" class="btn btn-success" @click="_submitUser">{{_getSetForm.btnSubmitTxt}}</button>
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
    import { mapGetters, mapState, mapActions } from 'vuex';
    import { email } from 'vee-validate/dist/rules';
    import {
      MODULE_USER,
      MODULE_USER_MODAL
    } from 'store@admin/types/module-types';
    import {
      ACTION_CLOSE_MODAL,
      ACTION_SET_LOADING
    } from 'store@admin/types/action-types';

    export default {
        name: 'UserAddForm',
        data() {
            return {
              fullPage: false,
              userData: {}
            };
        },
        computed: {
          ...mapState(MODULE_USER_MODAL, {
            formAction: state => state.action,
            loading: state => state.loading
          }),
          ...mapGetters(MODULE_USER_MODAL, [
            'classShow',
            'styleCss',
            'user',
          ]),

          _getSetForm() {
            let setting = this.$options.setting.add;

            if (this.formAction) {
              setting = this.$options.setting[this.formAction];

              if (this.formAction === 'close_modal') {
                this.userData = {}
              } else {
                this.userData = {...this.user}
              }
            }

            return setting;
          }
        },
        updated() {
          if (this.formAction == 'close_modal') {
            requestAnimationFrame(() => {
              this.$refs.observerUser.reset();
              this.$data.userData = {};
            });
          }
        },
        methods: {
          ...mapActions(MODULE_USER_MODAL, [
            ACTION_CLOSE_MODAL,
            ACTION_SET_LOADING,
            'insertUser',
            'updateUser',
          ]),

          _isShowBody() {
            console.log('setting', this.formAction)
            return (this.formAction === 'add' || this.formAction === 'edit')
          },

          _close() {
            this.[ACTION_CLOSE_MODAL]()
          },

          async _submitUser() {
            const _self = this;
            _self.setLoading(true);
            _self.$refs.observerUser.validate().then((isValid) => {
              if (isValid) {
                if (_self.user) {
                  _self.updateUser(_self.userData)
                } else {
                  _self.insertUser(_self.userData)
                }
              } else {
                _self.setLoading(false)
              }
            });
          }
        },
        setting: {
          btnCancelTxt: 'Close',
          add: {
            actionName: 'add',
            isAddFrom: true,
            title: 'Add User',
            btnSubmitTxt: 'Save'
          },
          edit: {
            actionName: 'edit',
            isAddFrom: false,
            title: 'Edit User',
            btnSubmitTxt: 'Update'
          },
          close_modal: {
            actionName: 'close_modal',
            isAddFrom: false,
            title: '',
            btnSubmitTxt: ''
          }
        }
    };
</script>