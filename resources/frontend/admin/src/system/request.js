import axios from 'axios';

const service = axios.create({
	baseURL: process.env.BASE_API,
	// headers: {'Authorization': 'Bearer' + localStorage.getItem("userToken")},
	headers: {
		'Access-Control-Allow-Origin': '*',
		'Content-Type':  'application/json',
	},
	timeout: 90000
});

service.interceptors.request.use(function (config) {
	// Do something before request is sent
	return config;
}, function (error) {
	// Do something with request error
	return Promise.reject(error);
});

service.interceptors.response.use(function (response) {
	// Any status code that lie within the range of 2xx cause this function to trigger
	// Do something with response data
	return response;
}, function (error) {
	// Any status codes that falls outside the range of 2xx cause this function to trigger
	// Do something with response error
	return Promise.reject(error);
});


export default service;