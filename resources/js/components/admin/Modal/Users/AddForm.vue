<template>
  <transition name="modal">
    <div :class="classShow" :style="styleCss" data-keyboard="false" data-backdrop="static">
      <div class="modal-dialog modal-lg">
        <ValidationObserver ref="observerUser" @submit.prevent="submitUser">
          <div class="modal-content">
            <LoadingOverLay :active.sync="loading" :is-full-page="fullPage" />
            <div class="modal-header">
              <h4 class="modal-title">{{title}}</h4>
              <button type="button" class="close" aria-label="Close" @click="closeModal">
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
              <button type="button" class="btn btn-default" @click="closeModal">Close</button>
              <button type="button" class="btn btn-success" @click="submitUser">{{btnSubmitTxt}}</button>
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
    import { mapGetters, mapMutations, mapActions } from 'vuex';
    import {
      MODULE_USER,
      MODULE_USER_MODAL
    } from 'store@admin/types/module-types';

    export default {
        name: 'UserAddForm',
        data() {
            return {
              name: '',
              email: '',
              password: '',
              fullPage: false,
              title: '',
              btnSubmitTxt: ''
            };
        },
        computed: {
          ...mapGetters(MODULE_USER_MODAL, [
            'classShow',
            'styleCss',
            'user',
            'loading',
            'updateSuccess'
          ]),
        },
        created() {
          this.title = this.$options.setting.AddTitle;
          this.btnSubmitTxt = this.$options.setting.BtnSaveText;
          if (this.user) {
            this.title = this.$options.setting.EditTitle;
            this.btnSubmitTxt = this.$options.setting.BtnUpdateText;

            this.name = this.user.name;
            this.email = this.user.email;
          }
        },
        beforeDestroy() {
          if (this.updateSuccess) {
            this.reloadGetUserList(this.updateSuccess);
          }
        },
        methods: {
          ...mapActions(MODULE_USER_MODAL, [
            'closeModal',
            'setLoading',
            'insertUser',
            'updateUser',
          ]),
          ...mapActions(MODULE_USER, ['getUserList', 'reloadGetUserList']),
          async submitUser() {
            const _self = this;
            _self.setLoading(true);
            _self.$refs.observerUser.validate().then((isValid) => {
              if (isValid) {
                if (_self.user) {
                  _self.updateUser({
                    name: _self.name,
                    email: _self.email,
                    password: _self.password
                  });
                } else {
                  _self.insertUser({
                    name: _self.name,
                    email: _self.email,
                    password: _self.password
                  });
                }
              } else {
                _self.setLoading(false);

                return false;
              }
            });
          }
        },
        setting: {
          EditTitle: 'Edit User',
          AddTitle: 'Add User',
          BtnSaveText: 'Save',
          BtnUpdateText: 'Update'
        }
    };
</script>