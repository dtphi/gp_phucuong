<template>
  <header id="header" class="navbar navbar-static-top">
		  <div class="navbar-header">
		  	<a type="button" id="button-menu" class="pull-left"><i class="fa fa-indent fa-lg"></i></a>
		  	<a :href="_getHref()" class="navbar-brand">
		  		<logo></logo>
		  	</a>
		  </div>

		  <ul class="nav pull-right">
		    <li class="dropdown">
		    	<a class="dropdown-toggle" data-toggle="dropdown">
		    		<span class="label label-danger pull-left">1</span> 
		    		<i class="fa fa-bell fa-lg"></i>
		    	</a>
		    </li>
		    <li class="dropdown">
		    	<a class="dropdown-toggle" data-toggle="dropdown">
		    		<i class="fa fa-life-ring fa-lg"></i></a>
		      <ul class="dropdown-menu dropdown-menu-right">
		        <li>
		        	<a :href="_getHrefSite()" target="_blank">{{$options.setting.site_name}}</a>
		        </li>
		        <li class="divider"></li>
		        <li class="dropdown-header" @click="_showHelpAbout()">
		        	<a href="javascript:void(0);">{{$options.setting.help_txt}}<i class="fa fa-life-ring"></i></a>
		        </li>
		      </ul>
		    </li>
		    <li><logout></logout></li>
		  </ul>
		</header>
</template>
<script>
	import Logout from '../Sidebar/Logout';
	import Logo from '../Logo';
	import HelpAbout from '../Modal/HelpAbout';
	import {
		fn_get_base_url,
		fn_get_admin_base_url
	} from '@app/api/utils/fn-helper';

export default {
  name: 'MainHeader',
  components: {
  	Logout,
  	Logo,
  	HelpAbout
  },
  props: {
    size: {type: Number, default: 21}
  },
  methods: {
  	_getHrefSite() {
  		return fn_get_base_url();
  	},
  	_getHref() {
  		return fn_get_admin_base_url();
  	},
  	_showHelpAbout() {
  		this.$modal.show(
				HelpAbout,
			  { text: '' },
			  { height: 'auto' },
			  { 'before-close': event => {} }
			)  	
  	}
  },
  setting: {
  	site_name: 'Giáo phận phú cường',
  	help_txt: 'Help'
  }
}
</script>

<style type="text/css" scoped="">
	.navbar-brand > img {
		width: 18px;
		height: 24px;
	}
</style>