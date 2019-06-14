module.exports = function () {
  // Сторонние библиотеки и плагины
  $.gulp.task('js:lib', function () {
    return $.gulp.src([
      'node_modules/lazysizes/lazysizes.js',
      'resources/assets/static/libs/lazysizes/ls.unveilhooks.js',
      'node_modules/smooth-scroll/dist/smooth-scroll.js',
      'node_modules/aos/dist/aos.js',
      'node_modules/swiper/dist/js/swiper.js',
      'node_modules/Tabby/dist/js/tabby.js',
      'node_modules/imask/dist/imask.js',
      'node_modules/autosize/dist/autosize.js',
      'node_modules/rellax/rellax.js',
      'node_modules/ilyabirman-likely/release/likely.js'
    ])
      .pipe($.gp.plumber({
        errorHandler: $.gp.notify.onError({
          title: 'js:lib',
          message: '<%= error.message %>',
        })
      }))
      .pipe($.gp.concat('libs.js'))
      .pipe($.gulp.dest('resources/assets/js/'));
  });

  // Модули проекта
  $.gulp.task('js:modules', function () {
    return $.gulp.src('resources/assets/js/modules/*.js')
      .pipe($.gp.plumber({
        errorHandler: $.gp.notify.onError({
          title: 'js:modules',
          message: '<%= error.message %>',
        })
      }))
      .pipe($.gp.concat('modules.js'))
      .pipe($.gulp.dest('resources/assets/js/'));
  });

  // Постраничные модули проекта
  // Страница index
  $.gulp.task('js:modules--index', function () {
    return $.gulp.src('resources/assets/js/pages/index/*.js')
      .pipe($.gp.plumber({
        errorHandler: $.gp.notify.onError({
          title: 'js:modules--index',
          message: '<%= error.message %>',
        })
      }))
      .pipe($.gp.concat('index.js'))
      .pipe($.gulp.dest('resources/assets/js/pages'));
  });

  // Страница schedule
  $.gulp.task('js:modules--schedule', function () {
    return $.gulp.src('resources/assets/js/pages/schedule/*.js')
      .pipe($.gp.plumber({
        errorHandler: $.gp.notify.onError({
          title: 'js:modules--schedule',
          message: '<%= error.message %>',
        })
      }))
      .pipe($.gp.concat('schedule.js'))
      .pipe($.gulp.dest('resources/assets/js/pages'));
  });

  // Страница dream team
  $.gulp.task('js:modules--dt', function () {
    return $.gulp.src('resources/assets/js/pages/dream-team/*.js')
      .pipe($.gp.plumber({
        errorHandler: $.gp.notify.onError({
          title: 'js:modules--dt',
          message: '<%= error.message %>',
        })
      }))
      .pipe($.gp.concat('dream-team.js'))
      .pipe($.gulp.dest('resources/assets/js/pages'));
  });

  // Страница правил
  $.gulp.task('js:modules--rules', function () {
    return $.gulp.src('resources/assets/js/pages/rules/*.js')
      .pipe($.gp.plumber({
        errorHandler: $.gp.notify.onError({
          title: 'js:modules--rules',
          message: '<%= error.message %>',
        })
      }))
      .pipe($.gp.concat('rules.js'))
      .pipe($.gulp.dest('resources/assets/js/pages'));
  });

  // Страницы buying/installment
  $.gulp.task('js:modules--order', function () {
    return $.gulp.src('resources/assets/js/pages/order/*.js')
      .pipe($.gp.plumber({
        errorHandler: $.gp.notify.onError({
          title: 'js:modules--order',
          message: '<%= error.message %>',
        })
      }))
      .pipe($.gp.concat('order.js'))
      .pipe($.gulp.dest('resources/assets/js/pages'));
  });

  // Страница новостей
  $.gulp.task('js:modules--news', function () {
    return $.gulp.src('resources/assets/js/pages/news/*.js')
      .pipe($.gp.plumber({
        errorHandler: $.gp.notify.onError({
          title: 'js:modules--news',
          message: '<%= error.message %>',
        })
      }))
      .pipe($.gp.concat('news.js'))
      .pipe($.gulp.dest('resources/assets/js/pages'));
  });

  // Страница новости
  $.gulp.task('js:modules--article', function () {
    return $.gulp.src('resources/assets/js/pages/article/*.js')
      .pipe($.gp.plumber({
        errorHandler: $.gp.notify.onError({
          title: 'js:modules--article',
          message: '<%= error.message %>',
        })
      }))
      .pipe($.gp.concat('article.js'))
      .pipe($.gulp.dest('resources/assets/js/pages'));
  });



  // Собирает в два одинаковых файла с разным названием
  $.gulp.task('js:dev', function () {
    return $.gulp.src([
      'resources/assets/js/libs.js',
      'resources/assets/js/modules.js'
    ])
      .pipe($.gp.plumber({
        errorHandler: $.gp.notify.onError({
          title: 'js:dev',
          message: '<%= error.message %>',
        })
      }))
      .pipe($.gp.concat('scripts.js'))
      .pipe($.gulp.dest('public/static/js/'))
      .pipe($.gp.rename('scripts.min.js'))
      .pipe($.gulp.dest('public/static/js/'));
  });

  // Переносит модули страниц в два одинаковых файла с разным названием
  $.gulp.task('js:dev:page-scripts', function () {
    return $.gulp.src('resources/assets/js/pages/*.js')
      .pipe($.gp.plumber({
        errorHandler: $.gp.notify.onError({
          title: 'js:dev:page-scripts',
          message: '<%= error.message %>',
        })
      }))
      .pipe($.gulp.dest('public/static/js/'))
      .pipe($.gp.rename({
        suffix: '.min'
      }))
      .pipe($.gulp.dest('public/static/js/'));
  });

  // Собирает и минифицирует
  $.gulp.task('js:build', function () {
    return $.gulp.src([
      'resources/assets/js/libs.js',
      'resources/assets/js/modules.js'
    ])
      .pipe($.gp.plumber({
        errorHandler: $.gp.notify.onError({
          title: 'js:modules',
          message: '<%= error.message %>',
        })
      }))
      .pipe($.gp.concat('scripts.js'))
      .pipe($.gulp.dest('public/static/js/'))
      .pipe($.uglify())
      .pipe($.gp.rename('scripts.min.js'))
      .pipe($.gulp.dest('public/static/js/'));
  });

  // Переносит модули страниц и минифицирует
  $.gulp.task('js:build:page-scripts', function () {
    return $.gulp.src('resources/assets/js/pages/*.js')
      .pipe($.gp.plumber({
        errorHandler: $.gp.notify.onError({
          title: 'js:dev:page-scripts',
          message: '<%= error.message %>',
        })
      }))
      .pipe($.gulp.dest('public/static/js/'))
      .pipe($.gp.rename({
        suffix: '.min'
      }))
      .pipe($.uglify())
      .pipe($.gulp.dest('public/static/js/'));
  });
};
