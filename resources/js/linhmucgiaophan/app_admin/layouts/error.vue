<template>
  <v-app dark>
    <h1 v-if="error.statusCode === 404">
      {{ pageNotFound }}
    </h1>
    <h1 v-else>
      {{ otherError }}
    </h1>
    <NuxtLink to="/linhmucadmin">
      Home page
    </NuxtLink>
    <v-footer
      justify="center"
      align="center"
      :absolute="!fixed"
      app
    >
      <span
        justify="center"
        align="center"
      >Copyright &copy; {{ new Date().getFullYear() }} By Giáo Phận Phú Cường, All rights reserved. Powered by<a href="/"> Catholic.App.Team</a><br>Version 1.0.0.0</span>
    </v-footer>
  </v-app>
</template>

<script>
export default {
  layout: 'empty',
  props: {
    error: {
      type: Object,
      default: null
    }
  },
  data () {
    return {
      pageNotFound: '404 Not Found',
      otherError: 'An error occurred',
      clipped: false,
      drawer: false,
      fixed: false,
      items: [
        {
          icon: 'mdi-apps',
          title: 'Welcome',
          to: '/linhmucadmin'
        }
      ],
      miniVariant: false,
      right: true,
      rightDrawer: false,
      title: 'Vuetify.js'
    }
  },
  head () {
    const title =
      this.error.statusCode === 404 ? this.pageNotFound : this.otherError
    return {
      title
    }
  }
}
</script>

<style lang="scss" scoped>
h1 {
  font-size: 20px;
}
</style>
