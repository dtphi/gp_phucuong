let imagesPath = process.env.VUE_APP_IMAGES_PATH
export default({
	logoPath: imagesPath + 'logo.png',
	imagesPath: imagesPath,
	envCur: process.env,
})