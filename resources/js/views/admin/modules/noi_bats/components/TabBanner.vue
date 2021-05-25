<template>
    <div class="tab-content">
        <info-list-banner 
            v-on:select-multiple-banner-img="_onSelectMultipleBannerImg"></info-list-banner>
    </div>
</template>

<script>
    import {
        mapActions
    } from 'vuex';
    import InfoListBanner from './Infos/InfoListBanner';
    import {
        MODULE_MODULE_NOI_BAT
    } from 'store@admin/types/module-types';

    export default {
        name: 'TheTabDataItemBanner',
        components: {
            InfoListBanner
        },
        props: {
            moduleData: {
                type: Object
            }
        },
        methods: {
            ...mapActions(MODULE_MODULE_NOI_BAT, [
                'module_noi_bat_banners'
            ]),
            _onSelectMultipleBannerImg(imgFiles) {
                this.module_noi_bat_banners(imgFiles);
            }
        }
    };
</script>
