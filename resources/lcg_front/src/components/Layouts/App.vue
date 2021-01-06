<template>
  <div>
    <Header></Header>
    <router-view/>
    <LeftSideBar></LeftSideBar>
    <Footer></Footer>
  </div>
</template>
<script>
import  {mapGetters}  from  'vuex'
import Header from '@/components/Headers/Default'
import Footer from '@/components/Footers/Footer'
import LeftSideBar from '@/components/LeftSideBars/Default'

export default {
  name: 'App',
  components: {Header, LeftSideBar, Footer},
  computed: {
    ...mapGetters(['cfApp'])
  }
}
</script>
