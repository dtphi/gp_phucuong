<template>
    <nav id="column-left" class="active">
    	<div id="profile">
		  	<div>
	        <i class="fa fa-user"></i>
	      </div>
		  <div>
		    <h4>Logo</h4>
		    <small>Administrator</small>
		  </div>
			</div>
			<ul id="menu">
			  <li id="dashboard">
			  	<a :href="_getHref('dashboards')">
			  		<i class="fa fa-dashboard fa-fw"></i> 
			  		<span>{{$options.setting.dashboards_title}}</span></a>
			  </li>

			  <li id="user">
			  	<a :href="_getHref('users')">
			  		<i class="fa fa-user fa-fw"></i> 
			  		<span>{{$options.setting.users_title}}</span></a>
			  </li>

			  <li id="catalog" class="active open">
			  	<a class="parent">
			  		<i class="fa fa-tags fa-fw"></i> 
			  		<span>{{$options.setting.category_root_title}}</span></a>
			    <ul class="collapse in">
			      <li class="active open">
			      	<a :href="_getHref('news-categories')">{{$options.setting.category_sub_cate_info_title}}</a>
			      </li>
			      <li>
			      	<a :href="_getHref('informations')">{{$options.setting.category_sub_info_title}}</a>
			      </li>
			      <li>
			      	<a :href="_getHref('filemanagers')">{{$options.setting.category_sub_image_title}}</a>
			      </li>
			    </ul>
			  </li>
			</ul>
		</nav>
</template>

<script>
	import {
		fn_get_admin_base_url
	} from '@app/api/utils/fn-helper';

    export default {
        name: 'LeftSideBar',
        methods: {
        	_getHref(path) {
        		return fn_get_admin_base_url() + '/' + path;
        	}
        },
        setting: {
        	dashboards_title: 'Quản trị',
        	users_title: 'Người dùng',
        	category_root_title: 'Danh mục thông tin',
        	category_sub_cate_info_title: 'Danh mục tin tức',
        	category_sub_info_title: 'Tin tức',
        	category_sub_image_title: 'Hình ảnh tin tức',
        }
    };
</script>
