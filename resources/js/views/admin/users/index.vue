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
                <div style="float:right">
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
                      <th>Key</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody v-if="_notEmpty">
                    <Item v-for="(item,index) in _userList" 
                      :user="item"
                      :key="item.id"/>
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
    
    <UserForm />
    <v-dialog />
  </div>
  <!-- /.content-wrapper -->
</template>

<script>
    import { mapState, mapGetters, mapActions } from 'vuex';
    import UserForm from 'com@admin/Modal/Users/AddForm';
    import Breadcrumb from 'com@admin/Breadcrumb';
    import Item from './components/TheItem';
    import BtnAdd from './components/TheBtnAdd';
    import {
      MODULE_USER
    } from 'store@admin/types/module-types';
    import {
      ACTION_GET_USER_LIST,
      ACTION_SET_LOADING
    } from 'store@admin/types/action-types';

    export default {
        name: 'UserList',
        beforeCreate() {
          this.$store.dispatch(MODULE_USER + '/' + ACTION_GET_USER_LIST);
        },
        components: {
          Breadcrumb, 
          UserForm, 
          Item, 
          BtnAdd
        },
        data() {
          return {
            fullPage: true
          };
        },
        computed: {
          ...mapState(MODULE_USER, [
            'users', 
            'loading'
          ]),

          _userList () {
            return this.users;
          },

          _notEmpty () {
            return this.users && Object.keys(this.users).length;
          }
        },
        methods: {
          ...mapActions(MODULE_USER, [ACTION_SET_LOADING]),
        }
    };
</script>