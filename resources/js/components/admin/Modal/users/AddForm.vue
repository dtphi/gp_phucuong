<template>
  <transition name="modal">
    <div :class="classShow" :style="styleCss" data-keyboard="false" data-backdrop="static">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <Loading :active.sync="loading" :is-full-page="fullPage"></Loading>
          <div class="modal-header">
            <h4 class="modal-title">{{title}}</h4>
            <button type="button" class="close" aria-label="Close" @click="closeModal">
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
                    <input v-model="name" type="text" class="form-control" placeholder="Name">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="email" class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-10">
                    <input v-model="email" type="email" class="form-control" placeholder="Email">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="password" class="col-sm-2 col-form-label">Password</label>
                  <div class="col-sm-10">
                    <input v-model="password" type="password" class="form-control" placeholder="Password">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" @click="closeModal">Close</button>
            <button type="button" class="btn btn-success" @click="addUser">Save</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
  </transition>
</template>

<script>
    import { mapGetters, mapMutations, mapActions } from 'vuex';
    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';

    export default {
        name: 'UserAddForm',
        components: {Loading},
        data() {
            return {
              name: '',
              email: '',
              password: '',
              fullPage: false,
              title: ''
            };
        },
        computed: {
          ...mapGetters('user/modal', [
            'classShow',
            'styleCss',
            'user',
            'loading'
          ]),
        },
        created() {
          this.title = this.$options.setting.AddTitle;
          if (this.user) {
            this.title = this.$options.setting.EditTitle;
            this.name = this.user.name;
            this.email = this.user.email;
          }
        },
        methods: {
          ...mapActions('user/modal', [
            'closeModal',
            'setLoading',
            'insertUser',
            'updateUser'
          ]),

          addUser() {
            this.setLoading(true);
            if (this.user) {
              this.updateUser({
                name: this.name,
                email: this.email,
                password: this.password
              });
            } else {
              this.insertUser({
                name: this.name,
                email: this.email,
                password: this.password
              });
            }
          }
        },
        setting: {
          EditTitle: 'Edit User',
          AddTitle: 'Add User'
        }
    };
</script>