<template>
  <div id="container">
    <notifications group="common-update"></notifications>
  	
  	<main-header></main-header>

		<left-side-bar></left-side-bar>

		<slot></slot>
			        
		<main-footer></main-footer>

		<v-dialog/>
		<modals-container/>
  </div>
</template>

<script>
	import MainHeader from 'com@admin/Header';
	import MainFooter from 'com@admin/Footer';
	import LeftSideBar from 'com@admin/Sidebar/LeftSideBar';
  export default {
      name: 'DefaultLayout',
      components: {
      	MainHeader,
      	LeftSideBar,
      	MainFooter
      },

      mounted() {
      	console.log('mounted default layout')
      	
      	require('../assets/javascript/cms.common');
      }
  };
</script>

<style lang="css" scoped>
    @import '../assets/javascript/bootstrap/css/bootstrap.css';
    @import '../assets/javascript/font-awesome/css/font-awesome.min.css';
    @import '../assets/stylesheet/stylesheet.css';
</style>
