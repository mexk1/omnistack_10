import axios from 'axios';

// axios.defaults.headers.post['Access-Control-Allow-Origin'] = '*';
// axios.defaults.headers.post['Content-Type'] = 'application/json';

// const  = axios.create({
  
// })
const api = axios.create({
  baseURL: "http://omnistack.personalprojects/api/",
  timeout: 10000,
  transformRequest: [(data) => JSON.stringify(data.data)],
});

export default api;