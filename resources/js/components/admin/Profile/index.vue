<template>
  <li class="nav-item dropdown">
      <a v-if="isShowLogOut" class="nav-link" data-toggle="dropdown" href="#">
        <font-awesome-icon icon="user" size="xs" />
      </a>
      <div v-else-if="user.id" class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">{{ user.name }}</span>
        <div class="dropdown-divider"></div>
        <span class="dropdown-item dropdown-header">
          <logout></logout>
        </span>
        <div class="dropdown-divider"></div>
      </div>
      <a v-else class="nav-link" data-toggle="dropdown" href="#">
        <font-awesome-icon icon="user" size="xs" />
      </a>
  </li>
</template>

<script>
import { mapState } from "vuex";
import { MODULE_AUTH } from "store@admin/types/module-types";
import Logout from "../Sidebar/Logout";

export default {
  name: "UserLogin",
  components: {
    Logout,
  },
  computed: {
    ...mapState(MODULE_AUTH, {
      isShowLogOut: (state) => state.authenticated,
      user: (state) => state.user,
    }),
  },
};
</script>
