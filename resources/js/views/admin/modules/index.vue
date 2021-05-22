<template>
	<div id="content">
      	<div class="container-fluid">
			  	<keep-alive>
					<component v-bind:is="currentModule"></component>
				</keep-alive>
      	</div>
  	</div>
</template>

<script>
    export default {
        name: 'ExtensionModuler',
        components: {

			'module-category-icon-side-bars': () => import('./category_icon_side_bars'),
            
			'module-category-left-side-bars': () => import('./category_left_side_bars'),

			'module-home-banners': () => import('./home_banners'),

			'module-loi-chuas': () => import('./loi_chuas'),
			
			'module-thong-baos': () => import('./thong_baos'),

			'module-tin-giao-hoi-viet-nams': () => import('./tin_giao_hoi_viet_nams'),

			'module-tin-giao-hois': () => import('./tin_giao_hois'),

			'module-tin-giao-phans': () => import('./tin_giao_phans'),

			'module-van-kiens': () => import('./van_kiens'),

			'module-noi-bats': () => import('./noi_bats'),

        },
		computed: {
          currentModule: function() {
			  	let moduleName = this.$route.params.pathMatch;
            	return "module-" + moduleName.toLowerCase();
          }
        }
    };
</script>
