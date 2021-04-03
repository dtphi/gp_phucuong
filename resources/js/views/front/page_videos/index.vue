<template>
  <main id="video" class="py-2">
        <div class="container">
            <navigation-main :menu-items="navMainLists"></navigation-main>
            <b-row class="mt-3">
                <b-col cols="3">
                    <side-bar class="aside"></side-bar>
                </b-col>
                <b-col cols="9">
                    <div class="list-videos">
                        <the-video-item class="figure" v-for="item in 20" :key="item"></the-video-item>
                    </div>
                </b-col>
            </b-row>
        </div>
  </main>
</template>

<script>
	import{
      mapGetters,
      mapActions
  } from 'vuex';
  import NavigationMain from 'com@front/Navigation/Main';
  import SideBar from 'com@front/SideBar';
  import TheVideoItem from './components/TheVideoItem';

    export default {
        name: 'VideoPage',
        components: {
            NavigationMain,
            SideBar,
            TheVideoItem
        },
        data() {
            return {

            }
        },
        computed: {
            ...mapGetters(['navMainLists'])
        },
    }
</script>

<style lang="scss">
    @import './video-styles.scss'
</style>