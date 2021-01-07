<template>
    <div class="container login-container" :style="{ height: height }">
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
                <h4 class="login-stt">ログイン</h4>
                <b-form-text v-if="systemError">{{ systemError }}</b-form-text>

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

                        <validation-provider mode="lazy"
                                             name="パスワード"
                                             rules="required|alpha_num|min:8|max:32"
                                             v-slot="validationContext"
                                             slim>
                            <b-input-group>
                                <b-form-input type="password"
                                              placeholder="パスワード"
                                              v-model="form.password"
                                              maxlength="255"
                                              :class="{ 'is-invalid': errorMessages && errorMessages.password && validationContext.valid }"
                                              :state="getValidationState(validationContext)"
                                              @change="onPasswordChange"></b-form-input>
                                <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                <b-form-invalid-feedback v-else-if="!isLoading" v-for="(error, index) in errorMessages && errorMessages.password" :key="index">{{ error }}</b-form-invalid-feedback>
                            </b-input-group>
                        </validation-provider>

                        <b-button type="submit" class="login-btn" :disabled="isLoading">
                            <b-spinner v-if="isLoading" type="border" class="mr-2" small></b-spinner> ログイン
                        </b-button>

                        <div class="text-center">
                            <b-link :to="{ name: 'public.auth.reset.password' }" class="login-link">パスワードをお忘れの場合</b-link>
                        </div>
                    </b-form>
                </validation-observer>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapActions } from 'vuex';

    export default {
        name: 'Login',
        data() {
            return {
                form: {
                    email: null,
                    password: null,
                    tipData: { title: 'ログインＩＤとは<br>販売店様は99からはじまる8桁の数字、日東の営業担当者はメインメールアドレスを入力してください。' }
                },
                systemError: null,
                height: '0px'
            };
        },
        created() {
            this.systemError = this.getSystemErrors();
            this.clearSystemErrors();
        },
        mounted() {
            this.height = this.styleHeight(true);
        },
        methods: {
            ...mapActions('representative.auth', { representativeLogin: 'login' }),
            ...mapActions('store.auth', { storeLogin: 'login' }),
            getValidationState({ dirty, validated, valid = null }) {
                return dirty || validated ? valid : null;
            },
            onEmailChange() {
                if (this.errorMessages && this.errorMessages.email) {
                    this.errorMessages.email = null;
                }
            },
            onPasswordChange() {
                if (this.errorMessages && this.errorMessages.password) {
                    this.errorMessages.password = null;
                }
            },
            validateEmail(email) {
                const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{1,}))$/;
                return re.test(String(email).toLowerCase());
            },
            async onSubmit() {
                if (this.validateEmail(this.form.email)) {
                    const status = await this.representativeLogin(this.form);

                    if (status === 200) {
                        this.$router.push({ name: 'representative.menu.main.menu' });
                    }
                } else {
                    const status = await this.storeLogin(this.form);

                    if (status === 200) {
                        this.$router.push({ name: 'store.menu.main.menu' });
                    }
                }
            },
            test() {
                const wh = $(window).height();
                const footer = $('footer').outerHeight();

                return `${wh - footer}px`;
            }
        }
    };
</script>

<style scoped>

</style>