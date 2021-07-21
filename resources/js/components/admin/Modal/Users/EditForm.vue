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

                    <template v-if="user">
                        <validation-observer ref="observerUserPermission" @submit.prevent="_submitUserPermission" v-if="_isRules">
                            <div class="modal-body">
                                <form class="form-horizontal">
                                    <div class="form-group" v-for="(item,idx) in user.ruleSelect" :key="idx">
                                        <label
                                            for="input-user-password-"
                                            class="col-sm-3 control-label">{{$options.setting.permisstionGroupTexts[idx]}}</label>
                                        <div class="col-sm-9">
                                                <input 
                                                    v-on:change="ruleChange(idx,item)"
                                                    v-model="item.all"
                                                    type="checkbox"
                                                    class="form-control">
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2" v-for="(rule, id) in item.abilities" :key="id">
                                                <label
                                                for="input-user-password-"
                                                class="control-label">{{$options.setting.permissionActionTexts[id]}}</label>
                                                    <input 
                                                        v-model="item.abilities[id]"
                                                        type="checkbox"
                                                        class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default"
                                        @click="_close">{{$options.setting.btnCancelTxt}}
                                </button>
                                <button type="button" class="btn btn-success"
                                        @click="_submitUserPermission">{{$options.setting.btnSubmitRuleTxt}}
                                </button>
                            </div>
                        </validation-observer>
                    </template>
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
            },

            _isRules() {
                if (this.user.hasOwnProperty('ruleSelect')) {
                    return Object.keys(this.user.ruleSelect).length;
                }
                
                return 0;
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
            },

            _submitUserPermission() {
                const _self = this;
                _self.[ACTION_UPDATE_USER]({
                    action: 'permission',
                    abilities: _self.user.ruleSelect,
                    userId: _self.user.id,
                    id: _self.user.id
                });
                _self._resetModal();
            },

            ruleChange(idx, rule){
                const _self = this;
                let abilities = rule.abilities;
                abilities.list = rule.all;
                abilities.add = rule.all;
                abilities.edit = rule.all;
                abilities.delete = rule.all;

                _self.user.ruleSelect[idx].abilities = abilities;
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
            btnSubmitTxt: 'Cập nhật',
            btnSubmitRuleTxt: 'Cập nhật quyền truy cập',
            permisstionGroupTexts: {
                setting: 'Hệ thống/Cài đặt',
                thanh: 'Linh mục/Thánh',
                news_group: 'Tin tức/Danh mục',
                linh_muc_van_thu: 'Linh mục/Văn thư',
                linh_muc_thuyen_chuyen: 'Linh mục/Thuyên chuyển',
                linh_muc_bang_cap: 'Linh mục/Bằng cấp',
                linh_muc_chuc_thanh: 'Linh mục/Chức thánh',
                linh_muc: 'Linh mục/Linh mục',
                le_chinh: 'Giáo phận/Lễ chính',
                chuc_vu: 'Linh mục/Chức vụ',
                giao_phan: 'Giáo phận/Giáo phận',
                giao_hat: 'Giáo phận/Giáo hạt',
                giao_xu: 'Giáo phận/Giáo xứ',
                giao_diem: 'Giáo phận/Giáo điểm',
                giao_phan_co_so: 'Giáo phận/Cơ sở',
                cong_doan_tu_si: 'Giáo phận/Công đoàn tu sĩ',
                dong: 'Giáo phận/ Dòng',
                tin_tuc: 'Tin tức/Tin tức'
            },
            permissionActionTexts: {
                list: 'Xem danh sách',
                add: 'Thêm',
                edit: 'Cập nhật',
                delete: 'Xóa'
            }
        }
    };
</script>
