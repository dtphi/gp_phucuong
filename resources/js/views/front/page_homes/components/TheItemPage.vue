<template>
  <figure class="figure" @click="_redirectPage()">
      <img v-lazy="pageItem.img" class="rounded img" alt="Giáo Phận Phú Cường">
      <figcaption class="figure-caption" @click="_redirectPage()">{{pageItem.title}}</figcaption>
  </figure>
</template>

<script>
	import {
        mapGetters
    } from 'vuex';
    import {
        fn_redirect_url
    } from '@app/api/utils/fn-helper'

    export default {
        name: 'TheItemPage',
        props: {
            pageItem: {},
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
        },
        methods: {
            _redirectPage() {
                return fn_redirect_url(this.pageItem.href);
            }
        }
    }
</script>

<style lang="scss" scoped>
    
</style>
