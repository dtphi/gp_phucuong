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
                                  <p v-for="err in _errorToArrs()">{{err}}</p>
                                </div>
                            </template>
                            
                            <template v-if="loading">
                                <div style="height: 100px">
                                    <loading-over-lay 
                                    :active.sync="loading" 
                                    :is-full-page="fullPage"></loading-over-lay>
                                </div>
                            </template>

                            <template v-if="user">
                                <form class="form-horizontal">
                                    <div class="form-group required">
                                        <label for="input-user-name"
                                               class="col-sm-2 control-label">{{$options.setting.nameTxt}}</label>
                                        <div class="col-sm-10">
                                            <validation-provider
                                                name="user_name"
                                                rules="required|max:191"
                                                v-slot="{ errors }">
                                                <input
                                                    id="input-user-name"
                                                    v-model="user.name"
                                                    type="text"
                                                    class="form-control"
                                                    :placeholder="$options.setting.nameTxt">
                                                <span class="cms-text-red">{{ errors[0] }}</span>
                                            </validation-provider>
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label
                                            for="input-user-email"
                                            class="col-sm-2 control-label">{{$options.setting.emailTxt}}</label>
                                        <div class="col-sm-10">
                                            <validation-provider
                                                :immediate="false"
                                                name="user_email"
                                                rules="required|email|max:191"
                                                v-slot="{ errors }">
                                                <input
                                                    id="input-user-email"
                                                    v-model="user.email"
                                                    type="email"
                                                    class="form-control"
                                                    :placeholder="$options.setting.emailTxt">
                                                <span class="cms-text-red">{{ errors[0] }}</span>
                                            </validation-provider>
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label
                                            for="input-user-password"
                                            class="col-sm-2 control-label">{{$options.setting.passwordTxt}}</label>
                                        <div class="col-sm-10">
                                            <validation-provider
                                                :immediate="false"
                                                name="user_password"
                                                rules="required|minLength:8|max:191"
                                                v-slot="{ errors }">
                                                <input 
                                                    autocomplete="off"
                                                    id="input-user-password"
                                                    v-model="user.password"
                                                    type="password"
                                                    name="user_password" 
                                                    class="form-control"
                                                    :placeholder="$options.setting.passwordTxt">
                                                <span class="cms-text-red">{{ errors[0] }}</span>
                                            </validation-provider>
                                        </div>
                                    </div>
                                </form>
                            </template>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default"
                                    @click="_close">{{$options.setting.btnCancelTxt}}
                            </button>
                            <button type="button" class="btn btn-success"
                                    @click="_submitUser">{{$options.setting.btnSubmitTxt}}
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
        mapActions
    } from 'vuex';
    import {email} from 'vee-validate/dist/rules';
    import {
        MODULE_USER,
        MODULE_USER_EDIT_MODAL
    } from 'store@admin/types/module-types';
    import {
        ACTION_CLOSE_MODAL,
        ACTION_SET_LOADING,
        ACTION_UPDATE_USER
    } from 'store@admin/types/action-types';

    export default {
        name: 'UserEditForm',
        data() {
            return {
                fullPage: false,
            };
        },
        computed: {
            ...mapState(MODULE_USER_EDIT_MODAL, {
                errors: state => state.errors,
                loading: state => state.loading
            }),
            ...mapGetters(MODULE_USER_EDIT_MODAL, [
                'classShow',
                'styleCss',
                'user',
            ]),

            _errors() {
                return this.errors.length;
            }
        },
        mounted() {
            this._close()
        },
        methods: {
            ...mapActions(MODULE_USER_EDIT_MODAL, [
                ACTION_CLOSE_MODAL,
                ACTION_SET_LOADING,
                ACTION_UPDATE_USER
            ]),

            async _resetModal() {
                requestAnimationFrame(() => {
                    this.$refs.observerUser.reset()
                });
            },

            _close() {
                this.[ACTION_CLOSE_MODAL]()
            },

            _errorToArrs() {
                let errs = [];
                if (this.errors.length) {
                    errs = Object.values(this.errors[0].messages);
                }

                return errs;
            },

            async _submitUser() {
                const _self = this;
                await _self.$refs.observerUser.validate().then((isValid) => {
                    if (isValid) {
                      _self.[ACTION_UPDATE_USER](_self.user);
                      _self._resetModal();
                    }
                })
            }
        },
        setting: {
            btnCancelTxt: 'Thoát',
            passwordTxt: 'Password',
            emailTxt: 'Email',
            nameTxt: 'Họ tên',
            actionName: 'edit',
            isAddFrom: false,
            modal_title: 'Cập nhật người dùng',
            btnSubmitTxt: 'Cập nhật'
        }
    };
</script>
