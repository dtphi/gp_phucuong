<template>
  <div class="header-image">
      <div class="container">
          <div class="logo d-inline-block">
              <img :src="cfApp.logo" alt="Logo Phú Cường">
          </div>
          <div class="banner-image d-inline-block">
              <img class="img" :src="cfApp.banner" alt="Hình ảnh Phú Cường">
          </div>
      </div>
  </div>
</template>

<script>
	import {mapState} from 'vuex';

    export default {
        name: 'DefaultBanner',
        computed: {
        	...mapState(['cfApp'])
        }
    };
</script>
