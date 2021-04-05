<template>
	  <div class="page-header">
	    <div class="container-fluid">
	      <div class="pull-right">
	      	<btn-add></btn-add>

	      		<a href="/" 
	      			data-toggle="tooltip" title="" 
	      			class="btn btn-default" 
	      			data-original-title="Rebuild"><i class="fa fa-refresh"></i></a>

	       		 <button type="button" data-toggle="tooltip" title="" class="btn btn-danger" onclick="confirm('Are you sure?') ? $('#form-category').submit() : false;" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
	      </div>
	      <h1>{{$options.setting.title}}</h1>
	      <breadcrumb></breadcrumb>
        <ul class="cms-breadcrumb">
        	<li><perpage></perpage></li>
        	<li><list-search></list-search></li>
        </ul>
	    </div>
		</div>
</template>

<script>
	import BtnAdd from './TheBtnAdd';
	import Perpage from 'com@admin/Pagination/SelectPerpage';
	import ListSearch from 'com@admin/Search';
    import Breadcrumb from 'com@admin/Breadcrumb';

    export default {
        name: 'InformationHeaderPage',
        components: {
            BtnAdd, 
            Perpage, 
            ListSearch,
            Breadcrumb
        },
        methods: {
        	_pushAddPage() {
        		this.$router.push(`/admin/informations/add`);
        	}
        },
        setting: {
            title: 'Tin Tức'
        }
    };
</script>
