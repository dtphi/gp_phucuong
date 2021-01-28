<template>
  <div class="modal fade" id="modal-lg">
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
	        <form class="form-horizontal">
	          <div class="card-body">
	            <div class="form-group row">
	              <label for="inputEmail3" class="col-sm-2 col-form-label">Role</label>
	              <div class="col-sm-10">
	                <select class="form-control select2" style="width: 50%;">
	                  <option selected="selected">Admin</option>
	                  <option>User</option>
	                  <option>Visitor</option>
	                  <option>cc 1</option>
	                  <option>cc 2</option>
	                  <option>cc 3</option>
	                  <option>cc 4</option>
	                </select>
	              </div>
	            </div>
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
	            <div class="form-group row">
	              <label for="inputPassword3" class="col-sm-2 col-form-label">Option</label>
	              <div class="col-sm-10">
	                <div class="icheck-primary mb-3">
	                  <input type="radio" id="option_1" name="option" value="">
	                  <label for="option_1">Option 01</label>
	                </div>
	                <div class="icheck-primary">
	                  <input type="radio" id="option_2" name="option" value="">
	                  <label for="option_2">Option 02</label>
	                </div>
	              </div>
	            </div>
	            <div class="form-group row">
	              <label for="name" class="col-sm-2 col-form-label">Note</label>
	              <div class="col-sm-10">
	                <textarea class="form-control" rows="6" placeholder="Type text ..."></textarea>
	              </div>
	            </div>
	          </div>
	        </form>
	      </div>
	      <div class="modal-footer justify-content-between">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-success">Save changes</button>
	      </div>
	    </div>
	    <!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
	</div>
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