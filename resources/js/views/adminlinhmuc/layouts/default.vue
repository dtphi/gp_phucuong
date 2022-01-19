<template>
  <v-app dark>
    <v-main>
      <v-container>
        <Nuxt />
      </v-container>
    </v-main>
    <v-footer
      class="v-footer justify-center text-center"
      :absolute="fixed"
      app
    >
      <span
      >Copyright &copy; {{ new Date().getFullYear() }} By Giáo Phận Phú Cường, All rights reserved. Powered by<a href="/"> Catholic.App.Team</a>
        <br><div>Version 1.0.0.0</div>
      </span>
    </v-footer>
  </v-app>
</template>

<script>
export default {
  data () {
    return {
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
  }
}
</script>
