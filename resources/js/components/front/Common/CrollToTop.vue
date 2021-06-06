<template>
  <go-top 
    :max-width="$options.settings.maxWidth"
    :boundary="$options.settings.boundary"
    :size="$options.settings.size"
    :bottom="$options.settings.bottom"
    bg-color="#0071bc"
    ></go-top>
</template>

<script>
import GoTop from '@inotom/vue-go-top';

export default {
  components: {
    GoTop
  },
  settings: {
      maxWidth: 314,
      boundary: 100,
      size: 57,
      bottom: 60,
  }
}
</script>