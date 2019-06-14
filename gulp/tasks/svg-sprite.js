import gulp from 'gulp';

import gulpCheerio from 'gulp-cheerio';
import gulpSvgmin from 'gulp-svgmin';
import gulpReplace from 'gulp-replace';
import gulpSvgSprite from 'gulp-svg-sprite';

const taskName = 'svg-sprite';

export default (config, browserSync, generateSubTasks) => {

  generateSubTasks(taskName, dir => () => {

    return gulp.src(dir.input + '/svg-sprite/svg/*.svg')
            .pipe(gulpSvgmin({
              js2svg: {
                pretty: true
              }
            }))
            .pipe(gulpCheerio({
              run: $ => {
                $('[fill]').removeAttr('fill');
                $('[stroke]').removeAttr('stroke');
                $('[style]').removeAttr('style');
              },
              parserOptions: {
                xmlMode: true
              }
            }))
            .pipe(gulpReplace('&gt;', '>'))
            .pipe(gulpSvgSprite({
              mode: {
                symbol: {
                  sprite: 'sprite.svg'
                }
              }
            }))
            .pipe(gulp.dest(dir.output+'/img/svg'));
  });

}
