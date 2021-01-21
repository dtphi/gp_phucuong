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
                  <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><div class="row"><div class="col-sm-12 col-md-6"><div class="dataTables_length" id="example1_length"><label>Show <select name="example1_length" aria-controls="example1" class="custom-select custom-select-sm form-control form-control-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div></div><div class="col-sm-12 col-md-6"><div id="example1_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="example1"></label></div></div></div><div class="row"><List /></div><Paginate /></div>
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
    import Breadcrumb from '../../../components/admin/Breadcrumb';
    import Paginate from '../../../components/admin/Pagination';
    import List from '../../../components/admin/News/List';

    export default {
        name: 'News',
        components: {Breadcrumb, UserAddForm, List, Paginate},
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