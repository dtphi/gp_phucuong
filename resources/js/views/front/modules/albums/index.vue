<template>
  <div id="album-module" v-if="Object.keys(_getAlbums).length">
    <h4 class="tit-detail">ALBUM HÌNH</h4>
    <div class="docs-galley mb-3" style="position: relative">
      <ul class="docs-pictures clearfix" id="images">
        <li v-for="album in _getAlbums" :key="album.id">
          <img
            class="thumb"
            @click="_showSlide()"
            :data-original="album.image"
            :src="album.image_thumb"
          />
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { mapState, } from 'vuex'
import 'viewerjs/dist/viewer.css'
import Viewer from 'viewerjs'

export default {
  name: 'ModuleAlbum',
  data() {
    return {
      fullPage: true,
      viewer: false,
    }
  },
  computed: {
    ...mapState({
      lastAlbum: state => state.cfApp.setting.lastAlbum,
    }),
    _getAlbums() {
      return this.lastAlbum
    },
  },
  methods: {
    _showSlide() {
      if (this.viewer) {
        return
      }
      new Viewer(document.getElementById('images'), {
        url: 'data-original',
      })
      this.viewer = true
    },
  },
}
</script>

<style>
.docs-pictures {
  list-style: none;
  margin: 0;
  padding: 0;
}
.docs-pictures > li {
  border: 1px solid transparent;
  float: left;
  height: calc(100% / 4);
  margin: 0 -1px -1px 0;
  overflow: hidden;
  width: calc(100% / 4);
}
.docs-pictures > li > img {
  cursor: -webkit-zoom-in;
  cursor: zoom-in;
  width: 100%;
}
.viewer-backdrop {
  background-color: rgba(0, 0, 0, 0.75) !important;
}
</style>