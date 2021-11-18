const envBuild = process.env.NODE_ENV;
var pathArray = (envBuild === "production")?process.env.MIX_APP_ADMIN_API_ROUTE_LOGIN.split(","):[];
var _adminPathName = (envBuild === "production")?pathArray[0]:"adminlocal";
let baseUrl = window.origin;
if (envBuild == "server") {
    baseUrl = 'http://haydesachnoipodcast.com';
}

const existStatus = {
	checking: 'checking',
	exist: 'exit',
	notExist: 'notExist'
}

export const config = {
	site_name: 'GP-PhuCuong',
	baseUrl: baseUrl,
	existStatus: existStatus,
	adminPrefix: _adminPathName
};