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
                  <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                      <div class="col-sm-12 col-md-6">
                        <Perpage />
                        </div>
                        <div class="col-sm-12 col-md-6">
                          <ListSearch />
                        </div>
                      </div>
                    <div class="row">
                      <List />
                    </div>
                    <Paginate />
                </div>
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
    import UserAddForm from 'com@admin/Modal/users/AddForm';
    import Breadcrumb from 'com@admin/Breadcrumb';
    import Perpage from 'com@admin/Pagination/SelectPerpage';
    import ListSearch from 'com@admin/Search';
    import Paginate from 'com@admin/Pagination';
    import List from 'com@admin/News/List';

    export default {
        name: 'News',
        components: {Breadcrumb, Perpage, ListSearch, UserAddForm, List, Paginate},
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