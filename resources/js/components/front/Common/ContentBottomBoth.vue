<template>
    <div id="content-bottom-both">
        <module-page-banner-list></module-page-banner-list>
        <module-noi-bat></module-noi-bat>
    </div>
</template>

<script>
    import ModuleNoiBat from 'v@front/modules/noi_bats';
    import ModulePageBannerList from 'v@front/modules/page_banner_lists';

    export default {
        name: 'ContentBottomBoth',
        components: {
            ModuleNoiBat,
            ModulePageBannerList
        },
        data() {
            return {
            }
        }
    }
</script>
