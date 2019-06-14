// let dataJson = require('/src/markup/pages/index/index__hero.json')

import gulp from 'gulp';
import gulpNotify from 'gulp-notify';
import gulpPlumber from 'gulp-plumber';
import gulpData from 'gulp-data';
import gulpPug from 'gulp-pug';

const taskName = 'pug';

const CONFIG_PUG = {
  // locals: ('./resources/views/pug/pages/**/*.json', 'utf8'),
  pretty: true
};


export default (config, browserSync, generateSubTasks) => {

  generateSubTasks(taskName, dir => () => {

    // Убираем читабельность html если выполняется таск build
    let configPug = Object.assign({}, CONFIG_PUG, {
      pretty: !config.isBuild
    });

    return gulp.src(dir.input + '/*.pug', { allowEmpty: true })
            .pipe(
              gulpPlumber({
                errorHandler: gulpNotify.onError('Pug: <%= error.message %>')
              })
            )
            .pipe(gulpData( file => ({
                  require: require,
                  fs : require("fs")
                })
            ))
            .pipe(gulpPug(configPug))
            .pipe(gulp.dest(dir.output));

  });

}

