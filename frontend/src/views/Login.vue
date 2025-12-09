<template>
  <div class="page-wrap">
    <div class="card">
      <div class="card-header">
        <h2>Welcome Back 👋</h2>
        <p class="subtitle">Log in to continue managing your tasks</p>
      </div>

      <div v-if="error" class="alert">
        {{ error }}
      </div>

      <form @submit.prevent="submit" class="form">
        <div class="field">
          <label>Email Address</label>
          <input
            v-model="form.email"
            type="email"
            placeholder="you@example.com"
            required
          />
        </div>

        <div class="field">
          <label>Password</label>
          <input
            v-model="form.password"
            type="password"
            placeholder="••••••••"
            required
          />
        </div>

        <button :disabled="loading" class="btn">
          {{ loading ? "Logging in..." : "Login" }}
        </button>
      </form>

      <p class="footer">
        Don’t have an account?
        <router-link to="/register" class="link">Create Account</router-link>
      </p>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { reactive, ref } from "vue";
import { useRouter } from "vue-router";
import { useUserStore } from "../store/userStore";

const router = useRouter();
const store = useUserStore();

const form = reactive({
  email: "",
  password: "",
});

const loading = ref(false);
const error = ref("");

const submit = async () => {
  loading.value = true;
  error.value = "";

  try {
    await store.loginUser(form);
    router.push("/");
  } catch (err: any) {
    error.value = err.response?.data?.message || "Login failed";
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
/* Page background */
.page-wrap {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 24px;
  background: linear-gradient(135deg, #f3f4f6 0%, #eef2f7 100%);
  font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
  -webkit-font-smoothing: antialiased;
}

/* Card */
.card {
  width: 100%;
  max-width: 420px;
  background: #ffffff;
  border-radius: 18px;
  padding: 36px;
  box-shadow: 0 16px 40px rgba(13, 20, 29, 0.08);
  border: 1px solid rgba(15,23,42,0.04);
}

/* Header */
.card-header h2 {
  margin: 0;
  font-size: 28px;
  line-height: 1.15;
  color: #0f172a;
  text-align: center;
  font-weight: 700;
}

.subtitle {
  margin: 8px 0 0;
  font-size: 13px;
  color: #6b7280;
  text-align: center;
}

/* Alert */
.alert {
  margin: 18px 0;
  background: #fff5f5;
  color: #b91c1c;
  border: 1px solid #fecaca;
  padding: 10px 12px;
  border-radius: 10px;
  font-size: 14px;
  text-align: center;
}

/* Form */
.form {
  margin-top: 6px;
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.field label {
  display: block;
  font-size: 13px;
  color: #374151;
  margin-bottom: 6px;
  font-weight: 600;
}

/* Inputs */
.field input {
  width: 100%;
  padding: 12px 14px;
  border-radius: 12px;
  border: 1px solid #d1d5db;
  background: #f8fafc;
  outline: none;
  font-size: 15px;
  transition: box-shadow .18s ease, border-color .18s ease, background .18s ease;
}

.field input:focus {
  background: #ffffff;
  border-color: #3b82f6; /* blue */
  box-shadow: 0 6px 18px rgba(59,130,246,0.12);
}

/* Button */
.btn {
  margin-top: 6px;
  width: 100%;
  padding: 12px 14px;
  border-radius: 12px;
  background: linear-gradient(180deg, #2563eb 0%, #1e40af 100%);
  color: #fff;
  border: none;
  font-weight: 700;
  font-size: 16px;
  cursor: pointer;
  box-shadow: 0 8px 20px rgba(37,99,235,0.18);
  transition: transform .08s ease, opacity .12s ease, box-shadow .12s ease;
}

.btn:hover:not([disabled]) {
  transform: translateY(-2px);
  box-shadow: 0 12px 28px rgba(37,99,235,0.2);
}

.btn:active:not([disabled]) {
  transform: translateY(0);
}

.btn[disabled] {
  opacity: 0.6;
  cursor: not-allowed;
  transform: none;
  box-shadow: none;
}

/* Footer text */
.footer {
  margin-top: 18px;
  text-align: center;
  color: #6b7280;
  font-size: 14px;
}

.link {
  color: #2563eb;
  font-weight: 700;
  margin-left: 6px;
  text-decoration: none;
}

.link:hover {
  text-decoration: underline;
}

/* Responsive tweaks */
@media (max-width: 480px) {
  .card {
    padding: 24px;
    border-radius: 14px;
  }
  .card-header h2 {
    font-size: 22px;
  }
}
</style>
