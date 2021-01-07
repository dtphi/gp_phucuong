<template>
    <div>
        <b-modal id="modal-show-sub-emails"
                 size="lg"
                 centered
                 scrollable
                 no-close-on-backdrop
                 no-close-on-esc
                 title="転送 : 宛先を選択"
                 title-tag="h5"
                 hide-footer
                 ok-only
                 @close="close">
            <validation-observer ref="observer" v-if="options.length" v-slot="{ handleSubmit }" slim>
                <b-form autocomplete="off" class="m-3 custom-form wrap-txt" @submit.stop.prevent="handleSubmit(onSubmit)">
                    <div class="d-block my-5">
                        <validation-provider mode="lazy"
                                             name="サブメールアドレス"
                                             :rules="{ required: { allowFalse: false } }"
                                             v-slot="validationContext"
                                             slim>
                            <b-input-group>
                                <b-form-checkbox-group v-model="emails"
                                                       :options="options"
                                                       stacked></b-form-checkbox-group>
                                <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                            </b-input-group>
                        </validation-provider>
                    </div>

                    <div class="row justify-content-center text-center w-100">
                        <button type="submit" class="btn blue-btn-custom mw-9 m-3" size="sm" :disabled="isLoading">
                            <b-spinner v-if="isLoading" type="border" class="mr-2" small></b-spinner> 送信
                        </button>
                    </div>
                </b-form>
            </validation-observer>

            <template v-else>
                <div class="d-block my-5 text-center">
                    <p>サブメールアドレスが登録されていません。</p>
                </div>

                <div class="row justify-content-center text-center w-100">
                    <button class="btn blue-btn-custom mw-9 m-3" size="sm" @click="ok()">閉じる</button>
                </div>
            </template>
        </b-modal>
    </div>
</template>

<script>
    import { mapActions } from 'vuex';

    export default {
        name: 'ModalShowSubEmails',
        props: {
            id: {
                type: [ String, Number ],
                required: true
            },
            options: {
                type: Array,
                required: true
            }
        },
        data() {
            return {
                emails: []
            };
        },
        methods: {
            ...mapActions('representative.messages', [ 'sendToSubEmails' ]),
            async onSubmit() {
                const data = {
                    id: this.id,
                    subEmails: this.emails
                };
                const status = await this.sendToSubEmails(data);

                if (status === 200) {
                    this.resetFormData();
                    this.$bvModal.hide('modal-show-sub-emails');
                }
            },
            ok() {
                this.$bvModal.hide('modal-show-sub-emails');
                this.$emit('ok');
            },
            close() {
                this.resetFormData();
                this.$emit('close');
            }
        }
    };
</script>

<style scoped>

</style>