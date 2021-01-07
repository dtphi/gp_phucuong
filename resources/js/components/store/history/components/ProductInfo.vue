<template>
    <div>
        <p class="mb-0">{{ data.manufacturer_name }}</p>
        <p class="font-weight-bold mb-0">{{ data.product_name }}</p>
        <p class="font-weight-bold mb-0">{{ data.model }}</p>
        <p class="price-sm">{{ data.unit_price }}</p>
        <button class="btn white-btn-custom custom-btn" :disabled="isLoading" @click="detail">再発注</button>
    </div>
</template>

<script>
    export default {
        name: 'ProductInfo',
        props: [ 'data' ],
        methods: {
            detail() {
                this.$router.push({
                    name: 'store.history.purchase.detail',
                    params: { id: this.data.id }
                });
            }
        }
    };
</script>

<style scoped>

</style>