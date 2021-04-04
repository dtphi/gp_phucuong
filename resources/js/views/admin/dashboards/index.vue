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
