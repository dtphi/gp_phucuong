import AppConfig from '../admin/constants/app-config';
import {
	config
	} from '../admin/config';
import NoImage from 'v@admin/assets/img/no-photo.jpg';
import moment from 'moment';

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
	if (path) {
		return config.baseUrl + AppConfig.newsUploadDir + '/' + path.replace(/^\//, "");
	}
	return NoImage;
}

export function fn_get_news_file_connector_url() {
	return config.baseUrl + AppConfig.newsFileConnectUrlPath;
}

export function fn_get_news_file_sound_url() {
	return config.baseUrl + AppConfig.elFinderSoundPath;
}

export function fn_get_tinymce_langs_url(langName) {
	return config.baseUrl + AppConfig.tinymceLangPath + '/' + langName + '.js';
}

export function fn_redirect_url(path) {
	return window.location = config.baseUrl + '/' + path.replace(/^\//, "");
}

export function fn_format_dd_mm_yyyy(date) {
	return moment(date).format(AppConfig.formatDateString);
}