import ApiConfig from './api-config';

const AppConfig = {
	apiUrl: ApiConfig.baseURL,
	perPageValues: [5,15,25,50,100],
	formatDateString: 'DD-MM-YYYY',
	newsUploadDir: '/upload/news',
	newsFileConnectUrlPath: '/admin/filemanagers/news/connector',
	elFinderSoundPath: '/packages/barryvdh/elfinder/sounds',
	tinymceLangPath: '/administrator/langs'
}

export default AppConfig;