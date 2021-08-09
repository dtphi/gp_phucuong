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
		text: 'Thành công',
		type: 'success'
	},
	comUpdateNoSuccess: {
		group: noGrType.comUpdate,
		text: 'Thực hiện cập nhật thành công',
		type: 'success'
	},
	comUpdateNoFail: {
		group: noGrType.comUpdate,
		text: 'Thực hiện cập nhật thất bại',
		type: 'error'
	},
	comInsertNoSuccess: {
		group: noGrType.comUpdate,
		text: 'Thực hiện thêm thành công',
		type: 'success'
	},
	comInsertNoFail: {
		group: noGrType.comUpdate,
		text: 'Thực hiện thêm thất bại',
		type: 'error'
	},
}

export default AppConfig;