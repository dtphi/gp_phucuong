<template>
	<div id="category-left-side-bar-module" style="min-height:500px">
		Nội dung danh mục trái .
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
