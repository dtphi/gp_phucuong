<template>
    <div id="header" class="w-100">
        <div class="header-inner">
            <TheHeaderInner></TheHeaderInner>

            <h2 v-if="header" class="head-title">{{ header }}</h2>
        </div>

        <TheBreadcrumb></TheBreadcrumb>
    </div>
</template>

<script>
    import TheBreadcrumb from './TheBreadcrumb';
    import TheHeaderInner from './TheHeaderInner';

    export default {
        name: 'TheHeader',
        components: {
            TheBreadcrumb,
            TheHeaderInner
        },
        data() {
            return {
                header: ''
            };
        },
        mounted() {
            this.header = this.$route.meta.header;
        }
    };
</script>

<style scoped>

</style>