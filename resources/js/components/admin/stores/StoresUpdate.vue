<template>
    <div class="div-content bg-white shadow">
        <div class="border-bottom mb-4">
            <div class="p-3 d-flex align-items-center justify-content-between">
                <h5>販売店情報</h5>
                <div class="func-btn">
                    <b-link class="btn blue-btn-custom py-1 font-weight-bold mr-2" :disabled="isLoading" @click="onShowMessages">メッセージ</b-link>
                    <b-link class="btn white-btn-custom py-1 font-weight-bold mr-2" :disabled="isLoading" @click="showConfirmRequestPassword">パスワード再発行</b-link>
                    <b-link class="btn white-btn-custom func-btn-red py-1 font-weight-bold" :disabled="isLoading" @click="showConfirmAccountDelete">アカウント削除</b-link>
                </div>
            </div>
        </div>

        <Form ref="form" :is-create="false" btn-save="保存" v-on:submit="onSubmit"></Form>

        <ModalAlert :title="modals.alert.title" :message="modals.alert.message" v-on:ok="ok" v-on:close="ok"></ModalAlert>
        <ModalConfirm :title="modals.confirm.title"
                      :message="modals.confirm.message"
                      :btn-submit="modals.confirm.btnSubmit"
                      v-on:submit="submit"
                      v-on:close="close"></ModalConfirm>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    import Form from './components/Form';
    import ModalAlert from '../../modals/ModalAlert';
    import ModalConfirm from '../../modals/ModalConfirm';

    export default {
        name: 'StoresUpdate',
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
            ...mapGetters('admin.auth', [ 'admin' ]),
            ...mapGetters('admin.stores', [ 'store' ])
        },
        methods: {
            ...mapActions('admin.stores', [ 'checkDeleted', 'update', 'updateLastLoggedIn', 'resetPassword', 'delete' ]),
            async onShowMessages() {
                const isDeleted = await this.onCheckDeleted();

                if (!isDeleted) {
                    this.$router.push({
                        name: 'admin.stores.show.messages',
                        params: { id: this.store.id }
                    });
                }
            },
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
                    let type = 'request-password';
                    let title = 'パスワード再発行';
                    let message = 'パスワードを再発行します。<br>よろしいですか？';

                    if (moment(this.store.requested_reissuance_at).isBefore(this.store.last_logged_in_at, 'second')) {
                        type = 'request-password-confirm';
                        title = 'パスワード再発行確認';
                        message = 'パスワード再発行依頼後にログイン記録があります。<br>パスワードの再発行を続行しますか？';
                    }
                    this.modals.confirm = {
                        type,
                        title,
                        message,
                        btnSubmit: '再発行'
                    };
                    this.$bvModal.show('modal-confirm');
                }
            },
            async showConfirmAccountDelete() {
                const isDeleted = await this.onCheckDeleted();

                if (!isDeleted) {
                    this.modals.confirm = {
                        type: 'account-delete',
                        title: 'アカウント削除',
                        message: 'この販売店の情報を削除します。<br>よろしいですか？',
                        btnSubmit: '削除'
                    };
                    this.$bvModal.show('modal-confirm');
                }
            },
            ok() {
                if (this.modals.alert.type === 'account-delete') {
                    this.$router.push({ name: 'admin.stores.list' });
                }
            },
            async close() {
                if (this.modals.confirm.type === 'request-password-confirm') {
                    const status = await this.updateLastLoggedIn({ id: this.store.id });

                    if (status === 200) {
                        this.$refs.form.onLoadData();
                    }
                }
            },
            async submit() {
                switch (this.modals.confirm.type) {
                    case 'request-password':
                    case 'request-password-confirm':
                        const resetPasswordStatus = await this.resetPassword({ id: this.store.id });

                        if (resetPasswordStatus === 200) {
                            this.modals.alert = {
                                type: 'request-password',
                                title: 'パスワード送信完了',
                                message: '管理者のメールアドレス宛に<br>新しいパスワードを送信しました。'
                            };
                            this.$bvModal.hide('modal-confirm');
                            this.$bvModal.show('modal-alert');

                            this.$refs.form.onLoadData();
                        }
                        break;
                    case 'account-delete':
                        const deleteStatus = await this.delete(this.store.id);

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
                const status = await this.checkDeleted(this.store.id);

                switch (status) {
                    case 200:
                        return false;
                    case 410:
                        this.modals.alert = {
                            type: 'account-deleted',
                            title: 'アカウント削除',
                            message: 'この販売店は既に削除されています。'
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