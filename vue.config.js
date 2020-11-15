module.exports = {
    publicPath: '',
    devServer: {
        proxy: {
            '^/api/': {
                target: 'http://localhost/home2/',
                changeOrigin: true, // so CORS doesn't bite us.
            }
        }
    }
};