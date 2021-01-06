const path = require('path');
const envBuild = process.env.NODE_ENV;
if (envBuild === 'production') {
  let publicPath = 'lcg-front/';

  module.exports = {
    publicPath,
    productionSourceMap: false,
    filenameHashing:false,
    outputDir: path.resolve(__dirname, "../../public/lcg-front"),
    indexPath: path.resolve(__dirname, "../views/lcg_front/index.blade.php"),
    chainWebpack: config => {
      config
        .plugin('html')
        .tap(args => {
        args[0].title = 'Lịch Công Giáo';
        return args;
      });
      //config.resolve.symlinks(false)
    }
  };
} else {
  let publicPath = '/';

  module.exports = {
    publicPath,
    productionSourceMap: false,
    filenameHashing:true,
  };
}


