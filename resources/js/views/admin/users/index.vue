<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <Breadcrumb />

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped tbl-custom">
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
                    <tr>
                      <td>1</td>
                      <td>Admin</td>
                      <td>admin@mail.com</td>
                      <td>24/12/2020</td>
                      <td>18/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_01" name="Key" value="">
                          <label for="key_01"></label>
                        </div>
                      </td>
                      <td>
                        <button type="button" class="btn btn-default mb-3" data-toggle="modal" data-target="#modal-lg"><font-awesome-icon icon="plus"  size="xs" /></button>
                        <button type="button" class="btn btn-default mb-3" data-toggle="modal" data-target="#modal-lg"><font-awesome-icon icon="edit"  size="xs" /></button>
                      </td>
                    </tr>
                    
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
    
    <UserAddForm />
  </div>
  <!-- /.content-wrapper -->
</template>

<script>
    import { mapActions } from 'vuex';
    import UserAddForm from 'com@admin/Modal/Users/AddForm';
    import Breadcrumb from 'com@admin/Breadcrumb';

    export default {
        name: 'UserList',
        components: {Breadcrumb, UserAddForm},
        data() {
            return {
                form: {
                    email: null,
                    password: null
                },
                systemError: null
            };
        },
        methods: {
        }
    };
</script>