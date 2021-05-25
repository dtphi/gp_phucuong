<template>
    <div class="tab-content">
        <info-list-carousel 
            v-on:select-multiple-banner-img="_onSelectMultipleBannerImg"></info-list-carousel>
    </div>
</template>

<script>
    import {
        mapActions
    } from 'vuex';
    import InfoListCarousel from './SpecialInfoCarousels/InfoListCarousel';
    import {
        MODULE_MODULE_NOI_BAT
    } from 'store@admin/types/module-types';

    export default {
        name: 'TheTabSpecialInfoCarousel',
        components: {
            InfoListCarousel
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
