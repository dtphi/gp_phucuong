<template>
  <figure class="figure" @click="_redirectPage()">
      <img v-lazy="_getImgUrl()" class="rounded img" alt="Giáo Phận Phú Cường">
      <figcaption class="figure-caption" @click="_redirectPage()">{{pageItem.title}}</figcaption>
  </figure>
</template>

<script>
	import {
        mapGetters
    } from 'vuex';
    import {
        fn_redirect_url,
        fn_get_base_url
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
            },
            _getImgUrl() {
                return fn_get_base_url() + this.pageItem.img;
            }
        }
    }
</script>

<style lang="scss" scoped>
    
</style>
