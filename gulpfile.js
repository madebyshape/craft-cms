const package = require("./package.json");

const gulp = require("gulp");
const sass = require("gulp-sass");
const postcss = require("gulp-postcss");
const tailwindcss = require("tailwindcss");
const browsersync = require("browser-sync").create();
const sassglob = require("gulp-sass-glob");
const sourcemaps = require("gulp-sourcemaps");
const autoprefixer = require("autoprefixer");
const cssnano = require("cssnano");
const newer = require("gulp-newer");
const imagemin = require("gulp-imagemin");
const minify = require("gulp-minify");
const modernizr = require("gulp-modernizr");
const purgecss = require("gulp-purgecss");
const concat = require("gulp-concat");
const favicons = require("favicons").stream;
const rev = require("gulp-rev");
const revDel = require("rev-del");
const plumber = require("gulp-plumber");
const notify = require("gulp-notify");
const del = require("del");
const critical = require("critical");
const clean = require("gulp-dest-clean");

function browserSync(done) {

   if (package.env.local === "") {
      browsersync.init({
         server: {
            baseDir: package.paths.public
         }
      });
   }
   else {
      browsersync.init({
         proxy: package.env.local
      });
   }
   done();

}

function browserSyncReload(done) {

   browsersync.reload();
   done();

}

function css() {

   const cssFiles = [
      package.paths.assets.scss + package.files.assets.scss
   ];

   for (var i = 0; i < package.cssDependencies.length; i++) {
      cssFiles.unshift(package.paths.dependencies + package.cssDependencies[i]);
   }

   const plugins = [
      tailwindcss(package.files.tailwind),
      autoprefixer(),
      cssnano()
   ];

   return gulp
      .src(cssFiles)
      .pipe(plumber({ errorHandler: notify.onError("Error [css]: <%= error.message %>") }))
      .pipe(concat(package.files.dist.css))
      .pipe(sourcemaps.init())
      .pipe(sassglob())
      .pipe(sass())
      .pipe(postcss(plugins))
      .pipe(sourcemaps.write("/"))
      .pipe(gulp.dest(package.paths.public + package.paths.dist.css))
      .pipe(browsersync.stream());

}

function js() {

   const jsArray = [];

   const jsFiles = [
      "modernizr.js",
      "components/**/*.js",
      package.files.assets.js
   ];

   for (var i = 0; i < package.jsDependencies.length; i++) {
      jsArray.push(package.paths.dependencies + package.jsDependencies[i]);
   }

   for (var i = 0; i < jsFiles.length; i++) {
      jsArray.push(package.paths.assets.js + jsFiles[i]);
   }

   return gulp
      .src(jsArray)
      .pipe(plumber({ errorHandler: notify.onError("Error [js]: <%= error.message %>") }))
      .pipe(concat(package.files.dist.js))
      .pipe(sourcemaps.init())
      .pipe(
         minify(
            {
               ext:{
                  min:".js"
               },
               noSource: true
            }
         )
      )
      .pipe(sourcemaps.write("/"))
      .pipe(gulp.dest(package.paths.public + package.paths.dist.js))
      .pipe(browsersync.stream());
}

function images() {

   return gulp
      .src(package.paths.assets.images + "**/*")
      .pipe(plumber({ errorHandler: notify.onError("Error [images]: <%= error.message %>") }))
      .pipe(clean(package.paths.public + package.paths.dist.images, 'favicon/**'))
      .pipe(newer(package.paths.public + package.paths.dist.images))
      .pipe(
         imagemin(
            [
            	imagemin.gifsicle({ interlaced: true }),
            	imagemin.jpegtran({ progressive: true }),
            	imagemin.optipng({ optimizationLevel: 5 }),
            	imagemin.svgo({
            		plugins: [
            			{ removeViewBox: true },
            			{ cleanupIDs: false }
            		]
            	})
            ],
            { verbose: true }
         )
      )
      .pipe(gulp.dest(package.paths.public + package.paths.dist.images));

}

function favicon() {

   return gulp
      .src(package.paths.assets.images + "favicon.{jpg,png}")
      .pipe(plumber({ errorHandler: notify.onError("Error [favicon]: <%= error.message %>") }))
      .pipe(newer(package.paths.public + package.paths.dist.images + "favicon.{jpg,png}"))
      .pipe(
         favicons(
            {
               appName: package.name,
               appDescription: package.description,
               developerName: package.author,
               developerURL: package.authorUrl,
               background: "#FFF",
               display: "standalone",
               orientation: "any",
               version: 1.0,
               html: "favicons.html",
               pipeHTML: true,
               replace: true,
               path: "/" + package.paths.dist.favicon,
               icons: {
                  favicons: true,
                  android: true,
                  appleIcon: true,
                  firefox: true,
                  windows: true,
                  appleStartup: false,
                  coast: false,
                  opengraph: false,
                  twitter: false,
                  yandex: false
               }
            }
         )
      )
      .pipe(gulp.dest(package.paths.public + package.paths.dist.favicon));

}

