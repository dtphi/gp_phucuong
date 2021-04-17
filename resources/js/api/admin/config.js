const envBuild = process.env.NODE_ENV;

const existStatus = {
	checking: 'checking',
	exist: 'exit',
	notExist: 'notExist'
}

export const config = {
	site_name: 'GP-PhuCuong',
	baseUrl: window.origin,
	existStatus: existStatus
};