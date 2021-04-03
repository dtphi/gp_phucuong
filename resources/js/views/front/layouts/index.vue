<template>
  <div class="wrapper-container">
  	<Header />
	<Video />
	<Footer />
  </div>
</template>

<script>

	import Header from 'com@front/Header';
	import Footer from 'com@front/Footer';
	import Home from '../home/index';
	import Video from '../video/index';

	export default {
		name: 'Layout',
		components: {
			Header,
			Footer,
			Home,
			Video
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

		
		word-break: break-word;
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