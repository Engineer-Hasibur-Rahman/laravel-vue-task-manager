import axios from 'axios';

const api = axios.create({
  baseURL: '/api', // proxied to Laravel backend
  headers: {
    'Content-Type': 'application/json',
  },
  withCredentials: true // Required for Sanctum SPA auth
});

// Add token if stored
api.interceptors.request.use(config => {
  const token = localStorage.getItem('token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

export default api;
