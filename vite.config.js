export default ({ command }) => ({
    base: command === 'serve' ? '' : '/dist/',
    publicDir: 'web',
    build: {
        outDir: 'web/dist/',
        sourcemap: true,
        manifest: 'manifest.json',
        minify: 'esbuild',
        rollupOptions: {
            input: {
                index: './src/index.js',
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
    }
});