import { createRouter, createWebHistory } from 'vue-router';
import type { RouteRecordRaw } from 'vue-router';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
import Tasks from '../views/Tasks.vue';
import { useUserStore } from '../store/userStore';

const routes: RouteRecordRaw[] = [
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '/', component: Tasks, meta: { requiresAuth: true } },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const store = useUserStore();
  if (to.meta.requiresAuth && !store.token) {
    next('/login');
  } else {
    next();
  }
});

export default router;
