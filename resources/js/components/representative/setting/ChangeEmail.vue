<template>
    <div class="div-content bg-white shadow py-3" :style="'min-height: ' + height">
        <validation-observer ref="observer" v-slot="{ handleSubmit }" slim>
            <b-form autocomplete="off" @submit.stop.prevent="handleSubmit(onSubmit)" class="m-3 custom-form">
                <div class="ml-lg-5 p-0 mb-4 text-red">
                    メールアドレスの変更を行います。<br>
                    メールアドレスを入力し、変更ボタンを押してください。
                </div>
                <div class="div-info col-lg-10 ml-lg-5 p-0">
                    <div class="row info-item m-0">
                        <label for="txt-main-email" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">
                            メインメールアドレス <span class="badge badge-danger">必須</span>
                        </label>
                        <div class="row col-sm-8 col-lg-9 my-2 mx-0">
                            <validation-provider mode="lazy"
                                                 name="メインメールアドレス"
                                                 rules="required|email|max:255"
                                                 v-slot="validationContext"
                                                 slim>
                                <b-input-group>
                                    <b-form-input type="text"
                                                  id="txt-main-email"
                                                  placeholder="メインメールアドレス"
                                                  v-model="form.main_email"
                                                  maxlength="255"
                                                  :class="{ 'is-invalid': errorMessages && errorMessages.main_email && validationContext.valid }"
                                                  :state="getValidationState(validationContext)"
                                                  @change="onEmailChange"></b-form-input>
                                    <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                    <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.main_email" :key="index">{{ error }}</b-form-invalid-feedback>
                                </b-input-group>
                            </validation-provider>
                        </div>
                    </div>

                    <div class="row info-item m-0 border-0">
                        <label for="txt-sub-email-1" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">サブメールアドレス</label>
                        <div class="row col-sm-8 col-lg-9 my-2 mx-0">
                            <validation-provider mode="lazy"
                                                 name="サブメールアドレス1"
                                                 rules="email|max:255"
                                                 v-slot="validationContext"
                                                 slim>
                                <b-input-group>
                                    <b-form-input type="text"
                                                  id="txt-sub-email-1"
                                                  placeholder="サブメールアドレス1"
                                                  v-model="form.sub_email1"
                                                  maxlength="255"
                                                  :class="{ 'is-invalid': errorMessages && errorMessages.sub_email1 && validationContext.valid }"
                                                  :state="getValidationState(validationContext)"
                                                  @change="onEmailChange"></b-form-input>
                                    <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                    <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.sub_email1" :key="index">{{ error }}</b-form-invalid-feedback>
                                </b-input-group>
                            </validation-provider>
                        </div>
                    </div>

                    <div class="row info-item m-0 border-0">
                        <label for="txt-sub-email-3" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold d-none d-sm-block"></label>
                        <div class="row col-sm-8 col-lg-9 my-2 mx-0">
                            <validation-provider mode="lazy"
                                                 name="サブメールアドレス2"
                                                 rules="email|max:255"
                                                 v-slot="validationContext"
                                                 slim>
                                <b-input-group>
                                    <b-form-input type="text"
                                                  id="txt-sub-email-2"
                                                  placeholder="サブメールアドレス2"
                                                  v-model="form.sub_email2"
                                                  maxlength="255"
                                                  :class="{ 'is-invalid': errorMessages && errorMessages.sub_email2 && validationContext.valid }"
                                                  :state="getValidationState(validationContext)"
                                                  @change="onEmailChange"></b-form-input>
                                    <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                    <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.sub_email2" :key="index">{{ error }}</b-form-invalid-feedback>
                                </b-input-group>
                            </validation-provider>
                        </div>
                    </div>

                    <div class="row info-item m-0 border-0">
                        <label for="txt-sub-email-3" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold d-none d-sm-block"></label>
                        <div class="row col-sm-8 col-lg-9 my-2 mx-0">
                            <validation-provider mode="lazy"
                                                 name="サブメールアドレス3"
                                                 rules="email|max:255"
                                                 v-slot="validationContext"
                                                 slim>
                                <b-input-group>
                                    <b-form-input type="text"
                                                  id="txt-sub-email-3"
                                                  placeholder="サブメールアドレス3"
                                                  v-model="form.sub_email3"
                                                  maxlength="255"
                                                  :class="{ 'is-invalid': errorMessages && errorMessages.sub_email3 && validationContext.valid }"
                                                  :state="getValidationState(validationContext)"
                                                  @change="onEmailChange"></b-form-input>
                                    <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                    <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.sub_email3" :key="index">{{ error }}</b-form-invalid-feedback>
                                </b-input-group>
                            </validation-provider>
                        </div>
                    </div>

                    <div class="row info-item m-0">
                        <label for="txt-sub-email-3" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold d-none d-sm-block"></label>
                        <div class="row col-sm-8 col-lg-9 my-2 mx-0">
                            <validation-provider mode="lazy"
                                                 name="サブメールアドレス4"
                                                 rules="email|max:255"
                                                 v-slot="validationContext"
                                                 slim>
                                <b-input-group>
                                    <b-form-input type="text"
                                                  id="txt-sub-email-4"
                                                  placeholder="サブメールアドレス4"
                                                  v-model="form.sub_email4"
                                                  maxlength="255"
                                                  :class="{ 'is-invalid': errorMessages && errorMessages.sub_email4 && validationContext.valid }"
                                                  :state="getValidationState(validationContext)"
                                                  @change="onEmailChange"></b-form-input>
                                    <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                    <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.sub_email4" :key="index">{{ error }}</b-form-invalid-feedback>
                                </b-input-group>
                            </validation-provider>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center mt-5 mb-1">
                    <b-link :to="{ name: 'representative.menu.main.menu' }"
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
    import { mapActions, mapGetters } from 'vuex';
    import ModalAlert from '../../modals/ModalAlert';

    export default {
        name: 'Login',
        components: {
            ModalAlert
        },
        data() {
            return {
                form: {
                    main_email: null,
                    sub_email1: null,
                    sub_email2: null,
                    sub_email3: null,
                    sub_email4: null
                },
                modalAlert: {
                    title: '',
                    message: '',
                    button: ''
                },
                height: '0'
            };
        },
        computed: {
            ...mapGetters('representative.auth', [ 'representative' ])
        },
        mounted() {
            if (this.representative) {
                this.form = {
                    main_email: this.representative.main_email,
                    sub_email1: this.representative.sub_email1,
                    sub_email2: this.representative.sub_email2,
                    sub_email3: this.representative.sub_email3,
                    sub_email4: this.representative.sub_email4
                };
            }
            this.height = this.calculateHeight();
        },
        methods: {
            ...mapActions('representative.auth', [ 'changeEmail', 'logout' ]),
            getValidationState({ dirty, validated, valid = null }) {
                return dirty || validated ? valid : null;
            },
            onEmailChange() {
                if (this.errorMessages) {
                    if (this.errorMessages.main_email) {
                        this.errorMessages.main_email = null;
                    }

                    if (this.errorMessages.sub_email1) {
                        this.errorMessages.sub_email1 = null;
                    }

                    if (this.errorMessages.sub_email2) {
                        this.errorMessages.sub_email2 = null;
                    }

                    if (this.errorMessages.sub_email3) {
                        this.errorMessages.sub_email3 = null;
                    }

                    if (this.errorMessages.sub_email4) {
                        this.errorMessages.sub_email4 = null;
                    }
                }
            },
            ok() {
                if (!this.representative) {
                    this.$router.push({ name: 'public.auth.login' });
                } else {
                    this.$router.push({ name: 'representative.menu.main.menu' });
                }
            },
            async onSubmit() {
                const status = await this.changeEmail(this.form);

                if (status === 200) {
                    if (this.form.main_email !== this.representative.main_email) {
                        this.logout();
                        this.modalAlert = {
                            title: 'メールアドレス変更完了',
                            message: 'メールアドレスの変更が完了しました。',
                            button: 'ログイン画面へ戻る'
                        };
                    } else {
                        this.modalAlert = {
                            title: 'メールアドレス変更完了',
                            message: 'メールアドレスの変更が完了しました。',
                            button: 'メインメニューへ戻る'
                        };
                    }

                    this.$bvModal.show('modal-alert');
                }
            }
        }
    };
</script>

<style scoped>

</style>