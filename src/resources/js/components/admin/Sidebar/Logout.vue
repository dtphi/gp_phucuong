<template>
  <li class="nav-item">
    <a @click="logout()" href="#" class="nav-link" title="Logout Admin">
      <i class="nav-icon fas fa-file"></i>
      <p>Logout</p>
    </a>
  </li>
</template>

<script>
	import {mapGetters, mapActions} from 'vuex';
    export default {
        name: 'LogoutSideBar',
        computed: {
            ...mapGetters('auth', ['authenticated'])
        },
        methods: {
            ...mapActions({
                signOut: 'auth/signOut',
                redirectLogout: 'auth/redirectLogoutSuccess'
              }),
            async submit () {
              await this.signOut();
              if (!this.authenticated) {
              	this.redirectLogout();
              }
            },
            logout() {
                this.submit();
            }
        }
    };
</script>