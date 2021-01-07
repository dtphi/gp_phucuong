<template>
    <div class="container login-container">
        <div class="row justify-content-md-center login-block">
            <div class="col-lg-6 login-left">
                <div class="login-left-cont">
                    <p class="login-logo">
                        <b-img src="/img/login-logo.png" alt="Nittoh Energy"></b-img>
                    </p>
                    <h3 class="login-title">
                        <b-img src="/img/login-title.png" alt="Nittoh Mobile System"></b-img>
                    </h3>
                </div>
                <h4 class="login-foot-title">
                    <b-img src="/img/login-foot-title.png" alt="Nittoh Energy"></b-img>
                </h4>
            </div>

            <div class="col-lg-6 login-right">
                <h4 class="login-stt">パスワードの再発行</h4>
                <b-form-text v-if="systemError">{{ systemError }}</b-form-text>
                <p class="login-sub-txt">新しいパスワードを発行します。<br>ログインIDを入力し、パスワードの再発行ボタンを押してください。</p>

                <validation-observer ref="observer" v-slot="{ handleSubmit }" slim>
                    <b-form autocomplete="off" @submit.stop.prevent="handleSubmit(onSubmit)" class="login-frm">
                        <validation-provider mode="lazy"
                                             name="ログインID"
                                             rules="required|max:255"
                                             v-slot="validationContext"
                                             slim>
                            <b-input-group>
                                <b-form-input type="text"
                                              v-b-tooltip.html="form.tipData"
                                              placeholder="ログインID"
                                              v-model="form.email"
                                              maxlength="255"
                                              :class="{ 'is-invalid': errorMessages && errorMessages.email && validationContext.valid }"
                                              :state="getValidationState(validationContext)"
                                              @change="onEmailChange"></b-form-input>
                                <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.email" :key="index">{{ error }}</b-form-invalid-feedback>
                            </b-input-group>
                        </validation-provider>

                        <b-button type="submit" class="login-btn" :disabled="isLoading">
                            <b-spinner v-if="isLoading" type="border" class="mr-2" small></b-spinner> パスワードの再発行
                        </b-button>

                        <div class="text-center">
                            <b-link :to="{ name: 'public.auth.login' }" class="login-link">ログイン画面へ戻る</b-link>
                        </div>
                    </b-form>
                </validation-observer>
            </div>
        </div>

        <ModalAlert :title="modalAlert.title" :message="modalAlert.message" btn-ok="ログイン画面へ戻る" v-on:ok="ok"></ModalAlert>
    </div>
</template>

<script>
    import { mapActions } from 'vuex';
    import ModalAlert from '../../modals/ModalAlert';

    export default {
        name: 'ResetPassword',
        components: {
            ModalAlert
        },
        data() {
            return {
                form: {
                    email: null,
                    password: null,
                    tipData: { title: 'ログインＩＤとは<br>販売店様は99からはじまる8桁の数字、日東の営業担当者はメインメールアドレスを入力してください。' }
                },
                systemError: null,
                modalAlert: {
                    title: '',
                    message: ''
                }
            };
        },
        created() {
            this.systemError = this.getSystemErrors();
            this.clearSystemErrors();
        },
        methods: {
            ...mapActions('representative.auth', { representativeReset: 'resetPassword' }),
            ...mapActions('store.auth', { storeReset: 'resetPassword' }),
            getValidationState({ dirty, validated, valid = null }) {
                return dirty || validated ? valid : null;
            },
            onEmailChange() {
                if (this.errorMessages && this.errorMessages.email) {
                    this.errorMessages.email = null;
                }
            },
            validateEmail(email) {
                const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{1,}))$/;
                return re.test(String(email).toLowerCase());
            },
            async onSubmit() {
                if (this.validateEmail(this.form.email)) {
                    const status = await this.representativeReset(this.form);

                    if (status === 200) {
                        this.modalAlert = {
                            title: 'パスワードの再発行',
                            message: 'ご登録されているメインメールアドレスへ<br>新しいパスワードを送信しました。'
                        };
                        this.$bvModal.show('modal-alert');
                    }
                } else {
                    const status = await this.storeReset(this.form);

                    if (status === 200) {
                        this.modalAlert = {
                            title: 'パスワードの再発行依頼',
                            message: 'パスワードの再発行依頼をしました。<br>担当者より折り返しご連絡いたします。<br>しばらくお待ちください。'
                        };
                        this.$bvModal.show('modal-alert');
                    }
                }
            },
            ok() {
                this.$router.push({ name: 'public.auth.login' });
            }
        }
    };
</script>

<style scoped>

</style>