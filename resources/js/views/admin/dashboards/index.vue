<template>
	<div id="content">
      <div class="container-fluid">
      	<div class="row">
			      <div class="col-lg-3 col-md-3 col-sm-6"><div class="tile">
						  <div class="tile-heading">Total <span class="pull-right">
						        0</span></div>
						  <div class="tile-body"><i class="fa fa-user"></i>
						    <h2 class="pull-right">0</h2>
						  </div>
						  <div class="tile-footer"><a href="/admin/users">Xem Thành viên...</a></div>
						</div>
						</div>
						      <div class="col-lg-3 col-md-3 col-sm-6"><div class="tile">
						  <div class="tile-heading">Total <span class="pull-right">
						        0 </span></div>
						  <div class="tile-body"><i class="fa fa-credit-card"></i>
						    <h2 class="pull-right">0</h2>
						  </div>

						  <div class="tile-footer"><a href="/admin/news-categories">Xem Nhóm Tin...</a></div>
						</div>
						</div>
						      <div class="col-lg-3 col-md-3 col-sm-6"><div class="tile">
						  <div class="tile-heading">Total <span class="pull-right">
						        0</span></div>
						  <div class="tile-body"><i class="fa fa-info"></i>
						    <h2 class="pull-right">0</h2>
						  </div>

						  <div class="tile-footer"><a href="/admin/informations">Xem Tin...</a></div>
						</div>
						</div>
			    </div>

			    <div class="row">
			    	<div class="col-lg-12 col-md-12 col-sm-12 col-sx-12"> <div class="panel panel-default">
						  <div class="panel-heading">
						    <h3 class="panel-title"><i class="fa fa-info"></i>Tin tức mới nhất</h3>
						  </div>
						  <div class="table-responsive">
						    <table class="table">
						      <thead>
						        <tr>
						          <td class="text-right">No</td>
						          <td>Tên</td>
						          <td>Hình ảnh</td>
						          <td>Mô tả</td>
						          <td class="text-right">Ngày tạo</td>
						          <td class="text-right">Trạng thái</td>
						        </tr>
						      </thead>
						      <tbody>
						                <tr>
						          <td class="text-center" colspan="6">No results!</td>
						        </tr>
						              </tbody>
						    </table>
						  </div>
						</div>
						 </div>
			    </div>
			</div>
  </div>
</template>

<script>
    import {mapState, mapGetters, mapActions} from 'vuex';
    import Breadcrumb from 'com@admin/Breadcrumb';

    export default {
        name: 'DashboardPage',
        components: {
            Breadcrumb
        },
        setting: {
            title: 'News Groups List'
        }
    };
</script>
