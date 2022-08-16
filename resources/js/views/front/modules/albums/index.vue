<template>
  <div id="album-module" v-if="Object.keys(_getAlbums).length">
    <h4 class="tit-detail">ALBUM HÌNH</h4>
    <b-row cols="1" cols-sm="2" cols-md="2" cols-lg="3">
      <b-col v-for="(album, idx) in _getAlbums" :key="idx">
        <img
            @click="_showAlbumModal(idx)"
            :src="album.image"
          />
      </b-col>
    </b-row>

    <!-- Modal -->
    <b-modal size="xl" scrollable no-close-on-backdrop id="gp_phucuong-album-list" hide-footer>
      <template #modal-title>
        <code>XEM ALBUM HÌNH</code>
      </template>
      <div class="d-block text-center">
        <div class="docs-galley mb-3" style="position: relative">
          <ul class="docs-pictures clearfix" id="gp_phucuong-album-images">
            <li v-for="album in _getImageList" :key="album.id">
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
    </b-modal>
  </div>
</template>

<script>
import { mapState, } from 'vuex'
import 'viewerjs/dist/viewer.css'
import Viewer from 'viewerjs'

export default {
  name: 'ModuleAlbumModal',
  data() {
    return {
      fullPage: true,
      viewer: false,
      idx: 0
    }
  },
  computed: {
    ...mapState({
      lastAlbum: state => state.cfApp.setting.lastAlbum,
    }),
    _getAlbums() {
      return this.lastAlbum
    },
    _getImageList() {
      return this.lastAlbum[this.idx]['albums']
    }
  },
  methods: {
    _showSlide() {
      this.$bvModal.hide('gp_phucuong-album-list')
      new Viewer(document.getElementById('gp_phucuong-album-images'), {
        url: 'data-original',
        backdrop: true,
      })
      return;
    },
    _showAlbumModal(idx) {
      this.$data.idx = idx
      this.$bvModal.show('gp_phucuong-album-list')
    }
  },
}
</script>

<style>
#gp_phucuong-album-list {
  background: silver !important;
}
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
