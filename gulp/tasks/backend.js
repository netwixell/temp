module.exports = function () {
  $.gulp.task('backend:build', function () {
    return $.gulp.src(['resources/assets/static/backend/*', 'resources/assets/static/backend/.htaccess', '!resources/assets/static/backend/*.txt'])
      .pipe($.gulp.dest('public/'));
  });

  $.gulp.task('robots-stage:build', function () {
    return $.gulp.src('resources/assets/static/backend/robots-stage.txt')
      .pipe($.gp.rename('robots.txt'))
      .pipe($.gulp.dest('public/'));
  });

  $.gulp.task('robots-prod:build', function () {
    return $.gulp.src('resources/assets/static/backend/robots-prod.txt')
      .pipe($.gp.rename('robots.txt'))
      .pipe($.gulp.dest('public/'));
  });
};
