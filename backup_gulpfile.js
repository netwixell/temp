'use strict';

global.$ = {
  gulp: require('gulp'),
  gp: require('gulp-load-plugins')(),
  del: require('del'),
  browserSync: require('browser-sync').create(),
  mozjpeg: require('imagemin-mozjpeg'),
  pngquant: require('imagemin-pngquant'),
  gcmq: require('gulp-group-css-media-queries'),
  uglify: require('gulp-uglify-es').default,

  path: {
    tasks: require('./gulp/config/tasks')
  }
};

// проходимся по массиву в /gulp/config/tasks.js
// и как бы require-им его сюда
$.path.tasks.forEach(function (taskPath) {
  require(taskPath)();
});

$.gulp.task('default', $.gulp.series(
  'clean',
  'js:lib',
  $.gulp.parallel('js:modules', 'js:modules--index', 'js:modules--schedule', 'js:modules--dt', 'js:modules--order', 'js:modules--rules', 'js:modules--news', 'js:modules--article'),
  $.gulp.parallel('pug:dev', 'sass:dev', 'js:dev', 'js:dev:page-scripts', 'img:dev'),
  'svg:sprite',
  'svg:copy',
  $.gulp.parallel('backend:build', 'robots-stage:build'),
  $.gulp.parallel('watch', 'serve')
));

$.gulp.task('build-stage', $.gulp.series(
  'clean',
  'js:lib',
  $.gulp.parallel('js:modules', 'js:modules--index', 'js:modules--schedule', 'js:modules--dt', 'js:modules--order', 'js:modules--rules', 'js:modules--news', 'js:modules--article'),
  $.gulp.parallel('sass:build', 'js:build', 'js:build:page-scripts', 'img:build'),
  'svg:sprite',
  'svg:build',
  $.gulp.parallel('svg:sprite:copy', 'svg:dot:copy'),
  $.gulp.parallel('backend:build', 'robots-stage:build')
));

$.gulp.task('build', $.gulp.series(
  'clean',
  'js:lib',
  $.gulp.parallel('js:modules', 'js:modules--index', 'js:modules--schedule', 'js:modules--dt', 'js:modules--order', 'js:modules--rules', 'js:modules--news', 'js:modules--article'),
  $.gulp.parallel('sass:build', 'js:build', 'js:build:page-scripts', 'img:build'),
  'svg:sprite',
  'svg:build',
  $.gulp.parallel('svg:sprite:copy', 'svg:dot:copy'),
  $.gulp.parallel('backend:build', 'robots-prod:build')
));
