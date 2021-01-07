<template>
    <div>
        <b-modal id="modal-confirm"
                 size="lg"
                 centered
                 scrollable
                 no-close-on-backdrop
                 no-close-on-esc
                 :title="title"
                 title-tag="h5"
                 body-class="text-center"
                 hide-footer
                 @close="$emit('close')">
            <div class="d-block my-5">
                <p v-html="message"></p>
            </div>

            <div class="row justify-content-center text-center">
                <button class="btn white-btn-custom mw-9 m-1" size="sm" @click="cancel()">{{ btnCancel }}</button>
                <button class="btn blue-btn-custom mw-9 m-1" size="sm" :disabled="isLoading" @click="$emit('submit')">
                    <b-spinner v-if="isLoading" type="border" class="mr-2" small></b-spinner> {{ btnSubmit }}
                </button>
            </div>
        </b-modal>
    </div>
</template>

<script>
    export default {
        name: 'ModalConfirm',
        props: {
            title: {
                type: String,
                required: true
            },
            message: {
                type: String,
                required: true
            },
            btnCancel: {
                default: 'キャンセル',
                type: String
            },
            btnSubmit: {
                type: String,
                required: true
            }
        },
        methods: {
            cancel() {
                this.$bvModal.hide('modal-confirm');
                this.$emit('close');
            }
        }
    };
</script>

<style scoped>

</style>