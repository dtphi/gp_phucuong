import AppConfig from '../admin/constants/app-config';
import {
	config
	} from '../admin/config';

export function fn_get_base_api_url(apiPath) {
  return AppConfig.apiUrl + apiPath;
}

export function fn_get_base_api_detail_url(apiPath, id) {
	return AppConfig.apiUrl + apiPath + '/' + id;
}

export function fn_get_base_url_thumb(thumbPath) {
	return config.baseUrl + '/thumbs/' + thumbPath;
}

export function fn_get_base_url_image(path) {
	console.log(path)
	if (path) {
		return config.baseUrl + '/upload/news/' + path;
	}
	return config.baseUrl + '/administrator/img/logo.png';
}