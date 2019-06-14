import gulp from 'gulp';
import gulpImagemin from 'gulp-imagemin';



export default config => {




   // Копируем спрайт и все прочие файлы в public/static
   gulp.task('svg:copy', () => gulp.src('resources/assets/static/img/**/*.svg').pipe(gulp.dest('public/static/img/')) );

  // Копируем с оптимизацией все файлы, кроме
  // и так оптимизированного спрайта и проблеменого dot.svg в public/build
  gulp.task('svg:build', () => gulp.src(['resources/assets/static/img/**/*.svg', '!resources/assets/static/img/svg/symbol/sprite.svg', '!resources/assets/static/img/dot.svg'])
      .pipe(gulpImagemin([
              gulpImagemin.svgo({
                plugins: [
                  {
                    removeViewBox: true
                  },
                  {
                    cleanupIDs: false
                  }
                ]
              })
            ], { verbose: true })
      )
      .pipe(gulp.dest('public/static/img/'))
  );

  // Копируем спрайт и dot.svg в public/static
  gulp.task('svg:sprite:copy', () => gulp.src(['resources/assets/static/img/svg/symbol/sprite.svg']).pipe(gulp.dest('public/static/img/svg/symbol/')));

  gulp.task('svg:dot:copy', () => gulp.src(['resources/assets/static/img/dot.svg']).pipe(gulp.dest('public/static/img/')));



}
