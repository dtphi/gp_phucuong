<template>
  <div class="header-image">
      <div class="container">
          <div class="logo d-inline-block">
              <logo></logo>
          </div>
          <div class="banner-image d-inline-block">
              <img class="img" :src="cfApp.banner" alt="Hình ảnh Phú Cường">
          </div>
      </div>
  </div>
</template>

<script>
	import {mapState} from 'vuex';
  import Logo from 'com@front/Logo';

    export default {
        name: 'DefaultBanner',
        components: {
          Logo
        },
        computed: {
        	...mapState(['cfApp'])
        }
    };
</script>
