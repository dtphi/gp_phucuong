<template>
  <div class="header-image">
      <div class="container">
          <div class="logo d-inline-block">
            <b-row>
              <b-col cols="3">
                <logo></logo>
              </b-col>
              <b-col cols="9">
                <h2>Giáo phận phú cường</h2>
                <h4>Muối men cho đời</h4>
              </b-col>
            </b-row>
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
