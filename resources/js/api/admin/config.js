const envBuild = process.env.NODE_ENV;
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
	existStatus: existStatus
};