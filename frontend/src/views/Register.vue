<script lang="ts" setup>
import { ref } from 'vue';
import api from '../api/api';
import { useRouter } from 'vue-router';

const router = useRouter();

const name = ref('');
const email = ref('');
const password = ref('');
const password_confirmation = ref('');
const errorMessage = ref('');

const register = async () => {
  errorMessage.value = '';
  try {
    const res = await api.post('/register', {
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value,
    });

    router.push('/login');
  } catch (err: any) {
    if (err.response?.data?.errors) {
      const messages = Object.values(err.response.data.errors).flat();
      errorMessage.value = messages.join(', ');
    } else if (err.response?.data?.message) {
      errorMessage.value = err.response.data.message;
    } else {
      errorMessage.value = 'Registration failed. Please try again.';
    }
  }
};
</script>

<template>
  <div class="auth-wrapper">
    <div class="auth-card">
      <h2 class="title">Create Account</h2>

      <div v-if="errorMessage" class="error-box">
        {{ errorMessage }}
      </div>

      <form @submit.prevent="register" class="form">
        <input v-model="name" type="text" placeholder="Name" class="input" />
        <input v-model="email" type="email" placeholder="Email" class="input" />
        <input v-model="password" type="password" placeholder="Password" class="input" />
        <input v-model="password_confirmation" type="password" placeholder="Confirm Password" class="input" />

        <button class="btn" type="submit">
          Register
        </button>
      </form>

      <p class="footer-text">
        Already have an account?
        <router-link to="/login" class="link">Login</router-link>
      </p>
    </div>
  </div>
</template>

<style scoped>
.auth-wrapper {
  min-height: 100vh;
  background: #f3f4f6;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
}

.auth-card {
  background: #fff;
  width: 100%;
  max-width: 420px;
  padding: 32px;
  border-radius: 16px;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
  text-align: center;
}

.title {
  margin-bottom: 20px;
  font-size: 26px;
  font-weight: 700;
  color: #111827;
}

.error-box {
  background: #fee2e2;
  color: #b91c1c;
  padding: 12px;
  border-radius: 8px;
  font-size: 14px;
  margin-bottom: 16px;
}

.form {
  display: flex;
  flex-direction: column;
  gap: 14px;
}

.input {
  padding: 12px 14px;
  border: 1px solid #d1d5db;
  border-radius: 8px;
  font-size: 15px;
  outline: none;
  transition: 0.25s;
}

.input:focus {
  border-color: #2563eb;
  box-shadow: 0 0 0 2px #2563eb30;
}

.btn {
  margin-top: 10px;
  background: #2563eb;
  color: white;
  padding: 12px;
  font-size: 16px;
  border-radius: 8px;
  font-weight: 600;
  transition: 0.25s;
  cursor: pointer;
  border: none;
}

.btn:hover {
  background: #1d4ed8;
}

.footer-text {
  margin-top: 16px;
  font-size: 14px;
  color: #6b7280;
}

.link {
  color: #2563eb;
  font-weight: 600;
  text-decoration: none;
}

.link:hover {
  text-decoration: underline;
}
</style>
