<template>
    <nav id="column-left" class="active"><div id="profile">
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
			  	<a href="/"><i class="fa fa-dashboard fa-fw"></i> <span>Quản trị</span></a>
			  </li>

			  <li id="user">
			  	<a href="/"><i class="fa fa-user fa-fw"></i> <span>Users</span></a>
			  </li>

			  <li id="catalog" class="active open">
			  	<a class="parent"><i class="fa fa-tags fa-fw"></i> <span>Danh mục</span></a>
			    <ul class="collapse in">
			      <li class="active open">
			      	<a href="/admin/news-categories">Nhóm Tin Tức</a>
			      </li>
			      <li>
			      	<a href="/admin/informations">Tin Tức</a>
			      </li>
			      <li>
			      	<a href="/">Hình Ảnh Tin Tức</a>
			      </li>
			    </ul>
			  </li>
			</ul>
		</nav>
</template>

<script>

    export default {
        name: 'LeftSideBar'
    };
</script>
