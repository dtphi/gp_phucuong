<template>
	<div id="content">
      	<div class="container-fluid">
			  	<keep-alive>
					<component v-bind:is="currentModule" class="tab"></component>
				</keep-alive>
      	</div>
  	</div>
</template>

<script>
    export default {
        name: 'ExtensionModuler',
        components: {
            'module-home-banners': () => import('./home_banners'),
			'module-category-left-side-bars': () => import('./category_left_side_bars'),
			'module-category-icon-side-bars': () => import('./category_icon_side_bars'),
			'module-thong-baos': () => import('./thong_baos'),
        },
		computed: {
          currentModule: function() {
			  	let moduleName = this.$route.params.pathMatch;
            	return "module-" + moduleName.toLowerCase();
          }
        }
    };
</script>
