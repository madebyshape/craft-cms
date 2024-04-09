import { ViteImageOptimizer } from 'vite-plugin-image-optimizer';
import { ViteFaviconsPlugin } from 'vite-plugin-favicon2';
import copy from 'rollup-plugin-copy';

export default ({ command }) => ({
    base: command === 'serve' ? '' : '/dist/',
    publicDir: 'src/public',
    build: {
        outDir: 'web/dist/',
        emptyOutDir: true,
        sourcemap: true,
        manifest: 'manifest.json',
        minify: 'esbuild',
        rollupOptions: {
            input: {
                index: './src/index.js',
            },
            output: {
                dir: 'web/dist/',
            }
        },
    },
    server: {
        fs: {
          strict: false
        },
        host: '0.0.0.0',
        origin: 'http://localhost:3000',
        port: 3000,
        strictPort: true
    },
    plugins: [
        ViteFaviconsPlugin({
            logo: "src/public/images/favicon.png",
            inject: false,
            outputPath: '../favicons'
        }),
        copy({
            targets: [
                { 
                    src: 'src/public/**/*', 
                    dest: 'web/dist'
                }
            ]
        }),
        ViteImageOptimizer({})
    ]
});