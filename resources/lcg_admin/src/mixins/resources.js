let baseUri = process.env.VUE_APP_BASE_URI
export default({
	logoPath: baseUri + 'images/logo.png',
	baseUri: baseUri,
	envCur: process.env,
})