<template>
  <b-card no-body class="mt-3" style="height: 345px">
    <b-tabs card>
      <info-lasted-tab></info-lasted-tab>
      <info-popular-tab></info-popular-tab>
      <info-author-tab></info-author-tab>
    </b-tabs>
  </b-card>
</template>

<script>
import InfoPopularTab from './InfoPopularTab'
import InfoLastedTab from './InfoLastedTab'
import InfoAuthorTab from './InfoAuthorTab'
export default {
  name: 'TabInfoViewedAndPopular',
  components: {
    InfoPopularTab,
    InfoLastedTab,
    InfoAuthorTab,
  },
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
