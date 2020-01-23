import axios from 'axios';

const api = axios.create({
  baseURL: "http://omnistack.personalprojects/api/"
})

export default api;