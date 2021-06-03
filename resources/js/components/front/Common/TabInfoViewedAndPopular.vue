<template>
    <b-card no-body class="mt-3" style="height: 343px">
        <b-tabs card>
            <info-lasted-tab></info-lasted-tab>
            <info-popular-tab></info-popular-tab>
        </b-tabs>
    </b-card>
</template>

<script>
    import InfoPopularTab from './InfoPopularTab';
    import InfoLastedTab from './InfoLastedTab';

    export default {
        name: 'TabInfoViewedAndPopular',
        components: {
            InfoPopularTab,
            InfoLastedTab
        }
    }
</script>

<style lang="scss">
    .tab-bar {
        .row-item-3 {
            span {
                &:nth-child(2n) {
                    width: 85%;
                    text-align: left;
                }
            }
        }
    }
</style>
