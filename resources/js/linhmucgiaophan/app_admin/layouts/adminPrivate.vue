<template>
  <v-app dark>
    <v-navigation-drawer
      v-model="drawer"
      :mini-variant="miniVariant"
      :clipped="clipped"
      fixed
      app
    >
      <v-list>
        <v-list-item
          v-for="(item, i) in items"
          :key="i"
          :to="item.to"
          router
          exact
        >
          <v-list-item-action>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title v-text="item.title" />
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
    <v-app-bar
      :clipped-left="clipped"
      fixed
      app
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
      <v-btn
        icon
        @click.stop="miniVariant = !miniVariant"
      >
        <v-icon>mdi-{{ `chevron-${miniVariant ? 'right' : 'left'}` }}</v-icon>
      </v-btn>
      <v-btn
        icon
        @click.stop="clipped = !clipped"
      >
        <v-icon>mdi-application</v-icon>
      </v-btn>
      <v-btn
        icon
        @click.stop="fixed = !fixed"
      >
        <v-icon>mdi-minus</v-icon>
      </v-btn>
      <v-toolbar-title v-text="title" />
      <v-spacer />
      <v-btn
        icon
        @click.stop="rightDrawer = !rightDrawer"
      >
        <v-icon>mdi-menu</v-icon>
      </v-btn>
      <v-btn
        icon
        @click="_signOut"
      >
        <v-icon>mdi-logout</v-icon>
      </v-btn>
    </v-app-bar>
    <v-main>
      <v-container>
        <transition name="main_page">
          <Nuxt />
        </transition>
      </v-container>
    </v-main>
    <v-navigation-drawer
      v-model="rightDrawer"
      :right="right"
      temporary
      fixed
    >
      <v-list>
        <v-list-item @click.native="right = !right">
          <v-list-item-action>
            <v-icon light>
              mdi-repeat
            </v-icon>
          </v-list-item-action>
          <v-list-item-title>Switch drawer (click me)</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
    <v-footer
      :absolute="!fixed"
      app
    >
      <span>&copy; {{ new Date().getFullYear() }}te</span>
    </v-footer>
  </v-app>
</template>

<script>
import { getAuth, signOut } from 'firebase/auth'
const firebaseAuth = getAuth()

export default {
  data () {
    return {
      clipped: false,
      drawer: false,
      fixed: false,
      items: [
        {
          icon: 'mdi-apps',
          title: 'Quản trị',
          to: '/linhmucadmin/dashboard'
        },
        {
          icon: 'mdi-home',
          title: 'Giáo Xứ',
          to: '/linhmucadmin/giaoxu'
        },
        {
          icon: 'mdi-account',
          title: 'Linh Mục',
          to: '/linhmucadmin/linhmuc'
        }
      ],
      miniVariant: false,
      right: true,
      rightDrawer: false,
      title: 'Linh Mục Giáo Phận'
    }
  },
  methods: {
    _signOut () {
      signOut(firebaseAuth)
    }
  }
}
</script>
