<template>
    <div class="div-content bg-white shadow py-3" :style="'min-height: ' + height">
        <validation-observer ref="observer" v-slot="{ handleSubmit }" slim>
            <b-form autocomplete="off" @submit.stop.prevent="handleSubmit(onSubmit)" class="m-3 custom-form">
                <div class="ml-lg-5 p-0 mb-4 text-red">
                    パスワードの変更を行います。<br>
                    パスワードを入力し、変更ボタンを押してください。
                </div>
                <div class="div-info col-lg-10 ml-lg-5 p-0">
                    <div class="row info-item m-0">
                        <label for="txt-old-password" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">
                            古いパスワード <span class="badge badge-danger">必須</span>
                        </label>
                        <div class="row col-sm-8 col-lg-9 my-2 mx-0">
                            <validation-provider mode="lazy"
                                                 name="古いパスワード"
                                                 rules="required|alpha_num|min:8|max:32"
                                                 v-slot="validationContext"
                                                 slim>
                                <b-input-group>
                                    <b-form-input type="password"
                                                  id="txt-old-password"
                                                  placeholder="古いパスワード"
                                                  v-model="form.old_password"
                                                  maxlength="255"
                                                  :class="{ 'is-invalid': errorMessages && errorMessages.old_password && validationContext.valid }"
                                                  :state="getValidationState(validationContext)"
                                                  @change="onPasswordChange"></b-form-input>
                                    <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                    <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.old_password" :key="index">{{ error }}</b-form-invalid-feedback>
                                </b-input-group>
                            </validation-provider>
                        </div>
                    </div>

                    <div class="row info-item m-0">
                        <label for="txt-new-password" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">
                            新しいバスワード <span class="badge badge-danger">必須</span>
                        </label>
                        <div class="row col-sm-8 col-lg-9 my-2 mx-0">
                            <validation-provider mode="lazy"
                                                 name="新しいバスワード"
                                                 rules="required|alpha_num|min:8|max:32"
                                                 v-slot="validationContext"
                                                 slim>
                                <b-input-group>
                                    <b-form-input type="password"
                                                  id="txt-new-password"
                                                  placeholder="新しいバスワード"
                                                  v-model="form.new_password"
                                                  maxlength="255"
                                                  :class="{ 'is-invalid': errorMessages && errorMessages.new_password && validationContext.valid }"
                                                  :state="getValidationState(validationContext)"
                                                  @change="onPasswordChange"></b-form-input>
                                    <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                    <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.new_password" :key="index">{{ error }}</b-form-invalid-feedback>
                                </b-input-group>
                            </validation-provider>
                        </div>
                    </div>

                    <div class="row info-item m-0">
                        <label for="txt-new-password-confirmation" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">
                            新しいバスワード（確認） <span class="badge badge-danger">必須</span>
                        </label>
                        <div class="row col-sm-8 col-lg-9 my-2 mx-0">
                            <validation-provider mode="lazy"
                                                 name="新しいバスワード（確認）"
                                                 rules="required|alpha_num|min:8|max:32"
                                                 v-slot="validationContext"
                                                 slim>
                                <b-input-group>
                                    <b-form-input type="password"
                                                  id="txt-new-password-confirmation"
                                                  placeholder="新しいバスワード（確認）"
                                                  maxlength="255"
                                                  v-model="form.new_password_confirmation"
                                                  :class="{ 'is-invalid': errorMessages && errorMessages.new_password_confirmation && validationContext.valid }"
                                                  :state="getValidationState(validationContext)"
                                                  @change="onPasswordChange"></b-form-input>
                                    <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                    <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.new_password_confirmation" :key="index">{{ error }}</b-form-invalid-feedback>
                                </b-input-group>
                            </validation-provider>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center mt-5 mb-1">
                    <b-link :to="{ name: 'store.menu.main.menu' }"
                            role="button"
                            class="btn col-sm-3 white-btn-custom btn-lg mw-9 m-3 font-weight-bold">キャンセル
                    </b-link>
                    <b-button type="submit"
                              class="col-sm-3 blue-btn-custom btn-lg mw-9 m-3 font-weight-bold"
                              :disabled="isLoading">
                        <b-spinner v-if="isLoading" type="border" class="mr-2" small></b-spinner> 変更
                    </b-button>
                </div>
            </b-form>
        </validation-observer>

        <ModalAlert :title="modalAlert.title" :message="modalAlert.message" :btn-ok="modalAlert.button" v-on:ok="ok" v-on:close="ok" />
    </div>
</template>

<script>
    import { mapActions } from 'vuex';
    import ModalAlert from '../../modals/ModalAlert';

    export default {
        name: 'ChangePassword',
        components: {
            ModalAlert
        },
        data() {
            return {
                form: {
                    old_password: null,
                    new_password: null,
                    new_password_confirmation: null
                },
                modalAlert: {
                    title: '',
                    message: '',
                    button: ''
                },
                height: '0'
            };
        },
        mounted() {
            this.height = this.calculateHeight();
        },
        methods: {
            ...mapActions('store.auth', [ 'changePassword' ]),
            getValidationState({ dirty, validated, valid = null }) {
                return dirty || validated ? valid : null;
            },
            onPasswordChange() {
                if (this.errorMessages) {
                    if (this.errorMessages.old_password) {
                        this.errorMessages.old_password = null;
                    }

                    if (this.errorMessages.new_password) {
                        this.errorMessages.new_password = null;
                    }

                    if (this.errorMessages.new_password_confirmation) {
                        this.errorMessages.new_password_confirmation = null;
                    }
                }
            },
            ok() {
                this.$router.push({ name: 'public.auth.login' });
            },
            async onSubmit() {
                const status = await this.changePassword(this.form);

                if (status === 200) {
                    this.modalAlert = {
                        title: 'パスワード変更完了',
                        message: 'パスワードの変更が完了しました。',
                        button: 'ログイン画面へ戻る'
                    };

                    this.$bvModal.show('modal-alert');
                }
            }
        }
    };
</script>

<style scoped>

</style>