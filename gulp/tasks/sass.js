import gulp from 'gulp';
import gulpNotify from 'gulp-notify';
import gulpPlumber from 'gulp-plumber';

import gcmq from 'gulp-group-css-media-queries';
import gulpAutoprefixer from 'gulp-autoprefixer';
import gulpSass from 'gulp-sass';
import gulpCsso from 'gulp-csso';
import gulpRename from 'gulp-rename';

const taskName = 'sass';

const CONFIG_SASS = {
  outputStyle: 'expand',
  includePaths: [
    'node_modules'
  ]
};

export default (config, browserSync, generateSubTasks) => {

  generateSubTasks(taskName, dir => () => {

    let task = gulp.src(dir.input + '/style.sass', {
      allowEmpty: true
    })
      .pipe(gulpPlumber({
        errorHandler: gulpNotify.onError({
          title: 'sass',
          message: '<%= error.message %>',
        })
      }))
      .pipe(gulpSass(CONFIG_SASS))
      .pipe(gulpAutoprefixer({
        browsers: [
          "last 2 versions"
        ]
      }))
      .pipe(gulpRename({
        suffix: ".min"
      }));

    if (config.isBuild) task
      .pipe(gulpCsso({
        restructure: false
      }))
      .pipe(gulp.dest(dir.output + '/css'));

    if (!config.isBuild) task
      .pipe(gulp.dest(dir.output + '/css'))
      .pipe(browserSync.reload({
        stream: true
      }));

    return task;

  });

}
