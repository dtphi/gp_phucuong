<template>
  <div id="modal-lg" class="modal fade" aria-modal="true" style="padding-right: 17px; display: block;">
  	<div class="modal-dialog modal-lg">
  		<div class="modal-content">
  			<div class="modal-header">
  				<h4 class="modal-title">Edit Users</h4> 
  				<button type="button" data-dismiss="modal" aria-label="Close" class="close">	<span aria-hidden="true">×</span>
  				</button>
  			</div> 
				<div class="modal-body">
					<form class="form-horizontal">
						<div class="card-body">
							<div class="form-group row">
								<label for="inputEmail3" class="col-sm-2 col-form-label">Role</label> 
								<div class="col-sm-10">
									<select class="form-control select2" style="width: 50%;"><option selected="selected">Admin</option> <option>User</option> <option>Visitor</option> <option>cc 1</option> <option>cc 2</option> <option>cc 3</option> <option>cc 4</option></select></div></div> <div class="form-group row"><label for="name" class="col-sm-2 col-form-label">Name</label> <div class="col-sm-10"><input type="text" id="name" placeholder="Name" class="form-control"></div></div> <div class="form-group row"><label for="email" class="col-sm-2 col-form-label">Email</label> <div class="col-sm-10"><input type="email" id="email" placeholder="Email" class="form-control"></div></div> <div class="form-group row"><label for="password" class="col-sm-2 col-form-label">Password</label> <div class="col-sm-10"><input type="password" id="password" placeholder="Password" class="form-control"></div></div> <div class="form-group row"><label for="inputPassword3" class="col-sm-2 col-form-label">Option</label> <div class="col-sm-10"><div class="icheck-primary mb-3"><input type="radio" id="option_1" name="option" value=""> <label for="option_1">Option 01</label></div> <div class="icheck-primary"><input type="radio" id="option_2" name="option" value=""> <label for="option_2">Option 02</label></div></div></div> <div class="form-group row"><label for="name" class="col-sm-2 col-form-label">Note</label> <div class="col-sm-10"><textarea rows="6" placeholder="Type text ..." class="form-control"></textarea>
									</div>
								</div>
							</div>
						</form>
					</div> 
					
						<div class="modal-footer justify-content-between">
							<button type="button" data-dismiss="modal" class="btn btn-default">Close</button> <button type="button" class="btn btn-success">Save changes</button>
						</div>
					</div>
				</div>
			</div>
</template>

<script>
    import { mapActions } from 'vuex';

    export default {
        name: 'NewsAddForm',
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