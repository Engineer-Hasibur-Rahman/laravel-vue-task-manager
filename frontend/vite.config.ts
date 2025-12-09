import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueJsx from '@vitejs/plugin-vue-jsx'
import vueDevTools from 'vite-plugin-vue-devtools'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    vueJsx(),
    vueDevTools(),
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    },
  },

  server: {
    proxy: {
      // Proxy requests starting with '/api' to your Laravel backend
      '/api': {
        target: 'http://127.0.0.1:8000', // The address of your Laravel server
        changeOrigin: true, // Needed for virtual hosted sites
        secure: false, // Set to true if your backend uses HTTPS
        // rewrite: (path) => path.replace(/^\/api/, '') // You usually don't need this if your Laravel routes start with /api
      },

      // Optionally, you might need to proxy Sanctum cookies/CSRF if not handled otherwise
      '/sanctum/csrf-cookie': {
        target: 'http://127.0.0.1:8000',
        changeOrigin: true,
        secure: false,
      }
    },
  }
})
