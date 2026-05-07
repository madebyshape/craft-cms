import { ViteImageOptimizer } from "vite-plugin-image-optimizer";
import tailwindcss from "@tailwindcss/vite";
import path from "node:path";

const reloadTemplates = () => ({
	name: "reload-craft-templates",
	handleHotUpdate({ file, server }) {
		if (file.includes(`${path.sep}templates${path.sep}`)) {
			server.ws.send({ type: "full-reload" });
		}
	},
});

export default ({ command }) => ({
	base: command === "serve" ? "" : `${process.env.CRAFT_CLOUD_ARTIFACT_BASE_URL || ""}/dist/`,
	publicDir: "src/public",
	build: {
		outDir: "web/dist/",
		emptyOutDir: true,
		sourcemap: true,
		manifest: "manifest.json",
		minify: "esbuild",
		rollupOptions: {
			input: {
				index: "./src/index.js",
			},
			output: {
				dir: "web/dist/",
			},
		},
	},
	server: {
		fs: {
			strict: false,
		},
		host: "0.0.0.0",
		origin: "http://localhost:3000",
		port: 3000,
		strictPort: true,
		cors: true,
		headers: {
			"Access-Control-Allow-Origin": "*",
		},
		allowedHosts: true,
	},
	plugins: [
		tailwindcss(),
		reloadTemplates(),
		ViteImageOptimizer({
			include: [
				"chevron-down-dark.svg",
				"chevron-down-light.svg",
				"fallback.png",
				"favicon.png",
			],
		}),
	],
});
