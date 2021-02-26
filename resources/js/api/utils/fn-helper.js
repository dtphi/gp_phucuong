import AppConfig from '../admin/constants/app-config';

export function fn_get_base_api_url(apiPath) {
  return AppConfig.apiUrl + apiPath;
}

export function fn_get_base_api_detail_url(apiPath, id) {
	return AppConfig.apiUrl + apiPath + '/' + id;
}