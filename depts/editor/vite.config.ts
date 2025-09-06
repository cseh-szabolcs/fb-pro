import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
import path from 'path';

// https://vite.dev/config/
export default defineConfig({
    plugins: [react()],
    server: {
        port: 8081,
        strictPort: true,
        host: true,
        origin: "http://0.0.0.0:8081",
    },
    resolve: {
        alias: {
            'app': path.resolve(__dirname, './src'),
        }
    },
    build: {
        target: 'esnext',
    },
});
