<template>
    <div class="bg-style-wrap">
        <TheHeader v-if="$route.meta.show.header || false"></TheHeader>
        <slot></slot>
        <TheFooter v-if="$route.meta.show.footer"></TheFooter>
    </div>
</template>

<script>
    import TheHeader from './_partials/TheHeader';
    import TheFooter from './_partials/TheFooter';

    export default {
        name: 'AuthLayout',
        components: {
            TheHeader,
            TheFooter
        }
    };
</script>

<style scoped>

</style>