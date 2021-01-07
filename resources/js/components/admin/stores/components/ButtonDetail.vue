<template>
    <button class="btn white-btn-custom custom-btn" :disabled="isLoading" @click="detail">詳細</button>
</template>

<script>
    import { mapActions } from 'vuex';

    export default {
        name: 'ButtonDetail',
        props: [ 'data', 'index' ],
        methods: {
            ...mapActions('admin.stores', [ 'checkDeleted' ]),
            async detail() {
                const status = await this.checkDeleted(this.data.id);

                switch (status) {
                    case 200:
                        this.$router.push({
                            name: 'admin.stores.update',
                            params: { id: this.data.id }
                        });
                        break;
                    case 410:
                        this.$bvModal.show('modal-alert');
                        break;
                }
            }
        }
    };
</script>

<style scoped>

</style>