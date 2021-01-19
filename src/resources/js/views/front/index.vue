<template>
    <!-- Login Card -->
    <div class="card">
      
      <!-- Card Header -->
      <div class="card-header login-card-header">
        <!-- Login Logo -->
        <div class="login-logo">
          <a href="#!" title="Admin">
            <img src="/front/img/logo.png" alt="logo">
          </a>
        </div>
        <!-- End Login Logo -->
      </div>
      <!-- End Card Header -->
    </div>
    <!-- Login Card -->
</template>

<script>
    import { mapActions } from 'vuex';

    export default {
        name: 'Home',
        data() {
            return {
                form: {
                    email: null,
                    password: null
                },
                systemError: null
            };
        }
    };
</script>