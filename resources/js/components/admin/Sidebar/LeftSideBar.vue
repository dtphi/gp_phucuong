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

			  <li id="catalog" class="">
			  	<a class="parent">
			  		<i class="fa fa-tags fa-fw"></i> 
			  		<span>{{$options.setting.category_root_title}}</span></a>
			    <ul class="collapse">
			      <li>
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

			  <li id="module">
			  	<a class="parent">
			  		<i class="fa fa-puzzle-piece fw"></i> 
			  		<span>{{$options.setting.module_title}}</span></a>
			    <ul class="collapse">
			      <li>
			      	<a :href="_getHref('module-category-left-side-bars')">{{$options.setting.module_category_left_side_bar}}</a>
			      </li>
				  <li>
			      	<a :href="_getHref('module-home-banners')">{{$options.setting.module_home_banner}}</a>
			      </li>
				  <li>
					  <a :href="_getHref('module-category-icon-side-bars')">{{$options.setting.module_category_icon_side_bar}}</a>
				  </li>
				  <li>
					  <a :href="_getHref('module-thong-baos')">{{$options.setting.module_thong_bao}}</a>
				  </li>
				  <li>
					  <a :href="_getHref('module-tin-giao-hoi-viet-nams')">{{$options.setting.module_tin_giao_hoi_viet_nam}}</a>
				  </li>
				  <li>
					  <a :href="_getHref('module-tin-giao-hois')">{{$options.setting.module_tin_giao_hoi}}</a>
				  </li>
				  <li>
					  <a :href="_getHref('module-tin-giao-phans')">{{$options.setting.module_tin_giao_phan}}</a>
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
        	category_root_title: 'Tin Tức',
        	category_sub_cate_info_title: 'Danh mục',
        	category_sub_info_title: 'Tin tức',
        	category_sub_image_title: 'Hình ảnh',
			module_title: 'Mở rộng',
			module_category_left_side_bar: 'Danh mục trái',
			module_category_icon_side_bar: 'Danh mục Icon',
			module_home_banner: 'Banner trang chủ',
			module_thong_bao: 'Danh mục thông báo',
			module_tin_giao_hoi_viet_nam: 'Tin giáo hội việt nam',
			module_tin_giao_hoi: 'Tin giáo hội',
			module_tin_giao_phan: 'Tin giáo phận',
        }
    };
</script>
