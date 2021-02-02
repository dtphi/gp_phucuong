<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <LoadingOverLay :active.sync="loading" :is-full-page="fullPage"/>
    <Breadcrumb />

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users List</h3>
                <div>
                  <BtnAdd />
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered table-striped tbl-custom">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Created from</th>
                      <th>Last login</th>
                      <th>Key</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <Item v-for="item in userList" 
                    :user-id="item.id" 
                    :name="item.name"
                    :email="item.email"
                    :created-at="item.createdAt"
                    :key="item.id"
                    />
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    
    <UserForm v-if="isOpen"/>
  </div>
  <!-- /.content-wrapper -->
</template>

<script>
    import { mapGetters,mapActions } from 'vuex';
    import UserForm from 'com@admin/Modal/Users/AddForm';
    import Breadcrumb from 'com@admin/Breadcrumb';
    import Item from './components/Item';
    import BtnAdd from './components/BtnAdd';
    import 'vue-loading-overlay/dist/vue-loading.css';

    export default {
        name: 'UserList',
        beforeCreate() {
          this.$store.dispatch('user/getUserList');
        },
        components: {Breadcrumb, UserForm, Item, BtnAdd},
        data() {
          return {
            fullPage: true
          };
        },
        computed: {
          ...mapGetters('user', ['users', 'loading']),
          ...mapGetters('user/modal', ['isOpen']),

          userList () {
            return this.users;
          }
        },
        methods: {
          ...mapActions('user', ['setLoading']),
        }
    };
</script>