function faviconHtml() {
   return gulp
         .src(
            package.paths.public + package.paths.dist.favicon + "favicons.html"
         )
         .pipe(
            gulp.dest(package.paths.templates + "_components/")
         );
}

function purgeCss() {

   class TailwindExtractor {
      static extract(content) {
         return content.match(/[A-z0-9-:\/]+/g);
      }
   }

   var whitelistPatterns = [];
   for (i = 0; i < package.purgeCss.whitelistPatterns.length; i++) {
      whitelistPatterns.push(new RegExp(package.purgeCss.whitelistPatterns[i], ""));
    }

   return gulp
      .src(package.paths.public + package.paths.dist.css + package.files.dist.css)
      .pipe(plumber({ errorHandler: notify.onError("Error [purgeCss]: <%= error.message %>") }))
      .pipe(
         purgecss({
            content: [
               package.paths.templates + "**/*.{html,twig,vue}",
               package.paths.public + package.paths.dist.base + "**/*.{js}"
            ],
            whitelistPatterns: whitelistPatterns,
            whitelistPatternsChildren: whitelistPatterns,
            extractors: [
               {
                  extractor: TailwindExtractor,
                  extensions: ["html", "twig", "vue"]
               }
            ]
         })
      )
      .pipe(gulp.dest(package.paths.public + package.paths.dist.css));

}

function doSynchronousLoop(data, processData, done) {

   if (data.length > 0) {
      const loop = (data, i, processData, done) => {
         processData(data[i], i, () => {
            if (++i < data.length) {
               loop(data, i, processData, done);
            } else {
               done();
            }
         });
      };
      loop(data, 0, processData, done);
   } else {
      done();
   }

}

const processCriticalCSS = (element, i, callback) => {

   critical
      .generate({
            src: package.critical.url + element.url,
            dest: package.templates + element.path + element.slug + "-critical.css",
            inline: false,
            ignore: [],
            bbase: "./",
            pathPrefix: "/",
            css: [package.files.dist.css],
            width: 1400,
            height: 900,
            minify: true,
            timeout: 60000
         },
         (err, output) => {
            if (err) {
               notify({
                  message: "Error [processCriticalCSS]: " + err
               })
            }
            callback();
         }
      );

}

function criticalCss(done) {

   doSynchronousLoop(
      package.critical.elements,
      processCriticalCSS,
      () => {
         done();
      }
   );

}

function revCssJs(done) {

   return gulp
      .src(
         [
            package.paths.public + package.paths.dist.css + package.files.dist.css,
            package.paths.public + package.paths.dist.js + package.files.dist.js
         ],
         {
            base: package.paths.public + package.paths.dist.base
         }
      )
      .pipe(rev())
      .pipe(gulp.dest(package.paths.public + package.paths.dist.base))
      .pipe(rev.manifest(
         {
            base: "./"
         }
      ))
      .pipe(revDel(
         {
            oldManifest: "./rev-manifest.json",
            dest: package.paths.public + package.paths.dist.base
         }
      ))
      .pipe(gulp.dest("./"));

}

function browserFeatures() {

   return gulp
      .src(package.paths.assets.js + "**/*")
      .pipe(modernizr())
      .pipe(gulp.dest(package.paths.assets.js));

}

function watch(done) {

   gulp.watch(
      [
         "package.json",
         package.files.tailwind,
         package.paths.assets.scss + "**/*",
      ],
      css
   );

   gulp.watch(
      [
         "package.json",
         package.paths.assets.js + "**/*"
      ],
      js
   );

   gulp.watch(package.paths.public + "**/*", browserSyncReload);

   gulp.watch(package.paths.templates + "**/*.{html,twig,vue}", browserSyncReload);

   gulp.watch(package.paths.assets.images + "**/*", images);

   done();

}

exports.browserSync = browserSync;
exports.browserSyncReload = browserSyncReload;
exports.css = css;
exports.js = js;
exports.images = images;
exports.favicon = favicon;
exports.faviconHtml = faviconHtml;
exports.purgeCss = purgeCss;
exports.criticalCss = criticalCss;
exports.revCssJs = revCssJs;
exports.browserFeatures = browserFeatures;
exports.watch = watch;

exports.dev = gulp.series(browserFeatures, css, js, images, watch, browserSync);
exports.production = gulp.series(
   gulp.parallel(browserFeatures, css, js),
   purgeCss,
   criticalCss,
   revCssJs,
   favicon,
   faviconHtml,
   images
);