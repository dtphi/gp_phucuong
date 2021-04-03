<template>
    <!-- Login Box -->
    <div id="container">
    	<div id="content">
			  <div class="container-fluid"><br>
			    <br>
			    <div class="row">
			      <div class="col-sm-offset-4 col-sm-4">
			        <div class="panel panel-default">
			          <div class="panel-heading">
			            <h1 class="panel-title"><i class="fa fa-lock"></i> Please enter your login details.</h1>
			            <logo class="main-logo"></logo>
			          </div>
			          	<div class="panel-body">
			              <slot></slot>
			          </div>
			        </div>
			      </div>
			    </div>
			  </div>
			</div>
			<main-footer></main-footer>
    </div>
    <!-- Login Box -->
</template>

<script>
	import Logo from 'com@admin/Logo';
	import MainFooter from 'com@admin/Footer';

    export default {
        name: 'AuthLayout',
        components: {Logo, MainFooter}
    };
</script>

<style lang="css" scoped>
    @import '../../assets/javascript/bootstrap/css/bootstrap.css';
    @import '../../assets/javascript/font-awesome/css/font-awesome.min.css';
    @import '../../assets/stylesheet/stylesheet.css';

    .main-logo{
    	width: 20%;
    	position: relative;
    	left: 40%;
    }
    
</style>