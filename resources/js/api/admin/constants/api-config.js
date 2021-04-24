let baseUrl = window.origin;
if (process.env.NODE_ENV == "server") {
    baseUrl = 'http://haydesachnoipodcast.com';
}

const ApiConfig = {
    baseURL: baseUrl,
    basePORT: 8000
};

module.exports = ApiConfig;