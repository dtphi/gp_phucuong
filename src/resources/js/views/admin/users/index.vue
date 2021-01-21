<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Users</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Users v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

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
                      <th>Name</th>
                      <th>Role</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Created by</th>
                      <th>Created from</th>
                      <th>Last login</th>
                      <th>Key</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Name 01</td>
                      <td>Admin</td>
                      <td>admin@mail.com</td>
                      <td>0123456789</td>
                      <td>Admin</td>
                      <td>24/12/2020</td>
                      <td>18/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_01" name="Key" value="">
                          <label for="key_01"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 02</td>
                      <td>User</td>
                      <td>user@mail.com</td>
                      <td>0987654321</td>
                      <td>Admin</td>
                      <td>25/12/2020</td>
                      <td>12/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_02" name="Key" value="">
                          <label for="key_02"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 03</td>
                      <td>Admin</td>
                      <td>admin@mail.com</td>
                      <td>5467891230</td>
                      <td>Admin</td>
                      <td>23/12/2020</td>
                      <td>12/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_03" name="Key" value="">
                          <label for="key_03"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 04</td>
                      <td>User</td>
                      <td>user@mail.com</td>
                      <td>0987654321</td>
                      <td>Admin</td>
                      <td>25/12/2020</td>
                      <td>12/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_04" name="Key" value="">
                          <label for="key_04"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 05</td>
                      <td>User</td>
                      <td>user@mail.com</td>
                      <td>0123456789</td>
                      <td>Admin</td>
                      <td>24/12/2020</td>
                      <td>18/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_05" name="Key" value="">
                          <label for="key_05"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 06</td>
                      <td>User</td>
                      <td>user@mail.com</td>
                      <td>0987654321</td>
                      <td>Admin</td>
                      <td>25/12/2020</td>
                      <td>12/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_06" name="Key" value="">
                          <label for="key_06"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 07</td>
                      <td>Admin</td>
                      <td>admin@mail.com</td>
                      <td>5467891230</td>
                      <td>Admin</td>
                      <td>23/12/2020</td>
                      <td>12/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_07" name="Key" value="">
                          <label for="key_07"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 08</td>
                      <td>User</td>
                      <td>user@mail.com</td>
                      <td>0987654321</td>
                      <td>Admin</td>
                      <td>25/12/2020</td>
                      <td>12/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_08" name="Key" value="">
                          <label for="key_08"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 09</td>
                      <td>Admin</td>
                      <td>admin@mail.com</td>
                      <td>0123456789</td>
                      <td>Admin</td>
                      <td>24/12/2020</td>
                      <td>18/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_09" name="Key" value="">
                          <label for="key_09"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 10</td>
                      <td>User</td>
                      <td>user@mail.com</td>
                      <td>0987654321</td>
                      <td>Admin</td>
                      <td>25/12/2020</td>
                      <td>12/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_10" name="Key" value="">
                          <label for="key_10"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 11</td>
                      <td>Admin</td>
                      <td>admin@mail.com</td>
                      <td>5467891230</td>
                      <td>Admin</td>
                      <td>23/12/2020</td>
                      <td>12/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_11" name="Key" value="">
                          <label for="key_11"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 12</td>
                      <td>User</td>
                      <td>user@mail.com</td>
                      <td>0987654321</td>
                      <td>Admin</td>
                      <td>25/12/2020</td>
                      <td>12/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_12" name="Key" value="">
                          <label for="key_12"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 13</td>
                      <td>User</td>
                      <td>user@mail.com</td>
                      <td>0123456789</td>
                      <td>Admin</td>
                      <td>24/12/2020</td>
                      <td>18/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_13" name="Key" value="">
                          <label for="key_13"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 14</td>
                      <td>User</td>
                      <td>user@mail.com</td>
                      <td>0987654321</td>
                      <td>Admin</td>
                      <td>25/12/2020</td>
                      <td>12/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_14" name="Key" value="">
                          <label for="key_14"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 15</td>
                      <td>Admin</td>
                      <td>admin@mail.com</td>
                      <td>5467891230</td>
                      <td>Admin</td>
                      <td>23/12/2020</td>
                      <td>12/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_15" name="Key" value="">
                          <label for="key_15"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 16</td>
                      <td>User</td>
                      <td>user@mail.com</td>
                      <td>0987654321</td>
                      <td>Admin</td>
                      <td>25/12/2020</td>
                      <td>12/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_16" name="Key" value="">
                          <label for="key_16"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 17</td>
                      <td>Admin</td>
                      <td>admin@mail.com</td>
                      <td>0123456789</td>
                      <td>Admin</td>
                      <td>24/12/2020</td>
                      <td>18/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_17" name="Key" value="">
                          <label for="key_17"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 18</td>
                      <td>User</td>
                      <td>user@mail.com</td>
                      <td>0987654321</td>
                      <td>Admin</td>
                      <td>25/12/2020</td>
                      <td>12/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_18" name="Key" value="">
                          <label for="key_18"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 19</td>
                      <td>Admin</td>
                      <td>admin@mail.com</td>
                      <td>5467891230</td>
                      <td>Admin</td>
                      <td>23/12/2020</td>
                      <td>12/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_19" name="Key" value="">
                          <label for="key_19"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 20</td>
                      <td>User</td>
                      <td>user@mail.com</td>
                      <td>0987654321</td>
                      <td>Admin</td>
                      <td>25/12/2020</td>
                      <td>12/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_20" name="Key" value="">
                          <label for="key_20"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 21</td>
                      <td>User</td>
                      <td>user@mail.com</td>
                      <td>0123456789</td>
                      <td>Admin</td>
                      <td>24/12/2020</td>
                      <td>18/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_21" name="Key" value="">
                          <label for="key_21"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 22</td>
                      <td>User</td>
                      <td>user@mail.com</td>
                      <td>0987654321</td>
                      <td>Admin</td>
                      <td>25/12/2020</td>
                      <td>12/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_22" name="Key" value="">
                          <label for="key_22"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 23</td>
                      <td>Admin</td>
                      <td>admin@mail.com</td>
                      <td>5467891230</td>
                      <td>Admin</td>
                      <td>23/12/2020</td>
                      <td>12/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_23" name="Key" value="">
                          <label for="key_23"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 24</td>
                      <td>User</td>
                      <td>user@mail.com</td>
                      <td>0987654321</td>
                      <td>Admin</td>
                      <td>25/12/2020</td>
                      <td>12/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_24" name="Key" value="">
                          <label for="key_24"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 25</td>
                      <td>Admin</td>
                      <td>admin@mail.com</td>
                      <td>0123456789</td>
                      <td>Admin</td>
                      <td>24/12/2020</td>
                      <td>18/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_25" name="Key" value="">
                          <label for="key_25"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 26</td>
                      <td>User</td>
                      <td>user@mail.com</td>
                      <td>0987654321</td>
                      <td>Admin</td>
                      <td>25/12/2020</td>
                      <td>12/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_26" name="Key" value="">
                          <label for="key_26"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 27</td>
                      <td>Admin</td>
                      <td>admin@mail.com</td>
                      <td>5467891230</td>
                      <td>Admin</td>
                      <td>23/12/2020</td>
                      <td>12/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_27" name="Key" value="">
                          <label for="key_27"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 28</td>
                      <td>User</td>
                      <td>user@mail.com</td>
                      <td>0987654321</td>
                      <td>Admin</td>
                      <td>25/12/2020</td>
                      <td>12/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_28" name="Key" value="">
                          <label for="key_28"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 29</td>
                      <td>User</td>
                      <td>user@mail.com</td>
                      <td>0123456789</td>
                      <td>Admin</td>
                      <td>24/12/2020</td>
                      <td>18/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_29" name="Key" value="">
                          <label for="key_29"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 30</td>
                      <td>User</td>
                      <td>user@mail.com</td>
                      <td>0987654321</td>
                      <td>Admin</td>
                      <td>25/12/2020</td>
                      <td>12/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_30" name="Key" value="">
                          <label for="key_30"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 31</td>
                      <td>Admin</td>
                      <td>admin@mail.com</td>
                      <td>5467891230</td>
                      <td>Admin</td>
                      <td>23/12/2020</td>
                      <td>12/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_31" name="Key" value="">
                          <label for="key_31"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Name 32</td>
                      <td>User</td>
                      <td>user@mail.com</td>
                      <td>0987654321</td>
                      <td>Admin</td>
                      <td>25/12/2020</td>
                      <td>12/01/2021</td>
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" id="key_32" name="Key" value="">
                          <label for="key_32"></label>
                        </div>
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
      <button type="button" class="btn btn-default mb-3" data-toggle="modal" data-target="#modal-lg">
        Launch Large Modal
      </button>
    </section>
    <!-- /.content -->
    <UserAddForm />
  </div>
  <!-- /.content-wrapper -->
</template>

<script>
    import { mapActions } from 'vuex';
    import UserAddForm from '../../../components/admin/Modal/users/AddForm';

    export default {
        name: 'Login',
        components: {UserAddForm},
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