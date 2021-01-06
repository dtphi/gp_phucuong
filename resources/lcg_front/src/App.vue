<template>
   <AppLayout></AppLayout>
</template>
<script>
// @ is an alias to /src
import  {mapGetters}  from  'vuex'
import AppLayout from '@/components/Layouts/App'

export default {
  name: 'App',
  components: {AppLayout},
  computed: {
    ...mapGetters(['cfApp'])
  }
}
</script>
<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
</style>
