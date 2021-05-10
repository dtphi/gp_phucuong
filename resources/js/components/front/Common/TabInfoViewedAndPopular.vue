<template>
    <b-card no-body class="mt-3">
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
</style>