<template>
    <div class="tab-content">
        <info-list-image 
            v-on:select-multiple-banner-img="_onSelectMultipleBannerImg"></info-list-image>
    </div>
</template>

<script>
import {
  mapActions,
} from 'vuex'
import InfoListImage from './AlbumsImage/InfoListImage'
import {
  MODULE_MODULE_ALBUMS_ADD,
} from 'store@admin/types/module-types'

export default {
  name: 'TheTabAlbumsImage',
  components: {
    InfoListImage,
  },
  props: {
    moduleData: {
      type: Object,
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_ALBUMS_ADD, [
      'pushInfoAlbumsImage'
    ]),
    _onSelectMultipleBannerImg(imgFiles) {
      this.pushInfoAlbumsImage(imgFiles)
    },
  },
}
</script>
