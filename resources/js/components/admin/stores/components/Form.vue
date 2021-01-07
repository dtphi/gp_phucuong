<template>
    <validation-observer ref="observer" v-slot="{ handleSubmit }" slim>
        <b-form autocomplete="off" class="m-3 custom-form" @submit.stop.prevent="handleSubmit(onSubmit)">
            <div v-if="form.requestedReissuanceAt" class="col-lg-10 ml-lg-5 p-0">
                <div class="alert bg-blue02 text-red my-3 alert-dismissible fade show font-weight-bold pr-3 d-flex flex-column flex-lg-row justify-content-lg-between">
                    <span>パスワードの再発行依頼が届いています。パスワードの再発行をしてください。</span>
                    <b-link class="text-dark float-right h6 pt-4 p-sm-0 mb-0" @click="onCancelResetPassword">
                        <u>依頼を取り消す</u>
                    </b-link>
                </div>
            </div>

            <div class="div-info col-lg-10 ml-lg-5 p-0">
                <div class="row info-item align-content-center m-0">
                    <label for="txt-code" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">
                        販売店コード <span class="badge badge-danger">必須</span>
                    </label>
                    <div class="row col-sm-8 col-lg-9 my-2 mx-0">
                        <validation-provider mode="lazy"
                                             name="販売店コード"
                                             rules="required|max:8|alpha_num"
                                             v-slot="validationContext"
                                             slim>
                            <b-input-group>
                                <b-form-input type="text"
                                              id="txt-code"
                                              placeholder="販売店コード"
                                              v-model="form.code"
                                              class="col-lg-5"
                                              maxlength="8"
                                              :class="{ 'is-invalid': errorMessages && errorMessages.code && validationContext.valid }"
                                              :state="getValidationState(validationContext)"
                                              @blur="onBlur"></b-form-input>
                                <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.code" :key="index">{{ error }}</b-form-invalid-feedback>
                            </b-input-group>
                        </validation-provider>
                    </div>
                </div>

                <div class="row info-item m-0">
                    <label for="txt-name" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">
                        販売店名 <span class="badge badge-danger">必須</span>
                    </label>
                    <div class="row col-sm-8 col-lg-9 my-2 mx-0">
                        <validation-provider mode="lazy"
                                             name="販売店名"
                                             rules="required|max:40"
                                             v-slot="validationContext"
                                             slim>
                            <b-input-group>
                                <b-form-input type="text"
                                              id="txt-name"
                                              placeholder="販売店名"
                                              v-model="form.name"
                                              maxlength="255"
                                              :class="{ 'is-invalid': errorMessages && errorMessages.name && validationContext.valid }"
                                              :state="getValidationState(validationContext)"
                                              @change="onNameChange"></b-form-input>
                                <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.name" :key="index">{{ error }}</b-form-invalid-feedback>
                            </b-input-group>
                        </validation-provider>
                    </div>
                </div>

                <div class="row info-item m-0">
                    <label for="txt-rep-last-name" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">代表者氏名</label>
                    <div class="row col-sm-8 col-lg-9 my-2 mx-0">
                        <div class="col-6 pl-0">
                            <validation-provider mode="lazy"
                                                 name="代表者性"
                                                 rules="max:20"
                                                 v-slot="validationContext"
                                                 slim>
                                <b-input-group>
                                    <b-form-input type="text"
                                                  id="txt-last-name"
                                                  placeholder="姓"
                                                  v-model="form.repLastName"
                                                  maxlength="255"
                                                  :class="{ 'is-invalid': errorMessages && errorMessages.repLastName && validationContext.valid }"
                                                  :state="getValidationState(validationContext)"
                                                  @change="onRepLastNameChange"></b-form-input>
                                    <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                    <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.repLastName" :key="index">{{ error }}</b-form-invalid-feedback>
                                </b-input-group>
                            </validation-provider>
                        </div>
                        <div class="col-6 pr-0">
                            <validation-provider mode="lazy"
                                                 name="代表者名"
                                                 rules="max:20"
                                                 v-slot="validationContext"
                                                 slim>
                                <b-input-group>
                                    <b-form-input type="text"
                                                  placeholder="名"
                                                  v-model="form.repFirstName"
                                                  maxlength="255"
                                                  :class="{ 'is-invalid': errorMessages && errorMessages.repFirstName && validationContext.valid }"
                                                  :state="getValidationState(validationContext)"
                                                  @change="onRepFirstNameChange"></b-form-input>
                                    <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                    <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.repFirstName" :key="index">{{ error }}</b-form-invalid-feedback>
                                </b-input-group>
                            </validation-provider>
                        </div>
                    </div>
                </div>

                <div class="row info-item m-0">
                    <label for="txt-rep-last-name-kana" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">フリガナ</label>
                    <div class="row col-sm-8 col-lg-9 my-2 mx-0">
                        <div class="col-6 pl-0">
                            <validation-provider mode="lazy"
                                                 name="代表者フリガナ性"
                                                 rules="max:20|katakana"
                                                 v-slot="validationContext"
                                                 slim>
                                <b-input-group>
                                    <b-form-input type="text"
                                                  id="txt-rep-last-name-kana"
                                                  placeholder="姓"
                                                  v-model="form.repLastNameKana"
                                                  maxlength="255"
                                                  :class="{ 'is-invalid': errorMessages && errorMessages.repLastNameKana && validationContext.valid }"
                                                  :state="getValidationState(validationContext)"
                                                  @change="onRepLastNameKanaChange"></b-form-input>
                                    <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                    <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.repLastNameKana" :key="index">{{ error }}</b-form-invalid-feedback>
                                </b-input-group>
                            </validation-provider>
                        </div>
                        <div class="col-6 pr-0">
                            <validation-provider mode="lazy"
                                                 name="代表者フリガナ名"
                                                 rules="max:20|katakana"
                                                 v-slot="validationContext"
                                                 slim>
                                <b-input-group>
                                    <b-form-input type="text"
                                                  placeholder="名"
                                                  v-model="form.repFirstNameKana"
                                                  maxlength="255"
                                                  :class="{ 'is-invalid': errorMessages && errorMessages.repFirstNameKana && validationContext.valid }"
                                                  :state="getValidationState(validationContext)"
                                                  @change="onRepFirstNameKanaChange"></b-form-input>
                                    <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                    <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.repFirstNameKana" :key="index">{{ error }}</b-form-invalid-feedback>
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
                    <label for="txt-fax-number" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">FAX番号</label>
                    <div class="row col-sm-8 col-lg-9 my-2 mx-0">
                        <div class="col-6 pl-0">
                            <validation-provider mode="lazy"
                                                 name="FAX番号"
                                                 rules="max:14|phone"
                                                 v-slot="validationContext"
                                                 slim>
                                <b-input-group>
                                    <b-form-input type="text"
                                                  id="txt-fax-number"
                                                  placeholder="FAX番号"
                                                  v-model="form.faxNumber"
                                                  maxlength="255"
                                                  :class="{ 'is-invalid': errorMessages && errorMessages.faxNumber && validationContext.valid }"
                                                  :state="getValidationState(validationContext)"
                                                  @change="onFaxNumberChange"></b-form-input>
                                    <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                    <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.faxNumber" :key="index">{{ error }}</b-form-invalid-feedback>
                                </b-input-group>
                            </validation-provider>
                        </div>
                    </div>
                </div>

                <div class="row info-item m-0">
                    <label for="txt-address" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">
                        住所 <span class="badge badge-danger">必須</span>
                    </label>
                    <div class="row col-sm-8 col-lg-9 my-2 mx-0">
                        <validation-provider mode="lazy"
                                             name="住所"
                                             rules="required|max:100"
                                             v-slot="validationContext"
                                             slim>
                            <b-input-group>
                                <b-form-input type="text"
                                              id="txt-address"
                                              placeholder="住所"
                                              v-model="form.address"
                                              maxlength="255"
                                              :class="{ 'is-invalid': errorMessages && errorMessages.address && validationContext.valid }"
                                              :state="getValidationState(validationContext)"
                                              @change="onAddressChange"></b-form-input>
                                <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.address" :key="index">{{ error }}</b-form-invalid-feedback>
                            </b-input-group>
                        </validation-provider>
                    </div>
                </div>

                <div class="row info-item m-0">
                    <label for="txt-main-email" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">メインメールアドレス</label>
                    <div class="row col-sm-8 col-lg-9 my-2 mx-0">
                        <validation-provider mode="lazy"
                                             name="メインメールアドレス"
                                             rules="email|max:255"
                                             v-slot="validationContext"
                                             slim>
                            <b-input-group>
                                <b-form-input type="text"
                                              id="txt-main-email"
                                              placeholder="メインメールアドレス"
                                              v-model="form.mainEmail"
                                              maxlength="255"
                                              :class="{ 'is-invalid': errorMessages && errorMessages.mainEmail && validationContext.valid }"
                                              :state="getValidationState(validationContext)"
                                              @blur="onBlur"></b-form-input>
                                <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.mainEmail" :key="index">{{ error }}</b-form-invalid-feedback>
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

                <div class="row info-item m-0">
                    <label for="txt-employee-number" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">
                        営業担当者 <span class="badge badge-danger">必須</span>
                    </label>
                    <div class="row col-sm-8 col-lg-9 my-2 mx-0">
                        <b-form-text class="px-0 py-3 mr-3">担当者コード</b-form-text>
                        <validation-provider mode="lazy"
                                             name="担当者コード"
                                             rules="required|digits:4|numeric"
                                             v-slot="validationContext"
                                             slim>
                            <b-input-group class="col-8 col-lg-6 pl-0">
                                <b-form-input type="text"
                                              id="txt-employee-number"
                                              placeholder="担当者コード"
                                              v-model="form.employeeNumber"
                                              maxlength="4"
                                              :class="{ 'is-invalid': errorMessages && errorMessages.employeeNumber && validationContext.valid }"
                                              :state="getValidationState(validationContext)"
                                              @blur="onGetEmployee"
                                              @keydown.enter.prevent></b-form-input>
                                <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.employeeNumber" :key="index">{{ error }}</b-form-invalid-feedback>
                            </b-input-group>
                        </validation-provider>

                        <b-button class="form-control btn white-btn-custom col-3 col-sm-4 col-lg-2"
                                  :disabled="isLoading"
                                  @click="onGetEmployee">決定
                        </b-button>

                        <ul v-if="employee" class="w-100 my-2 ml-5">
                            <li>{{ employee.employee_number }} {{ employee.full_name }}</li>
                        </ul>
                    </div>
                </div>

                <div class="row info-item m-0">
                    <label for="txt-memo" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">メモ</label>
                    <div class="row col-sm-8 col-lg-9 my-2 mx-0">
                        <validation-provider mode="lazy"
                                             name="メモ"
                                             rules="max:1000"
                                             v-slot="validationContext"
                                             slim>
                            <b-input-group>
                                <b-form-textarea id="txt-memo"
                                                 placeholder="メモ"
                                                 v-model="form.memo"
                                                 class="col-lg-8"
                                                 rows="6"
                                                 :class="{ 'is-invalid': errorMessages && errorMessages.memo && validationContext.valid }"
                                                 :state="getValidationState(validationContext)"
                                                 @change="onMemoChange"></b-form-textarea>
                                <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.memo" :key="index">{{ error }}</b-form-invalid-feedback>
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
                        :to="{ name: 'admin.stores.list' }"
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
    import { mapActions, mapGetters, mapMutations } from 'vuex';

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
                    code: '',
                    name: '',
                    repLastName: '',
                    repFirstName: '',
                    repLastNameKana: '',
                    repFirstNameKana: '',
                    phoneNumber: '',
                    faxNumber: '',
                    address: '',
                    mainEmail: '',
                    subEmail1: '',
                    subEmail2: '',
                    subEmail3: '',
                    subEmail4: '',
                    employeeNumber: '',
                    memo: '',
                    requestedReissuanceAt: null,
                    lastLoggedIn: null,
                    lastLoggedInAt: null,
                    canSave: false
                }
            };
        },
        computed: {
            ...mapGetters('admin.auth', [ 'admin' ]),
            ...mapGetters('admin.stores', [ 'store', 'employee' ])
        },
        mounted() {
            this.SET_EMPLOYEE(null);

            if (!this.isCreate) {
                this.onLoadData();
            }
        },
        watch: {
            'form.employeeNumber'(value) {
                this.$emit('input', value);
            },
            errorMessages() {
                if (this.errorMessages && this.errorMessages.employeeNumber) {
                    this.SET_EMPLOYEE(null);
                }
            }
        },
        methods: {
            ...mapActions('admin.stores', [ 'getEmployee', 'checkValidated', 'show', 'cancelResetPassword' ]),
            ...mapMutations('admin.stores', [ 'SET_EMPLOYEE' ]),
            async onLoadData() {
                const status = await this.show(this.$route.params.id);

                if (status === 404) {
                    return this.$router.push({ name: 'admin.stores.list' });
                }
                this.form = {
                    id: this.store.id,
                    code: this.store.code,
                    name: this.store.name,
                    repLastName: this.store.rep_last_name,
                    repFirstName: this.store.rep_first_name,
                    repLastNameKana: this.store.rep_last_name_kana,
                    repFirstNameKana: this.store.rep_first_name_kana,
                    phoneNumber: this.store.phone_number,
                    faxNumber: this.store.fax_number,
                    address: this.store.address,
                    mainEmail: this.store.main_email,
                    subEmail1: this.store.sub_email1,
                    subEmail2: this.store.sub_email2,
                    subEmail3: this.store.sub_email3,
                    subEmail4: this.store.sub_email4,
                    employeeNumber: this.employee ? this.employee.employee_number : '',
                    memo: this.store.memo,
                    requestedReissuanceAt: this.store.requested_reissuance_at,
                    lastLoggedIn: this.store.last_logged_in,
                    lastLoggedInAt: this.store.last_logged_in_at
                };
            },
            getValidationState({ dirty, validated, valid = null }) {
                return dirty || validated ? valid : null;
            },
            onNameChange() {
                if (this.errorMessages && this.errorMessages.name) {
                    this.errorMessages.name = null;
                }
            },
            onRepLastNameChange() {
                if (this.errorMessages && this.errorMessages.repLastName) {
                    this.errorMessages.repLastName = null;
                }
            },
            onRepFirstNameChange() {
                if (this.errorMessages && this.errorMessages.repFirstName) {
                    this.errorMessages.repFirstName = null;
                }
            },
            onRepLastNameKanaChange() {
                if (this.errorMessages && this.errorMessages.repLastNameKana) {
                    this.errorMessages.repLastNameKana = null;
                }
            },
            onRepFirstNameKanaChange() {
                if (this.errorMessages && this.errorMessages.repFirstNameKana) {
                    this.errorMessages.repFirstNameKana = null;
                }
            },
            onPhoneNumberChange() {
                if (this.errorMessages && this.errorMessages.phoneNumber) {
                    this.errorMessages.phoneNumber = null;
                }
            },
            onFaxNumberChange() {
                if (this.errorMessages && this.errorMessages.faxNumber) {
                    this.errorMessages.faxNumber = null;
                }
            },
            onAddressChange() {
                if (this.errorMessages && this.errorMessages.address) {
                    this.errorMessages.address = null;
                }
            },
            onMemoChange() {
                if (this.errorMessages && this.errorMessages.memo) {
                    this.errorMessages.memo = null;
                }
            },
            async onBlur() {
                await this.checkValidated(this.form);
            },
            async onCancelResetPassword() {
                const status = await this.cancelResetPassword({ id: this.$route.params.id });

                if (status === 200) {
                    this.form.requestedReissuanceAt = null;
                }
            },
            async onGetEmployee() {
                if (!this.form.employeeNumber) {
                    const errors = {
                        extend: true,
                        errors: { employeeNumber: [ '担当者コードを入力してください' ] }
                    };
                    this.SET_ERRORS(errors);

                    return false;
                }
                if (this.employee && this.employee.employee_number === this.form.employeeNumber) {
                    this.form.canSave = true;

                    return false;
                }
                const status = await this.getEmployee(this.form.employeeNumber);

                this.form.canSave = status === 200;
            },
            async onSubmit() {
                if (!this.employee && !this.form.employeeNumber) {
                    const errors = {
                        extend: true,
                        errors: { employeeNumber: [ '営業担当者が未選択です。担当者コードを入力し、決定ボタンを押してください。' ] }
                    };
                    this.SET_ERRORS(errors);

                    return false;
                }
                this.form.canSave = false;

                await this.onGetEmployee();

                if (this.form.canSave) {
                    this.form.saleRepId = this.employee.id;
                    this.form.saleRepName = this.employee.full_name;

                    this.$emit('submit', this.form);
                }
            },
            onReset() {
                this.SET_EMPLOYEE(null);
                this.resetFormData();
            }
        }
    };
</script>

<style scoped>

</style>