<template>
    <button type="button" class="btn btn-default mb-3" @click="showModalEdit(userId)"><font-awesome-icon icon="edit"  size="xs" /></button>
</template>

<script>
    import { mapActions } from 'vuex';

    export default {
        name: 'ButtonEdit',
        props: {
            userId: { type: Number, dafault: 0 },
            iconName: { type: String, default: '' },
            className: { type: String, default: '' }
        },
        data() {
            return {
            };
        },
        methods: {
            ...mapActions('user/modal', [
                'showModalEdit'
            ]),
        }
    };
</script>