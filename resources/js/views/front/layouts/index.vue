<template>
  <div class="wrapper-container">
  	<Header />
		<Home />
	  <Footer />
  </div>
</template>

<script>

	import Header from 'com@front/Header';
	import Footer from 'com@front/Footer';
	import Home from '../home/index';

    export default {
        name: 'Layout',
        components: {
        	Header,
					Footer,
					Home,
        }
    };
</script>

<style lang="scss">
	.wrapper-container {
		width: 100%;
		position: absolute;
		top: 0;

		// container page
    .container {
			max-width: 1047px;
			margin: 0 auto;
			padding: 0;
    }

		// Aside title heade
		.AsideTitle {
			border-top: 3px solid #FFA204;
			margin-top: 27px;
			margin-bottom: 5px;
			padding-top: 15px;
			position: relative;
			.name {
					background: #FFA204;
					border-radius: 0;
					color: #000;
					font-size: 14px;
					font-weight: 700;
					padding: 7px 15px;
					position: relative;
					text-transform: uppercase;
					top: -27px;
					&::before {
							content: "";
							position: absolute;
							right: -18px;
							background-color: #fff;
							height: 100%;
							width: 20px;
							top: 0;
					}
			}
		}

		// col image 2 column: left image , right text
		.col-image-news {
			color: #000;
			font-size: 0;
			display: block;
			margin-bottom: 14px;
			&:hover {
				opacity: .7;
			}
			span {
				display: inline-block;
				font-size: 13px;
				vertical-align: top;
				&:first-child {
					width: 30%;
					img {
						width: 100%;
					}
				}
				&:last-child {
					width: 70%;
					padding: 0 14px;
				}
			}
		}

		// Icon clock and eyes
		.icon-small {
			position: relative;
			padding-left: 16px;
			&::before {
					content: '';
					background-size: 100%;
					background-repeat: no-repeat;
					width: 11px;
					height: 12px;
					position: absolute;
					top: 50%;
					left: 0;
					transform: translateY(-50%);
			}
			
			&.icon-clock {
				margin-right: 10px;
				&::before {
					background-image: url('../assets/img/icon_clock.png');
				}
				&.icon-white {
					&::before {
						background-image: url('../assets/img/icon_clock_white.png');
					}
				}
			}
			&.icon-eyes {
				&::before {
					background-image: url('../assets/img/icon_eyes.png');
				}
				&.icon-white {
					&::before {
						background-image: url('../assets/img/icon_eyse_white.png');
					}
				}
			}
		}

		a {
			&:hover {
				text-decoration: none;
			}
		}

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
</style>