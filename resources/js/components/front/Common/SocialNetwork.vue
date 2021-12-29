<template>
  <div class="box-social">
    <h4 class="tit-common clr-blue">Mạng xã hội</h4>
    <div class="list-icon">
      <share-it
        :url="_getUrl"
        :text="_getText"
        :shareConfig="share"
        :targets="_getTargets()"
      ></share-it>
    </div>
  </div>
</template>

<script>
import Vue from 'vue'
import shareIt from 'vue-share-it'
Vue.use(shareIt)
import { fnCheckProp, } from '@app/common/util'

export default {
  name: 'SocialNetwork',
  data() {
    return {
      text: '',
      share: {
        twitter: {
          label: ' ',
          size: 'xs',
          dense: true,
        },
        linkedin: {
          label: ' ',
          size: 'xs',
          color: '#fff',
          backgroundColor: 'black',
          dense: true,
        },
        facebook: {
          label: ' ',
          size: 'xs',
          dense: true,
        },
        whatsapp: {
          label: ' ',
          size: 'xs',
          dense: true,
        },
        reddit: {
          label: ' ',
          size: 'xs',
          dense: true,
        },
      },
      targets: ['twitter', 'facebook', 'linkedin', 'whatsapp', 'reddit'],
    }
  },
  computed: {
    _getUrl() {
      return window.location.origin + window.location.pathname
    },
    _getText() {
      return this.text
    },
  },
  mounted() {
    this.text = document.querySelector('meta[property="og:title"]').content
  },
  methods: {
    _getTargets() {
      if (fnCheckProp(this.$route.meta, 'network')) {
        return this.$route.meta.network
      }

      return this.targets
    },
  },
}
</script>
