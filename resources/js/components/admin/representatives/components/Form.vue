<template>
    <validation-observer ref="observer" v-slot="{ handleSubmit }" slim>
        <b-form autocomplete="off" class="m-3 custom-form" @submit.stop.prevent="handleSubmit(onSubmit)">
            <div class="div-info col-lg-10 ml-lg-5 p-0">
                <div class="row info-item align-content-center m-0">
                    <label for="txt-employee-number" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">
                        担当者コード <span class="badge badge-danger">必須</span>
                    </label>
                    <div class="row col-sm-8 col-lg-9 my-2 mx-0">
                        <validation-provider mode="lazy"
                                             name="担当者コード"
                                             rules="required|digits:4|numeric"
                                             v-slot="validationContext"
                                             slim>
                            <b-input-group>
                                <b-form-input type="text"
                                              id="txt-employee-number"
                                              placeholder="担当者コード"
                                              v-model="form.employeeNumber"
                                              class="col-lg-5"
                                              maxlength="4"
                                              :class="{ 'is-invalid': errorMessages && errorMessages.employeeNumber && validationContext.valid }"
                                              :state="getValidationState(validationContext)"
                                              @blur="onBlur"></b-form-input>
                                <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                <b-form-invalid-feedback v-else-if="!isLoading"  v-for="(error, index) in errorMessages && errorMessages.employeeNumber" :key="index">{{ error }}</b-form-invalid-feedback>
                            </b-input-group>
                        </validation-provider>
                    </div>
                </div>

                <div class="row info-item m-0">
                    <label for="txt-last-name" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">
                        氏名 <span class="badge badge-danger">必須</span>
                    </label>
                    <div class="row col-sm-8 col-lg-9 my-2 mx-0">
                        <div class="col-6 pl-0">
                            <validation-provider mode="lazy"
                                                 name="姓"
                                                 rules="required|max:20"
                                                 v-slot="validationContext"
                                                 slim>
                                <b-input-group>
                                    <b-form-input type="text"
                                                  id="txt-last-name"
                                                  placeholder="姓"
                                                  v-model="form.lastName"
                                                  maxlength="255"
                                                  :class="{ 'is-invalid': errorMessages && errorMessages.lastName && validationContext.valid }"
                                                  :state="getValidationState(validationContext)"
                                                  @change="onLastNameChange"></b-form-input>
                                    <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                    <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.lastName" :key="index">{{ error }}</b-form-invalid-feedback>
                                </b-input-group>
                            </validation-provider>
                        </div>
                        <div class="col-6 pr-0">
                            <validation-provider mode="lazy"
                                                 name="名"
                                                 rules="required|max:20"
                                                 v-slot="validationContext"
                                                 slim>
                                <b-input-group>
                                    <b-form-input type="text"
                                                  placeholder="名"
                                                  v-model="form.firstName"
                                                  maxlength="255"
                                                  :class="{ 'is-invalid': errorMessages && errorMessages.firstName && validationContext.valid }"
                                                  :state="getValidationState(validationContext)"
                                                  @change="onFirstNameChange"></b-form-input>
                                    <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                    <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.firstName" :key="index">{{ error }}</b-form-invalid-feedback>
                                </b-input-group>
                            </validation-provider>
                        </div>
                    </div>
                </div>

                <div class="row info-item m-0">
                    <label for="txt-last-name-kana" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">
                        フリガナ <span class="badge badge-danger">必須</span>
                    </label>
                    <div class="row col-sm-8 col-lg-9 my-2 mx-0">
                        <div class="col-6 pl-0">
                            <validation-provider mode="lazy"
                                                 name="カナ姓"
                                                 rules="required|max:20|katakana"
                                                 v-slot="validationContext"
                                                 slim>
                                <b-input-group>
                                    <b-form-input type="text"
                                                  id="txt-last-name-kana"
                                                  placeholder="カナ姓"
                                                  v-model="form.lastNameKana"
                                                  maxlength="255"
                                                  :class="{ 'is-invalid': errorMessages && errorMessages.lastNameKana && validationContext.valid }"
                                                  :state="getValidationState(validationContext)"
                                                  @change="onLastNameKanaChange"></b-form-input>
                                    <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                    <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.lastNameKana" :key="index">{{ error }}</b-form-invalid-feedback>
                                </b-input-group>
                            </validation-provider>
                        </div>
                        <div class="col-6 pr-0">
                            <validation-provider mode="lazy"
                                                 name="カナ名"
                                                 rules="required|max:20|katakana"
                                                 v-slot="validationContext"
                                                 slim>
                                <b-input-group>
                                    <b-form-input type="text"
                                                  placeholder="カナ名"
                                                  v-model="form.firstNameKana"
                                                  maxlength="255"
                                                  :class="{ 'is-invalid': errorMessages && errorMessages.firstNameKana && validationContext.valid }"
                                                  :state="getValidationState(validationContext)"
                                                  @change="onFirstNameKanaChange"></b-form-input>
                                    <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                    <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.firstNameKana" :key="index">{{ error }}</b-form-invalid-feedback>
                                </b-input-group>
                            </validation-provider>
                        </div>
                    </div>
                </div>

                <div class="row info-item m-0">
                    <label for="txt-phone-number" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">
                        電話番号 <span class="badge badge-danger">必須</span>
                    </label>
                    <div class="row col-sm-8 col-lg-9 my-2 mx-0">
                        <div class="col-6 pl-0">
                            <validation-provider mode="lazy"
                                                 name="電話番号"
                                                 rules="required|max:14|phone"
                                                 v-slot="validationContext"
                                                 slim>
                                <b-input-group>
                                    <b-form-input type="text"
                                                  id="txt-phone-number"
                                                  placeholder="電話番号"
                                                  v-model="form.phoneNumber"
                                                  maxlength="255"
                                                  :class="{ 'is-invalid': errorMessages && errorMessages.phoneNumber && validationContext.valid }"
                                                  :state="getValidationState(validationContext)"
                                                  @change="onPhoneNumberChange"></b-form-input>
                                    <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                    <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.phoneNumber" :key="index">{{ error }}</b-form-invalid-feedback>
                                </b-input-group>
                            </validation-provider>
                        </div>
                    </div>
                </div>

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
                                              v-model="form.mainEmail"
                                              class="mb-1"
                                              maxlength="255"
                                              :class="{ 'is-invalid': errorMessages && errorMessages.mainEmail && validationContext.valid }"
                                              :state="getValidationState(validationContext)"
                                              @blur="onBlur"></b-form-input>
                                <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.mainEmail" :key="index">{{ error }}</b-form-invalid-feedback>
                                <b-form-text class="sub-frm-txt">メインメールアドレスはログインIDやパスワード再発行時の通知先として使用できます。</b-form-text>
                            </b-input-group>
                        </validation-provider>
                    </div>
                </div>

                <div class="row info-item m-0">
                    <label for="txt-sub-email-1" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">サブメールアドレス1</label>
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
                                              v-model="form.subEmail1"
                                              maxlength="255"
                                              :class="{ 'is-invalid': errorMessages && errorMessages.subEmail1 && validationContext.valid }"
                                              :state="getValidationState(validationContext)"
                                              @blur="onBlur"></b-form-input>
                                <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.subEmail1" :key="index">{{ error }}</b-form-invalid-feedback>
                            </b-input-group>
                        </validation-provider>
                    </div>
                </div>

                <div class="row info-item m-0">
                    <label for="txt-sub-email-2" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">サブメールアドレス2</label>
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
                                              v-model="form.subEmail2"
                                              maxlength="255"
                                              :class="{ 'is-invalid': errorMessages && errorMessages.subEmail2 && validationContext.valid }"
                                              :state="getValidationState(validationContext)"
                                              @blur="onBlur"></b-form-input>
                                <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.subEmail2" :key="index">{{ error }}</b-form-invalid-feedback>
                            </b-input-group>
                        </validation-provider>
                    </div>
                </div>

                <div class="row info-item m-0">
                    <label for="txt-sub-email-3" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">サブメールアドレス3</label>
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
                                              v-model="form.subEmail3"
                                              maxlength="255"
                                              :class="{ 'is-invalid': errorMessages && errorMessages.subEmail3 && validationContext.valid }"
                                              :state="getValidationState(validationContext)"
                                              @blur="onBlur"></b-form-input>
                                <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.subEmail3" :key="index">{{ error }}</b-form-invalid-feedback>
                            </b-input-group>
                        </validation-provider>
                    </div>
                </div>

                <div class="row info-item m-0">
                    <label for="txt-sub-email-4" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">サブメールアドレス4</label>
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
                                              v-model="form.subEmail4"
                                              maxlength="255"
                                              :class="{ 'is-invalid': errorMessages && errorMessages.subEmail4 && validationContext.valid }"
                                              :state="getValidationState(validationContext)"
                                              @blur="onBlur"></b-form-input>
                                <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.subEmail4" :key="index">{{ error }}</b-form-invalid-feedback>
                            </b-input-group>
                        </validation-provider>
                    </div>
                </div>

                <div v-if="!isCreate" class="row info-item m-0">
                    <label class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">最終ログイン日時</label>
                    <div class="row col-sm-8 col-lg-9 my-2 mx-0 py-3">{{ form.lastLoggedIn }}</div>
                </div>
            </div>

            <div class="row justify-content-center mt-5 mb-1">
                <b-link v-if="isCreate"
                        :to="{ name: 'admin.representatives.list' }"
                        role="button"
                        class="btn col-sm-3 white-btn-custom btn-lg mw-9 m-3 font-weight-bold">キャンセル
                </b-link>
                <b-button type="submit"
                          class="col-sm-3 blue-btn-custom btn-lg mw-9 m-3 font-weight-bold"
                          :disabled="isLoading">
                    <b-spinner v-if="isLoading" type="border" class="mr-2" small></b-spinner> {{ btnSave }}
                </b-button>
            </div>
        </b-form>
    </validation-observer>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';

    export default {
        name: 'Form',
        props: {
            isCreate: {
                default: true,
                type: Boolean
            },
            btnSave: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                form: {
                    id: '',
                    employeeNumber: '',
                    lastName: '',
                    firstName: '',
                    lastNameKana: '',
                    firstNameKana: '',
                    phoneNumber: '',
                    mainEmail: '',
                    subEmail1: '',
                    subEmail2: '',
                    subEmail3: '',
                    subEmail4: '',
                    lastLoggedIn: null,
                    lastLoggedInAt: null
                }
            };
        },
        computed: {
            ...mapGetters('admin.auth', [ 'admin' ]),
            ...mapGetters('admin.representatives', [ 'representative' ])
        },
        mounted() {
            if (!this.isCreate) {
                this.onLoadData();
            }
        },
        methods: {
            ...mapActions('admin.representatives', [ 'checkValidated', 'show' ]),
            async onLoadData() {
                const status = await this.show(this.$route.params.id);

                if (status === 404) {
                    return this.$router.push({ name: 'admin.representatives.list' });
                }
                this.form = {
                    id: this.representative.id,
                    employeeNumber: this.representative.employee_number,
                    lastName: this.representative.last_name,
                    firstName: this.representative.first_name,
                    lastNameKana: this.representative.last_name_kana,
                    firstNameKana: this.representative.first_name_kana,
                    phoneNumber: this.representative.phone_number,
                    mainEmail: this.representative.main_email,
                    subEmail1: this.representative.sub_email1,
                    subEmail2: this.representative.sub_email2,
                    subEmail3: this.representative.sub_email3,
                    subEmail4: this.representative.sub_email4,
                    lastLoggedIn: this.representative.last_logged_in,
                    lastLoggedInAt: this.representative.last_logged_in_at
                };
            },
            getValidationState({ dirty, validated, valid = null }) {
                return dirty || validated ? valid : null;
            },
            onLastNameChange() {
                if (this.errorMessages && this.errorMessages.lastName) {
                    this.errorMessages.lastName = null;
                }
            },
            onFirstNameChange() {
                if (this.errorMessages && this.errorMessages.firstName) {
                    this.errorMessages.firstName = null;
                }
            },
            onLastNameKanaChange() {
                if (this.errorMessages && this.errorMessages.lastNameKana) {
                    this.errorMessages.lastNameKana = null;
                }
            },
            onFirstNameKanaChange() {
                if (this.errorMessages && this.errorMessages.firstNameKana) {
                    this.errorMessages.firstNameKana = null;
                }
            },
            onPhoneNumberChange() {
                if (this.errorMessages && this.errorMessages.phoneNumber) {
                    this.errorMessages.phoneNumber = null;
                }
            },
            async onBlur() {
                await this.checkValidated(this.form);
            },
            onSubmit() {
                this.$emit('submit', this.form);
            },
            onReset() {
                this.resetFormData();
            }
        }
    };
</script>

<style scoped>

</style>