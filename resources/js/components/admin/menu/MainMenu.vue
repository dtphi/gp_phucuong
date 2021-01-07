<template>
    <div class="container menu-container">
        <div class="row justify-content-md-center menu-block">
            <div class="col-lg-12">
                <h3 class="menu-logo">
                    <b-img src="/img/login-title.png" alt="Nittoh Mobile System"></b-img>
                </h3>

                <h3 class="menu-title">メインメニュー</h3>

                <div role="tablist" class="accordion">
                    <b-card class="menu-block-item" no-body>
                        <b-card-header role="tab" class="menu-block-item-header">
                            <div @click="$router.push({ name: 'admin.representatives.list' })">
                                <span class="menu-first-icon h2">
                                    <i class="fas fa-user-tie"></i>
                                </span>
                                <h4 class="menu-block-title">営業担当者</h4>
                                <span class="menu-last-icon h3">
                                    <i class="fas fa-chevron-right"></i>
                                </span>
                            </div>
                        </b-card-header>
                    </b-card>

                    <b-card class="menu-block-item" no-body>
                        <b-card-header role="tab" class="menu-block-item-header">
                            <div @click="$router.push({ name: 'admin.stores.list' })">
                                <span class="menu-first-icon h2">
                                    <i class="fas fa-store"></i>
                                </span>
                                <h4 class="menu-block-title">販売店</h4>
                                <span class="menu-last-icon h3">
                                    <i class="fas fa-chevron-right"></i>
                                </span>
                            </div>
                        </b-card-header>
                    </b-card>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'MainMenu'
    };
</script>

<style scoped>

</style>