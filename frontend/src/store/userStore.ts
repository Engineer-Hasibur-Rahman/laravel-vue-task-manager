import { defineStore } from 'pinia';
import { login, logout, register, fetchUser } from '../services/authService';
import type { User } from '../types';

interface State {
  user: User | null;
  token: string | null;
}

export const useUserStore = defineStore('user', {
  state: (): State => ({
    user: null,
    token: localStorage.getItem('token'),
  }),
  actions: {
    async loginUser(credentials: { email: string; password: string }) {
      const res = await login(credentials);
      this.token = res.data.data.access_token;
      localStorage.setItem('token', this.token);
      await this.fetchUser();
    },
    async registerUser(data: { name: string; email: string; password: string; password_confirmation: string }) {
      await register(data);
    },
    async fetchUser() {
      const res = await fetchUser();
      this.user = res.data.data;
    },
    async logoutUser() {
      await logout();
      this.user = null;
      this.token = null;
      localStorage.removeItem('token');
    },
  },
});
