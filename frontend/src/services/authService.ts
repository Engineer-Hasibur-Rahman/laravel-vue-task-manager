import api from '../api/api';
import type { User } from '../types';

interface AuthResponse {
  user: User;
  access_token: string;
  token_type: string;
}

export const register = (data: { name: string; email: string; password: string; password_confirmation: string }) =>
  api.post('/register', data);

export const login = (data: { email: string; password: string }) =>
  api.post<{ data: AuthResponse }>('/login', data);

export const logout = () => api.post('/logout');

export const fetchUser = () => api.get<{ data: User }>('/user');
