import ApiConfig from './api-config';
const noGrType = {
	comSuccess: 'common-success',
	comUpdate: 'common-update',
}
const AppConfig = {
	apiUrl: ApiConfig.baseURL,
	perPageValues: [5, 15, 25, 50, 100],
	formatDateString: 'DD-MM-YYYY',
	newsUploadDir: '/upload/news',
	newsFileConnectUrlPath: '/admin/filemanagers/news/connector',
	elFinderSoundPath: '/packages/barryvdh/elfinder/sounds',
	tinymceLangPath: '/administrator/langs',
	noGroupType: noGrType,
	comSuccessNo: {
		group: noGrType.comSuccess,
		text: 'Success'
	},
	comUpdateNoSuccess: {
		group: noGrType.comUpdate,
		text: 'Updated success'
	},
	comUpdateNoFail: {
		group: noGrType.comUpdate,
		text: 'Updated failed'
	}
}

export default AppConfig;