import { fileURLToPath, URL } from "node:url";

import { defineConfig, loadEnv } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

export default ({ mode }) => {
    process.env = { ...process.env, ...loadEnv(mode, process.cwd()) };

    return defineConfig({
        server: {
            host: process.env.VITE_HOST,
        },
        plugins: [
            laravel({
                input: ["resources/js/app.ts"],
                refresh: true,
            }),
            vue({
                template: {
                    transformAssetUrls: {
                        base: null,
                        includeAbsolute: false,
                    },
                },
            }),
        ],
        resolve: {
            alias: {
                "vue-i18n": "vue-i18n/dist/vue-i18n.cjs.js",
                "@": "/resources/js",
            },
        },
        optimizeDeps: {
            esbuildOptions: {
                target: ["es2020", "safari14"],
            },
        },
        build: {
            target: ["es2020", "safari14"],
            rollupOptions: {
                output: {
                    // expose jQuery as a global variable
                    globals: {
                        jquery: 'jQuery'
                    }
                }
            }
        },
    });
};
