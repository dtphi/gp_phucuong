<template>
	<div id="content">
      <div class="container-fluid">
      	<div class="row">
			      <div class="col-lg-3 col-md-3 col-sm-6"><div class="tile">
						  <div class="tile-heading">Total <span class="pull-right">
						        {{userTotal}}</span></div>
						  <div class="tile-body"><i class="fa fa-user"></i>
						    <h2 class="pull-right">{{userTotal}}</h2>
						  </div>
						  <div class="tile-footer"><a href="/admin/users">Xem Thành viên...</a></div>
						</div>
						</div>
						      <div class="col-lg-3 col-md-3 col-sm-6"><div class="tile">
						  <div class="tile-heading">Total <span class="pull-right">
						        {{categoryTotal}} </span></div>
						  <div class="tile-body"><i class="fa fa-credit-card"></i>
						    <h2 class="pull-right">{{categoryTotal}}</h2>
						  </div>

						  <div class="tile-footer"><a href="/admin/news-categories">Xem Nhóm Tin...</a></div>
						</div>
						</div>
						      <div class="col-lg-3 col-md-3 col-sm-6"><div class="tile">
						  <div class="tile-heading">Total <span class="pull-right">
						        {{infoTotal}}</span></div>
						  <div class="tile-body"><i class="fa fa-info"></i>
						    <h2 class="pull-right">{{infoTotal}}</h2>
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
						  <div class="panel-body">
							<div class="table-responsive">
								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<td class="text-left">No</td>
											<td>Tên</td>
											<td>Hình ảnh</td>
											<td class="text-right">Ngày tạo</td>
										</tr>
									</thead>
									<tbody v-if="_isNotEmptyList">
										<tr>
											<td class="text-center" colspan="6">No results!</td>
										</tr>
									</tbody>
									<tbody v-else>
										<info-item 
											v-for="(item, idx) in infos"
											:info="item"
											:no="idx"
											:key="idx"></info-item>
									</tbody>
								</table>
							</div>
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
	import {
		MODULE_DASHBOARD,
    } from 'store@admin/types/module-types';
    import {
        ACTION_GET_INFO_LIST,
		ACTION_GET_NEWS_GROUP_LIST,
		ACTION_GET_USER_LIST,
    } from 'store@admin/types/action-types';
	import InfoItem from './components/InfoItem';

    export default {
        name: 'DashboardPage',
        components: {
            Breadcrumb,
			InfoItem
        },
		data() {
            return {
                fullPage: false
            }
        },
		computed: {
			...mapState(MODULE_DASHBOARD, [
                'infos',
                'loading',
				'infoTotal',
				'categoryTotal',
				'userTotal',
            ]),
			_isNotEmptyList() {
				return (this.infoTotal <= 0);
			}
		},
		mounted() {
            const params = {
                perPage: 5
            }

            this.[ACTION_GET_INFO_LIST](params);

			this.[ACTION_GET_NEWS_GROUP_LIST](params);

			this.[ACTION_GET_USER_LIST](params);
        },
		methods: {
            ...mapActions(MODULE_DASHBOARD, [
                ACTION_GET_INFO_LIST,
				ACTION_GET_NEWS_GROUP_LIST,
				ACTION_GET_USER_LIST
            ]),
        },
        setting: {
            title: 'News Groups List'
        }
    };
</script>
