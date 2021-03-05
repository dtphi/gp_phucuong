<template>
    <transition name="modal-user-add">
        <div :class="classShow" :style="styleCss" data-keyboard="false">
            <div class="modal-dialog modal-lg">
                <validation-observer ref="observerUser" @submit.prevent="_submitUser">
                    <div class="modal-content">
                        <loading-over-lay 
                            :active.sync="loading" 
                            :is-full-page="fullPage"></loading-over-lay>
                        <div class="modal-header">
                            <h4 class="modal-title">{{_getSetForm.title}}</h4>
                            <button type="button" class="close" @click="_close">
                                <span aria-hidden="true">
                                  <font-awesome-icon icon="times"/>
                                </span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- form start -->
                            <div class="form-horizontal">
                                <div class="card-body" v-if="_isShowBody">
                                    <div class="form-group row">
                                        <label for="user_name"
                                               class="col-sm-2 col-form-label">{{$options.setting.nameTxt}}</label>
                                        <div class="col-sm-10">
                                            <validation-provider
                                                name="user_name"
                                                rules="required|max:191"
                                                v-slot="{ errors }">
                                                <input
                                                    v-model="userData.name"
                                                    type="text"
                                                    class="form-control"
                                                    :placeholder="$options.setting.nameTxt">
                                                <span class="text-red">{{ errors[0] }}</span>
                                            </validation-provider>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label
                                            for="user_email"
                                            class="col-sm-2 col-form-label">{{$options.setting.emailTxt}}</label>
                                        <div class="col-sm-10">
                                            <validation-provider
                                                :immediate="false"
                                                name="user_email"
                                                rules="required|email|max:191"
                                                v-slot="{ errors }">
                                                <input
                                                    v-model="userData.email"
                                                    type="email"
                                                    class="form-control"
                                                    :placeholder="$options.setting.emailTxt">
                                                <span class="text-red">{{ errors[0] }}</span>
                                            </validation-provider>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label
                                            for="user_password"
                                            class="col-sm-2 col-form-label">{{$options.setting.passwordTxt}}</label>
                                        <div class="col-sm-10">
                                            <validation-provider
                                                :immediate="false"
                                                name="user_password"
                                                rules="required|minLength:8|max:191"
                                                v-slot="{ errors }">
                                                <input
                                                    v-model="userData.password"
                                                    type="password"
                                                    class="form-control"
                                                    :placeholder="$options.setting.passwordTxt">
                                                <span class="text-red">{{ errors[0] }}</span>
                                            </validation-provider>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default"
                                    @click="_close">{{$options.setting.btnCancelTxt}}
                            </button>
                            <button type="button" class="btn btn-success"
                                    @click="_submitUser">{{_getSetForm.btnSubmitTxt}}
                            </button>
                        </div>
                    </div>
                </validation-observer>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </transition>
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
        MODULE_USER_MODAL
    } from 'store@admin/types/module-types';
    import {
        ACTION_CLOSE_MODAL,
        ACTION_SET_LOADING,
        ACTION_INSERT_USER,
        ACTION_UPDATE_USER
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

                    if (this._isModalClose()) {
                        this._resetModal()
                    } else {
                        this.userData = {...this.user}
                    }
                }

                return setting;
            }
        },
        mounted() {
            this._close()
        },
        methods: {
            ...mapActions(MODULE_USER_MODAL, [
                ACTION_CLOSE_MODAL,
                ACTION_SET_LOADING,
                ACTION_INSERT_USER,
                ACTION_UPDATE_USER
            ]),

            async _resetModal() {
                this.$data.userData = {};
                requestAnimationFrame(() => {
                    this.$refs.observerUser.reset()
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

            async _submitUser() {
                const _self = this;
                _self.setLoading(true);
                await _self.$refs.observerUser.validate().then((isValid) => {
                    if (isValid) {
                        if (_self._isEditAction()) {
                            _self.[ACTION_UPDATE_USER](_self.userData)
                        } else {
                            _self.[ACTION_INSERT_USER](_self.userData)
                        }
                    } else {
                        _self.setLoading(false)
                    }
                })
            }
        },
        setting: {
            btnCancelTxt: 'Close',
            passwordTxt: 'Password',
            emailTxt: 'Email',
            nameTxt: 'Name',
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
            closeModal: {
                actionName: 'closeModal',
                isAddFrom: false,
                title: '',
                btnSubmitTxt: ''
            }
        }
    };
</script>
