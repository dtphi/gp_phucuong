<template>
  <header id="header" class="navbar navbar-static-top">
		  <div class="navbar-header">
		  	<a type="button" id="button-menu" class="pull-left"><i class="fa fa-indent fa-lg"></i></a>
		  </div>

		  <ul class="nav pull-right">
		    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><span class="label label-danger pull-left">1</span> <i class="fa fa-bell fa-lg"></i></a>
		    </li>
		    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-life-ring fa-lg"></i></a>
		      <ul class="dropdown-menu dropdown-menu-right">
		        <li><a href="/" target="_blank">Giáo phận phú cường></a></li>
		        <li class="divider"></li>
		        <li class="dropdown-header">Help<i class="fa fa-life-ring"></i></li>
		      </ul>
		    </li>
		    <li><logout></logout></li>
		  </ul>
		</header>
</template>
<script>
	import Logout from '../Sidebar/Logout';

export default {
  name: 'MainHeader',
  components: {Logout},
  props: {
    size: {type: Number, default: 21}
  },
}
</script>
