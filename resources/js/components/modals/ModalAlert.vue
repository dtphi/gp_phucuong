<template>
    <div>
        <b-modal id="modal-alert"
                 size="lg"
                 centered
                 scrollable
                 no-close-on-backdrop
                 no-close-on-esc
                 :title="title"
                 title-tag="h5"
                 body-class="text-center"
                 hide-footer
                 ok-only
                 @close="$emit('close')">
            <div class="d-block my-5">
                <p v-html="message"></p>
            </div>

            <div class="row justify-content-center text-center w-100">
                <button class="btn blue-btn-custom mw-9 m-3" size="sm" @click="ok()">{{ btnOk }}</button>
            </div>
        </b-modal>
    </div>
</template>

<script>
    export default {
        name: 'ModalAlert',
        props: {
            title: {
                type: String,
                required: true
            },
            message: {
                type: String,
                required: true
            },
            btnOk: {
                default: '閉じる',
                type: String
            }
        },
        methods: {
            ok() {
                this.$bvModal.hide('modal-alert');
                this.$emit('ok');
            }
        }
    };
</script>

<style scoped>

</style>