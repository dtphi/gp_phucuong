let baseUrl = window.origin;
if (process.env.NODE_ENV == "server") {
    //baseUrl = 'http://haydesachnoipodcast.com';
    baseUrl = 'http://localhost:8000';
}
if (process.env.NODE_ENV == "development") {
    //baseUrl = 'http://localhost:8000';
}

const ApiConfig = {
    baseURL: baseUrl,
    basePORT: 8000
};

module.exports = ApiConfig;