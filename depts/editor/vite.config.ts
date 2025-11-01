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
        // disable caching-postfixes, because it will be created by symfony asset-mapper
        rollupOptions: {
            output: {
                entryFileNames: 'editor/[name].js',
                chunkFileNames: 'editor/[name].js',
                assetFileNames: (assetInfo) => {
                    const name = assetInfo.name ?? '';
                    if (name.endsWith('.css')) {
                        return 'editor/[name][extname]'; // kein [hash] für CSS
                    }
                    return 'editor/assets/[name]-[hash][extname]'; // Standard für andere Assets
                },
            },
        },
    },
});
