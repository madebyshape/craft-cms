import { ViteImageOptimizer } from "vite-plugin-image-optimizer";
import ViteRestart from "vite-plugin-restart";
import tailwindcss from "@tailwindcss/vite";
import fs from "node:fs/promises";
import path from "node:path";
import { faviconsPlugin } from "vite-plugin-favicons";

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
		ViteRestart({
			reload: ["templates/**/*"],
		}),
		faviconsPlugin({
			imgSrc: "src/public/images/favicon.png",
			// Generates: src/public/favicons/favicon.html + icon files
			path: "/favicons",
		}),
		// Keep favicon URLs consistent with the existing Craft config/routes (`/dist/favicons/...`).
		{
			name: "rewrite-favicons-html",
			apply: "build",
			enforce: "post",
			async buildStart() {
				const faviconHtmlPath = path.resolve("src/public/favicons/favicon.html");
				try {
					const html = await fs.readFile(faviconHtmlPath, "utf8");
					const rewritten = html
						// favicons plugin uses `/favicons/...` based on its `path` option.
						.replaceAll("/favicons/", "/dist/favicons/")
						.replaceAll('href="/favicons"', 'href="/dist/favicons"');

					if (rewritten !== html) {
						await fs.writeFile(faviconHtmlPath, rewritten, "utf8");
					}
				} catch {
					// Ignore if file doesn't exist yet (e.g., plugin failures) so build can surface real issues elsewhere.
				}
			},
		},
		ViteImageOptimizer({}),
	],
});
