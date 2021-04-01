<template>
  <div class="header-image">
      <div class="container">
          <div class="logo d-inline-block">
              <logo></logo>
          </div>
          <div class="banner-image d-inline-block" v-if="bannerUrl">
              <img class="img" :src="bannerUrl" alt="Hình ảnh Phú Cường">
          </div>
      </div>
  </div>
</template>

<script>
	import {mapGetters} from 'vuex';
  import Logo from 'com@front/Logo';

    export default {
        name: 'DefaultBanner',
        components: {
          Logo
        },
        computed: {
        	...mapGetters(['bannerUrl'])
        }
    };
</script>
