<template>
  <transition>
    <img :src="logoUrl" alt="Logo Phú Cường">
  </transition>
</template>

<script>
	import {mapGetters} from 'vuex';

    export default {
        name: 'Logo',
        computed: {
        	...mapGetters(['logoUrl'])
        }
    };
</script>
