<template>
  <router-view />
</template>

<script>
import {mapGetters} from 'vuex';

export default {
  name: 'App',
  computed: {
      ...mapGetters('auth', ['authenticated']),
  },
  updated() {
    if (this.authenticated == false) {
      this.$router.push('/login').catch(()=>{
      });
    }
  },
  created() {
    const currentPath = this.$router.history.current.path;

    if (this.authenticated == false) {
      this.$router.push('/login').catch(()=>{
      });
    }

    if (currentPath === '/' && this.authenticated == true) {
      this.$router.push('/dashboard');
    }
  },
};
</script>

<style src="./styles/theme.scss" lang="scss" />
