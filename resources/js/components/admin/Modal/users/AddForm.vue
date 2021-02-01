<template>
	<transition name="modal">
	  <div class="modal fade" data-keyboard="false" data-backdrop="static" id="modal-lg">
		  <div class="modal-dialog modal-lg">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h4 class="modal-title">Edit Users</h4>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <!-- form start -->
		        <div class="form-horizontal">
		          <div class="card-body">
		            <div class="form-group row">
		              <label for="name" class="col-sm-2 col-form-label">Name</label>
		              <div class="col-sm-10">
		                <input type="text" class="form-control" id="name" placeholder="Name">
		              </div>
		            </div>
		            <div class="form-group row">
		              <label for="email" class="col-sm-2 col-form-label">Email</label>
		              <div class="col-sm-10">
		                <input type="email" class="form-control" id="email" placeholder="Email">
		              </div>
		            </div>
		            <div class="form-group row">
		              <label for="password" class="col-sm-2 col-form-label">Password</label>
		              <div class="col-sm-10">
		                <input type="password" class="form-control" id="password" placeholder="Password">
		              </div>
		            </div>
		          </div>
		        </div>
		      </div>
		      <div class="modal-footer justify-content-between">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <button type="button" class="btn btn-success">Save</button>
		      </div>
		    </div>
		    <!-- /.modal-content -->
		  </div>
		  <!-- /.modal-dialog -->
		</div>
	</transition>
</template>

<script>
    import { mapActions } from 'vuex';

    export default {
        name: 'UserAddForm',
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