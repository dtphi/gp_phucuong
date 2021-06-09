const path = require('path');
const envBuild = process.env.NODE_ENV;
let publicPath = '/';

if (envBuild === 'production') {
  publicPath = 'lcg-admin/';

  module.exports = {
    publicPath,
    productionSourceMap: false,
    filenameHashing:false,
    outputDir: path.resolve(__dirname, "../../public/lcg-admin"),
    indexPath: path.resolve(__dirname, "../views/lcg_admin/index.blade.php"),
    chainWebpack: (config) => {
      config.module.rule('vue').uses.delete('cache-loader');
      config.module.rule('js').uses.delete('cache-loader');
      config.plugins.delete('preload');
      config.plugins.delete('prefetch');
    },
  };
} else {
  module.exports = {
    publicPath,
    productionSourceMap: true,
  };
}
