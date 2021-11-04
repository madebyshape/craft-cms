const env = process.env.NODE_ENV ?? 'dev';

const package = require("./package.json"),
      webpackConfig = require('./webpack.' + env);

const gulp = require("gulp"),
      sass = require("gulp-sass"),
      postcss = require("gulp-postcss"),
      tailwindcss = require("tailwindcss"),
      browsersync = require("browser-sync"),
      sassglob = require("gulp-sass-glob"),
      sourcemaps = require("gulp-sourcemaps"),
      autoprefixer = require("autoprefixer"),
      cssnano = require("cssnano"),
      newer = require("gulp-newer"),
      imagemin = require("gulp-imagemin"),
      minify = require("gulp-minify"),
      purgecss = require("gulp-purgecss"),
      concat = require("gulp-concat"),
      favicons = require("favicons").stream,
      rev = require("gulp-rev"),
      revDel = require("rev-del"),
      plumber = require("gulp-plumber"),
      notify = require("gulp-notify"),
      critical = require("critical"),
      clean = require("gulp-dest-clean"),
      webpack = require('webpack'),
      webpackStream = require('webpack-stream');

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
      // require("@tailwindcss/jit"),
      autoprefixer()
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

   return gulp
      .src(package.paths.assets.base + package.files.assets.js)
      .pipe(plumber({ errorHandler: notify.onError("Error [js]: <%= error.message %>") }))
      .pipe(webpackStream(webpackConfig), webpack)
      .pipe(concat(package.files.dist.js))
      .pipe(sourcemaps.init())
      .pipe(sourcemaps.write("/"))
      .pipe(gulp.dest(package.paths.public + package.paths.dist.js))
      .pipe(browsersync.stream());
}

function minifyCss() {

   return gulp
      .src(package.paths.public + package.paths.dist.css + package.files.dist.css)
      .pipe(plumber({ errorHandler: notify.onError("Error [css]: <%= error.message %>") }))
      .pipe(postcss([cssnano()]))
      .pipe(gulp.dest(package.paths.public + package.paths.dist.css));

}

function minifyJs() {

   return gulp
      .src(package.paths.public + package.paths.dist.js + package.files.dist.js)
      .pipe(plumber({ errorHandler: notify.onError("Error [js]: <%= error.message %>") }))
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
      .pipe(gulp.dest(package.paths.public + package.paths.dist.js));

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
            	imagemin.mozjpeg({ progressive: true }),
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
            whitelist: package.purgeCss.whitelist,
            whitelistPatterns: whitelistPatterns,
            whitelistPatternsChildren: whitelistPatterns,
            defaultExtractor: content => content.match(/[\w-/:]+(?<!:)/g) || []
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

   critical.generate(
      {
         inline: false,
         base: './',
         src: package.env.local + element.uri,
         css: [package.paths.public + package.paths.dist.css + package.files.dist.css],
         width: 1920,
         height: 1200,
         target: {
            css: package.paths.templates + package.critical.dest + element.slug + ".css"
         },
         minify: true,
         extract: true
      }
   );

   callback();

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

function watch(done) {

   gulp.watch(
      [
         "package.json",
         package.files.tailwind,
         package.paths.assets.base + "**/*.{css,scss,vue}",
      ],
      css
   );

   gulp.watch(
      [
         "package.json",
         package.paths.assets.base + "**/*.{js,vue}"
      ],
      js
   );
      
   gulp.watch(package.paths.assets.images + "**/*", images);

   gulp.watch(package.paths.public + "**/*", browserSyncReload);

   gulp.watch(package.paths.templates + "**/*.{html,twig}", browserSyncReload);

   done();

}

exports.browserSync = browserSync;
exports.browserSyncReload = browserSyncReload;
exports.css = css;
exports.js = js;
exports.images = images;
exports.favicon = favicon;
exports.faviconHtml = faviconHtml;
exports.minifyCss = minifyCss;
exports.minifyJs = minifyJs;
exports.purgeCss = purgeCss;
exports.criticalCss = criticalCss;
exports.revCssJs = revCssJs;
exports.watch = watch;

exports.dev = gulp.series(css, js, images, watch, browserSync);

exports.prod = gulp.series(
   gulp.parallel(css, js),
   minifyCss,
   minifyJs,
   purgeCss,
   criticalCss,
   revCssJs,
   favicon,
   faviconHtml,
   images
);
