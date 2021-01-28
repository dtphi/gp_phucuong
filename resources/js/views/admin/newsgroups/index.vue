<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <Breadcrumb />

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
          <section class="col-lg-12 connectedSortable">
            <div class="card user-lst">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-user mr-2"></i>
                  Users List
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  <li class="nav-item has-treeview menu-open">
                    <a href="#!" class="nav-link" title="Cat 01 v1">
                      <i class="fas fa-plus nav-icon"></i>
                      <p>Cat 01 v1 <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item has-treeview menu-open">
                        <a href="#!" class="nav-link" title="Cat 01 v2">
                          <i class="fas fa-minus nav-icon"></i>
                          <p>Cat 01 v2 <i class="right fas fa-caret-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                          <li class="nav-item">
                            <a href="#!" class="nav-link" title="Cat 01 v3">
                              <i class="fas fa-ellipsis-h nav-icon"></i>
                              <p>Cat 01 v3</p>
                            </a>
                          </li>
                          <li class="nav-item">
                            <a href="#!" class="nav-link" title="Cat 02 v3">
                              <i class="fas fa-ellipsis-h nav-icon"></i>
                              <p>Cat 02 v3</p>
                            </a>
                          </li>
                          <li class="nav-item">
                            <a href="#!" class="nav-link" title="Cat 03 v3">
                              <i class="fas fa-ellipsis-h nav-icon"></i>
                              <p>Cat 03 v3</p>
                            </a>
                          </li>
                        </ul>
                      </li>
                      <li class="nav-item">
                        <a href="#!" class="nav-link" title="Cat 02 v2">
                          <i class="fas fa-minus nav-icon"></i>
                          <p>Cat 02 v2</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#!" class="nav-link" title="Cat 03 v2">
                          <i class="fas fa-minus nav-icon"></i>
                          <p>Cat 03 v2</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item has-treeview">
                    <a href="#!" class="nav-link" title="Cat 02 v1">
                      <i class="nav-icon fas fa-plus"></i>
                      <p>
                        Cat 02 v1
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="#!" class="nav-link" title="Group v1">
                          <i class="fas fa-minus nav-icon"></i>
                          <p>Group v1</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#!" class="nav-link" title="Group v2">
                          <i class="fas fa-minus nav-icon"></i>
                          <p>Group v2</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#!" class="nav-link" title="Group v3">
                          <i class="fas fa-minus nav-icon"></i>
                          <p>Group v3</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="#!" class="nav-link" title="Cat 03 v1">
                      <i class="nav-icon fas fa-plus"></i>
                      <p>Cat 03 v1</p>
                    </a>
                  </li>
                  <li class="nav-item has-treeview">
                    <a href="#!" class="nav-link" title="Cat 04 v1">
                      <i class="fas fa-plus nav-icon"></i>
                      <p>Cat 04 v1 <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="#!" class="nav-link" title="Cat 04 v2">
                          <i class="fas fa-minus nav-icon"></i>
                          <p>Cat 04 v2</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#!" class="nav-link" title="Cat 05 v2">
                          <i class="fas fa-minus nav-icon"></i>
                          <p>Cat 05 v2</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#!" class="nav-link" title="Cat 06 v2">
                          <i class="fas fa-minus nav-icon"></i>
                          <p>Cat 06 v2</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item has-treeview">
                    <a href="#!" class="nav-link" title="Cat 05 v1">
                      <i class="nav-icon fas fa-plus"></i>
                      <p>
                        Cat 05 v1
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="#!" class="nav-link" title="Group v4">
                          <i class="far fa-minus nav-icon"></i>
                          <p>Group v4</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#!" class="nav-link" title="Group v5">
                          <i class="far fa-minus nav-icon"></i>
                          <p>Group v5</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#!" class="nav-link" title="Group v6">
                          <i class="far fa-minus nav-icon"></i>
                          <p>Group v6</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                </ul>
                

                <div class="treeview-animated mx-4 my-4">
                  <ul class="treeview-animated-list">
                    <li class="treeview-animated-items">
                      <a class="treeview-animated-items-header">
                        <i class="fas fa-plus"></i>
                        <span>Mail</span>
                      </a>
                      <ul class="nested">
                        <li>
                          <div class="treeview-animated-element">Offers</div>
                        </li>
                        <li>
                          <div class="treeview-animated-element">Contacts</div>
                        </li>
                        <li class="treeview-animated-items">
                          <a class="treeview-animated-items-header">
                            <i class="fas fa-plus"></i>
                            <span>Calendar</span></a>
                          <ul class="nested">
                            <li>
                              <div class="treeview-animated-element">Deadlines</div>
                            </li>
                            <li>
                              <div class="treeview-animated-element">Meetings</div>
                            </li>
                            <li>
                              <div class="treeview-animated-element">Workouts</div>
                            </li>
                            <li>
                              <div class="treeview-animated-element">Events</div>
                            </li>
                          </ul>
                        </li>
                      </ul>
                    </li>
                    <li class="treeview-animated-items">
                      <a class="treeview-animated-items-header">
                        <i class="fas fa-plus"></i>
                        <span>Inbox</span>
                      </a>
                      <ul class="nested">
                        <li>
                          <div class="treeview-animated-element">Admin</div>
                        </li>
                        <li>
                          <div class="treeview-animated-element">Corporate</div>
                        </li>
                        <li>
                          <div class="treeview-animated-element">Finance</div>
                        </li>
                        <li>
                          <div class="treeview-animated-element">Other</div>
                        </li>
                      </ul>
                    </li>
                    <li class="treeview-animated-items">
                      <a class="treeview-animated-items-header">
                        <i class="fas fa-plus"></i>
                        <span>Favourites</span>
                      </a>
                      <ul class="nested">
                        <li>
                          <div class="treeview-animated-element">Restaurants</div>
                        </li>
                        <li>
                          <div class="treeview-animated-element">Places</div>
                        </li>
                        <li>
                          <div class="treeview-animated-element">Games</div>
                        </li>
                        <li>
                          <div class="treeview-animated-element">Coctails</div>
                        </li>
                        <li>
                          <div class="treeview-animated-element">Food</div>
                        </li>
                      </ul>
                    </li>
                    <li>
                      <div class="treeview-animated-element">Notes</div>
                    </li>
                    <li>
                      <div class="treeview-animated-element">Settings</div>
                    </li>
                    <li>
                      <div class="treeview-animated-element">Devices</div>
                    </li>
                    <li>
                      <div class="treeview-animated-element">Deleted Items</div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </section>
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</template>

<script>
    import { mapActions } from 'vuex';
    import Breadcrumb from 'com@admin/Breadcrumb';

    export default {
        name: 'Login',
        components: {Breadcrumb},
        data() {
            return {
            };
        },
        methods: {
        }
    };
</script>