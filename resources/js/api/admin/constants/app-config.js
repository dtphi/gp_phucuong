import ApiConfig from './api-config';
const noGrType = {
	comSuccess: 'common-success',
	comUpdate: 'common-update',
}
const AppConfig = {
	apiUrl: ApiConfig.baseURL,
	perPageValues: [5, 15, 25, 50, 100],
	formatDateString: 'DD-MM-YYYY',
	newsUploadDir: '/Image',
	newsFileConnectUrlPath: '/admin/filemanagers/news/connector',
	elFinderSoundPath: '/packages/barryvdh/elfinder/sounds',
	tinymceLangPath: '/administrator/langs',
	noGroupType: noGrType,
	comSuccessNo: {
		group: noGrType.comSuccess,
		text: 'Thành công'
	},
	comUpdateNoSuccess: {
		group: noGrType.comUpdate,
		text: 'Thực hiện cập nhật thành công'
	},
	comUpdateNoFail: {
		group: noGrType.comUpdate,
		text: 'Thực hiện cập nhật thất bại'
	},
	comInsertNoSuccess: {
		group: noGrType.comUpdate,
		text: 'Thực hiện thêm thành công'
	},
	comInsertNoFail: {
		group: noGrType.comUpdate,
		text: 'Thực hiện thêm thất bại'
	},
}

export default AppConfig;