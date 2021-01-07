<template>
    <div class="sales-cont">
        <div class="div-content bg-white shadow py-3">
            <validation-observer ref="observer" v-slot="{ handleSubmit }" slim v-if="purchase">
                <b-form autocomplete="off" class="m-3 custom-form" @submit.stop.prevent="handleSubmit(onSubmit)">
                    <div class="row ml-lg-5 mt-4 mb-1">
                        <p class="fs12">商品を再発注します。<br>必要事項を入力し、再発注ボタンを押してください。</p>
                    </div>

                    <div class="div-info col-lg-10 ml-lg-5 p-0">
                        <div class="row info-item align-content-center m-0">
                            <label for="txt-employee-number" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">
                                発注日
                            </label>
                            <div class="row col-sm-8 col-lg-9 my-2 mx-0">
                                <p class="my-3">{{ purchase.order_date }}</p>
                            </div>
                        </div>

                        <div class="row info-item align-content-center m-0">
                            <label for="txt-employee-number" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">
                                メーカー
                            </label>
                            <div class="row col-sm-8 col-lg-9 my-2 mx-0">
                                <p class="my-3">{{ purchase.manufacturer_name }}</p>
                            </div>
                        </div>

                        <div class="row info-item align-content-center m-0">
                            <label for="txt-employee-number" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">
                                商品名
                            </label>
                            <div class="row col-sm-8 col-lg-9 my-2 mx-0">
                                <p class="my-3">{{ purchase.product_name }}</p>
                            </div>
                        </div>

                        <div class="row info-item align-content-center m-0">
                            <label for="txt-employee-number" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">
                                型式
                            </label>
                            <div class="row col-sm-8 col-lg-9 my-2 mx-0">
                                <p class="my-3">{{ purchase.model }}</p>
                            </div>
                        </div>

                        <!-- <div class="row info-item align-content-center m-0">
                            <label for="txt-employee-number" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">
                                単価
                            </label>
                            <div class="row col-sm-8 col-lg-9 my-2 mx-0">
                                <p class="my-3">{{ purchase.unit_price }}</p>
                            </div>
                        </div> -->

                        <div class="row info-item m-0">
                            <label for="txt-last-name" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">
                                ガス種 <span class="badge badge-danger">必須</span>
                            </label>
                            <div class="row col-sm-8 col-lg-9 my-2 mx-0">
                                <div class="col-12 col-sm-6 col-lg-4 pl-0">
                                    <validation-provider mode="lazy"
                                                 name="ガス種"
                                                 rules="required"
                                                 v-slot="validationContext"
                                                 slim>
                                        <b-input-group>
                                            <b-form-select 
                                                v-model="selected.type" 
                                                :options="typeOptions" 
                                                class="form-control" 
                                                :state="getValidationState(validationContext)"
                                            >
                                            </b-form-select>
                                            <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                        </b-input-group>
                                    </validation-provider>
                                </div>
                            </div>
                        </div>

                        <div class="row info-item m-0">
                            <label for="txt-last-name" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">
                                納品場所 <span class="badge badge-danger">必須</span>
                            </label>
                            <div class="row col-sm-8 col-lg-9 my-2 mx-0">
                                <div class="col-12 col-sm-6 col-lg-4 pl-0">
                                    <validation-provider mode="lazy"
                                                 name="納品場所"
                                                 rules="required"
                                                 v-slot="validationContext"
                                                 slim>
                                        <b-input-group>
                                            <b-form-select 
                                                v-model="selected.delivery" 
                                                :options="deliveryOptions" 
                                                class="form-control" 
                                                :state="getValidationState(validationContext)"
                                            >
                                            </b-form-select>
                                            <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                        </b-input-group>
                                    </validation-provider>
                                </div>
                            </div>
                        </div>

                        <div class="row info-item m-0">
                            <label for="txt-phone-number" class="col-12 col-sm-4 col-lg-3 bg-blue01 mb-0 font-weight-bold">
                                数量 <span class="badge badge-danger">必須</span>
                            </label>
                            <div class="row col-sm-8 col-lg-9 my-2 mx-0">
                                <div class="col-12 col-sm-6 col-lg-4 pl-0">
                                    <validation-provider mode="lazy"
                                                 name="数量"
                                                 rules="required"
                                                 v-slot="validationContext"
                                                 slim>
                                        <b-input-group>
                                            <b-form-select 
                                                v-model="selected.quantity" 
                                                :options="quantityOptions" 
                                                class="form-control" 
                                                :state="getValidationState(validationContext)"
                                            >
                                            </b-form-select>
                                            <b-form-invalid-feedback v-if="validationContext.errors.length > 0">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                        </b-input-group>
                                    </validation-provider>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row ml-lg-5 mt-4 mb-1 fs12">
                        <p class="fs12">現在の単価につきましては各メーカーのオンラインカタログをご確認いただくか、弊社の営業担当者までお問合せください。</p>
                    </div>

                    <div class="row justify-content-center mt-5 mb-1">
                        <b-link
                                :to="{ name: 'store.history.purchase.list' }"
                                role="button"
                                class="btn col-sm-3 white-btn-custom btn-lg mw-9 m-3 font-weight-bold">キャンセル
                        </b-link>
                        <b-button
                                type="submit"
                                class="col-sm-3 blue-btn-custom btn-lg mw-9 m-3 font-weight-bold"
                                :disabled="isLoading">
                            <b-spinner v-if="isLoading" type="border" class="mr-2" small></b-spinner> 再発注
                        </b-button>
                    </div>
                </b-form>
            </validation-observer>
        </div>
        <ModalConfirm 
            :title="modal.title"
            :message="modal.message"
            :btn-submit="modal.btnSubmit"
            :btn-cancel="modal.btnCancel"
            v-on:submit="modal.funcSubmit"
            v-on:close="modal.funcClose"
        >
        </ModalConfirm>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    import ModalConfirm from '../../modals/ModalConfirm';

    export default {
        name: 'PurchaseDetail',
        components: {
            ModalConfirm
        },
        data() {
            return {
                height: '0',
                selected: {
                    type: null,
                    delivery: null,
                    quantity: null,
                },
                modal: {
                    title: '',
                    message: '',
                    btnSubmit: '',
                    btnCancel: '',
                    funcSubmit: () => {
                        this.$emit('submit')
                    },
                    funcClose: () => {
                        this.$emit('close')
                    }
                },
                typeOptions: [
                    { value: null, text: '選択してください', disabled: true },
                    { value: 'lpg', text: 'LPG' },
                    { value: '13a', text: '13A' },
                    { value: 'none', text: '指定なし' }
                ],
                deliveryOptions: [
                    { value: null, text: '選択してください', disabled: true },
                    { value: 'dealer', text: '販売店様' },
                    { value: 'nitto', text: '日東' }
                ]
            };
        },
        async mounted() {
            this.height = this.calculateHeight();
            const status = await this.fetchPurchase({purchaseId: this.$route.params.id, storeCode: this.store.code});

            if (status === 404) {
                return this.$router.push({ name: 'store.history.purchase.list' });
            }
        },
        computed: {
            ...mapGetters('store.auth', [ 'store' ]),
            ...mapGetters('store.history', [ 'purchase' ]),
            quantityOptions() {
                const options = [ { value: null, text: '選択してください', disabled: true } ];
                
                return options.concat(Array.from({ length: 100 }, (x, i) => i+1));
            },
        },
        methods: {
            ...mapActions('store.history', [ 'fetchPurchase', 'reorder' ]),
            getValidationState({ dirty, validated, valid = null }) {
                return dirty || validated ? valid : null;
            },
            redirectToPurchaseList() {
                this.$router.push({ name: 'store.history.purchase.list' });
            },
            redirectToStoreChat() {
                this.$router.push({ name: 'store.chat.messages' });
            },
            async onConfirm() {
                const status = await this.reorder({purchaseId: this.$route.params.id, storeCode: this.store.code, form: this.selected});

                if (status === 200) {
                    this.$bvModal.hide('modal-confirm');

                    this.modal = {
                        title: '再発注完了',
                        message: '再発注情報をメッセージで送信しました。',
                        btnSubmit: 'メッセージを表示する',
                        btnCancel: '購入履歴へ戻る',
                        funcSubmit: this.redirectToStoreChat,
                        funcClose: this.redirectToPurchaseList
                    };

                    this.$bvModal.show('modal-confirm');
                }
            },
            async onSubmit() {
                this.modal = {
                    title: '再発注確認',
                    message: '再発注します。<br>よろしいですか？',
                    btnSubmit: 'はい',
                    btnCancel: 'キャンセル',
                    funcSubmit: this.onConfirm,
                    funcClose: () => {
                        this.$emit('close')
                    }
                };

                this.$bvModal.show('modal-confirm');
            }
        }
    };
</script>