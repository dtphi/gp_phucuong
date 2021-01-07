<template>
    <div class="sales-cont">
        <div class="div-content bg-white shadow pb-3">
            <div class="border-bottom mb-4">
                <div class="p-3 d-flex align-items-center justify-content-between">
                    <h5>新規登録</h5>
                </div>
            </div>

            <Form ref="form" btn-save="登録" v-on:submit="onSubmit"></Form>
        </div>

        <ModalAlert title="新規登録完了" message="営業担当者の登録が完了しました。" v-on:ok="ok" v-on:close="close"></ModalAlert>
    </div>
</template>

<script>
    import { mapActions } from 'vuex';
    import Form from './components/Form';
    import ModalAlert from '../../modals/ModalAlert';

    export default {
        name: 'RepresentativesCreate',
        components: {
            Form,
            ModalAlert
        },
        methods: {
            ...mapActions('admin.representatives', [ 'create' ]),
            async onSubmit(form) {
                const status = await this.create(form);

                if (status === 200) {
                    this.$bvModal.show('modal-alert');
                }
            },
            ok() {
                this.$router.push({ name: 'admin.representatives.list' });
            },
            close() {
                this.$refs.form.onReset();
            }
        }
    };
</script>

<style scoped>

</style>