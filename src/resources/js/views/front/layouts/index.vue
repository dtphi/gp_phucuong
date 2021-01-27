<template>
  <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
  	<Header />
		<div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
	  	<slot></slot>
	  </div>
	  <Footer />
  </div>
</template>

<script>
	import Header from 'com@front/Header';
	import Footer from 'com@front/Footer';

    export default {
        name: 'Layout',
        components: {
        	Header,
        	Footer
        }
    };
</script>
