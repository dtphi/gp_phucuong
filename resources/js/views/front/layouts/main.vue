<template>
  <div class="wrapper-container">
  	<default-header></default-header>
		<slot></slot>
	  <Footer />
  </div>
</template>

<script>

	import DefaultHeader from 'com@front/Header/Default';
	import Footer from 'com@front/Footer';

	export default {
		name: 'MainLayout',
		components: {
			DefaultHeader,
			Footer,
		}
	};
</script>

<style lang="scss">
	.wrapper-container {
		font-size: 14px;

		// Text overflow ellipsis on two lines
		.ellipsis-three-lines {
			display: -webkit-box;
			-webkit-line-clamp: 3;
			-webkit-box-orient: vertical;
			overflow: hidden;
			text-overflow: ellipsis;
		}

		.ellipsis-two-lines {
			display: -webkit-box;
			-webkit-line-clamp: 2;
			-webkit-box-orient: vertical;
			overflow: hidden;
			text-overflow: ellipsis;
		}
	}

	.img {
		width: 100%;
		height: 100%;
		object-fit: cover;
	}

	h4, p {
		margin-bottom: 0;
	}
</style>