<template>
    <div class="row">
        <div class="col-xl-8 pb-5">
            <div class="div-content bg-white shadow">
                <div class="border-bottom mb-4">
                    <div class="p-3 d-flex align-items-center justify-content-between">
                        <h5>営業担当者情報</h5>
                        <div class="func-btn">
                            <b-link class="btn white-btn-custom py-1 font-weight-bold mr-2" :disabled="isLoading" @click="showConfirmRequestPassword">パスワード再発行</b-link>
                            <b-link class="btn white-btn-custom func-btn-red py-1 font-weight-bold" :disabled="isLoading" @click="showConfirmAccountDelete">アカウント削除</b-link>
                        </div>
                    </div>
                </div>

                <Form :is-create="false" btn-save="保存" v-on:submit="onSubmit"></Form>
            </div>
        </div>

        <div class="col-xl-4 pb-5">
            <div class="div-content bg-white shadow pb-4">
                <div class="border-bottom mb-4">
                    <div class="p-3 d-flex align-items-center justify-content-between">
                        <h5>担当販売店</h5>
                    </div>
                </div>

                <div class="m-3">
                    <div class="table-responsive custom-table">
                        <table class="table table-striped">
                            <thead class="thead bg-blue01">
                            <tr>
                                <th class="w-30">販売店コード</th>
                                <th class="w-50">販売店名</th>
                            </tr>
                            </thead>
                            <tbody>
                            <template v-if="dealers.length > 0">
                                <tr v-for="dealer in dealers" :key="dealer.id">
                                    <td><b-link :to="{ name: 'admin.stores.update', params: { id: dealer.id } }">{{ dealer.code }}</b-link></td>
                                    <td>{{ dealer.name }}</td>
                                </tr>
                            </template>
                            <template v-else>
                                <tr>
                                    <td colspan="2" class="text-center">担当販売店はありません</td>
                                </tr>
                            </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <ModalAlert :title="modals.alert.title" :message="modals.alert.message" v-on:ok="ok" v-on:close="ok"></ModalAlert>
        <ModalConfirm :title="modals.confirm.title"
                      :message="modals.confirm.message"
                      :btn-submit="modals.confirm.btnSubmit"
                      v-on:submit="submit"></ModalConfirm>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    import Form from './components/Form';
    import ModalAlert from '../../modals/ModalAlert';
    import ModalConfirm from '../../modals/ModalConfirm';

    export default {
        name: 'RepresentativesUpdate',
        components: {
            Form,
            ModalAlert,
            ModalConfirm
        },
        data() {
            return {
                modals: {
                    alert: {
                        type: '',
                        title: '',
                        message: ''
                    },
                    confirm: {
                        type: '',
                        title: '',
                        message: '',
                        btnSubmit: ''
                    }
                }
            };
        },
        computed: {
            ...mapGetters('admin.representatives', [ 'representative', 'dealers' ])
        },
        methods: {
            ...mapActions('admin.representatives', [ 'checkDeleted', 'update', 'resetPassword', 'delete' ]),
            async onSubmit(form) {
                const isDeleted = await this.onCheckDeleted();

                if (!isDeleted) {
                    const status = await this.update(form);

                    if (status === 200) {
                        this.modals.alert = {
                            type: 'update',
                            title: '保存完了',
                            message: '変更内容を保存しました。'
                        };
                        this.$bvModal.show('modal-alert');
                    }
                }
            },
            async showConfirmRequestPassword() {
                const isDeleted = await this.onCheckDeleted();

                if (!isDeleted) {
                    this.modals.confirm = {
                        type: 'request-password',
                        title: 'パスワード再発行',
                        message: 'パスワードを再発行します。<br>よろしいですか？',
                        btnSubmit: '再発行'
                    };
                    this.$bvModal.show('modal-confirm');
                }
            },
            async showConfirmAccountDelete() {
                const isDeleted = await this.onCheckDeleted();

                if (!isDeleted) {
                    if (this.dealers.length === 0) {
                        this.modals.confirm = {
                            type: 'account-delete',
                            title: 'アカウント削除',
                            message: 'この営業担当者の情報を削除します。<br>よろしいですか？',
                            btnSubmit: '削除'
                        };
                        this.$bvModal.show('modal-confirm');
                    } else {
                        this.modals.alert = {
                            type: 'account-un-deletable',
                            title: 'アカウント削除',
                            message: 'この営業担当者は担当販売店が設定されているため削除できません。'
                        };
                        this.$bvModal.show('modal-alert');
                    }
                }
            },
            ok() {
                if (this.modals.alert.type === 'account-delete') {
                    this.$router.push({ name: 'admin.representatives.list' });
                }
            },
            async submit() {
                switch (this.modals.confirm.type) {
                    case 'request-password':
                        const resetPasswordStatus = await this.resetPassword({ id: this.representative.id });

                        if (resetPasswordStatus === 200) {
                            this.modals.alert = {
                                type: 'request-password',
                                title: 'パスワード送信完了',
                                message: '登録されているメインメールアドレス宛に<br>新しいパスワードを送信しました。'
                            };
                            this.$bvModal.hide('modal-confirm');
                            this.$bvModal.show('modal-alert');
                        }
                        break;
                    case 'account-delete':
                        const deleteStatus = await this.delete(this.representative.id);

                        if (deleteStatus === 200) {
                            this.modals.alert = {
                                type: 'account-delete',
                                title: 'アカウント削除完了',
                                message: 'アカウント削除完了。'
                            };
                            this.$bvModal.hide('modal-confirm');
                            this.$bvModal.show('modal-alert');
                        }
                        break;
                }
            },
            async onCheckDeleted() {
                const status = await this.checkDeleted(this.representative.id);

                switch (status) {
                    case 200:
                        return false;
                    case 410:
                        this.modals.alert = {
                            type: 'account-deleted',
                            title: 'アカウント削除',
                            message: 'この営業担当者は既に削除されています。'
                        };
                        this.$bvModal.show('modal-alert');

                        return true;
                }
            }
        }
    };
</script>

<style scoped>

</style>