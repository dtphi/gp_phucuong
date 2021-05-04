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

		.bg-blue { background-color: #00d9ff; }
		.bg-sliver { background-color: #cdcdcd; }
		.bg-red { background-color: #ed1c24; }
		.bg-green { background-color: #1ced38; }
		.bg-orange { background-color: #ff9900; }
		.bg-pink { background-color: #ed1c96; }
		.bg-grow { background-color: #57070793; }

		.clr-blue { color: #00d9ff; }
		.clr-orange { color: #ff9900; }

		.box-social {
			.list-icon {
				font-size: 0;

				a {
					display: inline-block;
					width: calc(100% / 5);
				}

				.nav-tabs {
					.nav-link {
						color: #000;
					}
				}
			}
		}

		.box-care {
			#email {
				background-color: #CCCCCC;
				padding: 6px;
				border-radius: 4px;
				width: 100%;
				outline: 0;
			}

			.btn {
				background-color: #ED1C24;
				color: #ffffff;
				padding: 4px 14px;
				font-weight: bold;
			}

			.text-download {
				color: #ff0000;
				font-weight: 700;
				text-transform: uppercase;
				text-align: center;
				vertical-align: middle;
			}
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