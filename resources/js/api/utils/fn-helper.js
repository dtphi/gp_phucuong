import AppConfig from '../admin/constants/app-config';
import {
	config
} from '../admin/config';
import NoImage from 'v@admin/assets/img/no-photo.jpg';
import moment from 'moment';

export function fn_is_object(obj) {
	if (typeof obj !== "undefined" 
	  && typeof obj === "object" 
	  && Object.keys(obj).length) {
	  return true;
	}
  
	return false;
}

export function fn_is_string(value) {
	return typeof value === 'string' || value instanceof String;
}

export function fn_get_base_url() {
	return config.baseUrl;
}
export function fn_get_href_base_url(path) {
	if (fn_is_string(path)) {
		return config.baseUrl + '/' + path.replace(/^\//, "");
	}
	return config.baseUrl + '/';
}
export function fn_get_admin_base_url() {
	return config.baseUrl + '/admin';
}

export function fn_get_base_api_url(apiPath) {
	return AppConfig.apiUrl + apiPath;
}

export function fn_get_base_api_detail_url(apiPath, id) {
	return AppConfig.apiUrl + apiPath + '/' + id;
}

export function fn_get_base_url_thumb(thumbPath) {
	return config.baseUrl + '/thumbs/' + thumbPath;
}

export function fn_get_base_url_image(path) {console.log('path', path)
	if (typeof path !== "undefined" && path.thumb) {
		return config.baseUrl + AppConfig.newsUploadDir + '/' + path.thumb.replace(/^\//, "");
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

export function fn_get_com_update_no() {
	return AppConfig.comUpdateNoSuccess;
}

export function fn_get_com_no_by_group(groupType) {
	switch (groupType) {
		case AppConfig.noGroupType.comUpdate:
			return AppConfig.comUpdateNoSuccess;
			break;
		default:
			return AppConfig.comSuccessNo;
			break;
	}
}

export function fn_change_to_slug(title)
{
    var title, slug;

    //Đổi chữ hoa thành chữ thường
    slug = title.toLowerCase();

    //Đổi ký tự có dấu thành không dấu
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
    slug = slug.replace(/đ/gi, 'd');
    //Xóa các ký tự đặt biệt
    slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
    //Đổi khoảng trắng thành ký tự gạch ngang
    slug = slug.replace(/ /gi, "-");
    //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
    //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
    slug = slug.replace(/\-\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-/gi, '-');
    slug = slug.replace(/\-\-/gi, '-');
    //Xóa các ký tự gạch ngang ở đầu và cuối
    slug = '@' + slug + '@';
    slug = slug.replace(/\@\-|\-\@|\@/gi, '');

    //return “slug”
    return slug;
}