<template>
  <figure class="figure">
      <img :src="cfApp.banner" class="rounded img" alt="Giáo Phận Phú Cường">
      <figcaption class="figure-caption">{{captionTitle}}</figcaption>
  </figure>
</template>

<script>
	import {mapState} from 'vuex';

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
        	...mapState(['cfApp'])
        }
    }
</script>

<style lang="scss" scoped>
</style>
