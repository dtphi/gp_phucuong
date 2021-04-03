<template>
	  <div class="page-header">
	    <div class="container-fluid">
	      <div class="pull-right">
	      	<button @click="_pushAddPage()" 
	      		data-toggle="tooltip" title="" 
	      		class="btn btn-primary" 
	      		data-original-title="Thêm Nhóm Tin"><i class="fa fa-plus"></i></button> 

	      		<a href="/" 
	      			data-toggle="tooltip" title="" 
	      			class="btn btn-default" 
	      			data-original-title="Rebuild"><i class="fa fa-refresh"></i></a>

	       		 <button type="button" data-toggle="tooltip" title="" class="btn btn-danger" onclick="confirm('Are you sure?') ? $('#form-category').submit() : false;" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
	      </div>
	      <h1>Nhóm Tin</h1>
	      <ul class="breadcrumb">
          <li>
          	<a href="/">Quản lý</a></li>
          <li><a href="/">Nhóm tin</a></li>
        </ul>
	    </div>
		</div>
</template>

<script>

    export default {
        name: 'CategoryHeaderPage',
        methods: {
        	_pushAddPage() {
        		this.$router.push(`/admin/news-categories/add`);
        	}
        },
        setting: {
            title: 'News Category Header'
        }
    };
</script>
