// Initialize modules 
const {src, dest, watch, series, parallel } = require('gulp');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const postcss = require('gulp-postcss');
const replace = require('gulp-replace');
const sass = require('gulp-sass');
const sourcemaps = require('gulp-sourcemaps');
const browserSync = require('browser-sync').create();
const concat = require('gulp-concat');
const settings = require('./settings');
const webpack = require('webpack');
// File path variables
const jsSrc = 'src/js/';

const files = {
  scssPath : 'src/scss/**/*.scss',
  jsFiles : [
  jsSrc + 'scripts.js'
  ],
  phpPath: './**/*.php'
}

// Sass Task
function scssTask()  {
  return src('src/scss/index.scss')
  .pipe(sass().on('error', sass.logError))
  .pipe(postcss([autoprefixer() , cssnano() ]))
  .pipe(dest('dist'))
  .pipe(browserSync.stream());
}

// Js Task
function jsTask(callback) {
   webpack(require('./webpack.config.js'), function(err, stats) {
      if (err) {
        console.log(err.toString());
      }
      console.log(stats.toString());
    });
    callback();
}
// Cache Busting Task
const cbString = new Date().getTime();
function cacheBusting() {
  return src(['index.php'])
  .pipe(replace(/cb=\d+/g , 'cb=' + cbString))
  .pipe(dest('.'));
}

// Watch function
function watchTask() {
  browserSync.init({
    notify: false,
    proxy: settings.urlToPreview,
    ghostMode: false
  });
  // watch([files.scssPath, files.jsPath] , parallel(scssTask , jsTask));
  watch(files.scssPath , scssTask);
  watch(jsSrc , jsTask);
  watch(jsSrc).on('change', browserSync.reload);
  watch(files.phpPath).on('change', browserSync.reload);
}

exports.scss = scssTask;
exports.js = jsTask;
exports.default = series(
  parallel(scssTask , jsTask),
  cacheBusting,
  watchTask
  );