<template>
  <figure class="figure">
      <img :src="bannerUrl" class="rounded img" alt="Giáo Phận Phú Cường">
      <figcaption class="figure-caption">{{captionTitle}}</figcaption>
  </figure>
</template>

<script>
	import {mapGetters} from 'vuex';

    export default {
        name: 'TheItemPage',
        props: {
        	captionTitle: {
        		default: '>>>>> Xem tin tức'
        	}
        },
        components: {
        },
        data() {
            return {
            }
        },
        computed: {
        	...mapGetters(['bannerUrl'])
        }
    }
</script>

<style lang="scss" scoped>
</style>
