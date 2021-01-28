<template>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar elevation-4">
      <!-- Brand Logo -->
      <a href="#!" class="brand-link">
        <img src="/administrator/img/logo.png" alt="Diocese of Phu Cuong Logo" class="brand-image">
        <span class="brand-text font-weight-bold">Diocese of Phu Cuong</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-4">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item has-treeview menu-open">
              <a href="/admin/users" class="nav-link active" title="Users">
                <i class="nav-icon fas fa-user"></i>
                <p>Users <i class="right fas fa-angle-left"></i></p>
              </a>
            </li>
            <li class="nav-item has-treeview">
              <a href="/admin/news-groups" class="nav-link" title="News Group">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  News Group
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/news" class="nav-link" title="News">
                <i class="nav-icon fas fa-file"></i>
                <p>News</p>
              </a>
            </li>
            
            <Logout v-if="authenticated"/>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex';
  import Logout from './Logout';

    export default {
        name: 'Sidebar',
        components: {
          Logout
        },
        computed: {
            ...mapGetters('auth', ['authenticated'])
        },
    };
</script>