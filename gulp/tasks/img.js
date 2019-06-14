import fs from 'fs';
import path from 'path';

import gulp from 'gulp';

import gulpIf from 'gulp-if';
import gulpRename from 'gulp-rename';
import gulpFilter from 'gulp-filter';

import merge from 'merge2';

import mozjpeg from 'imagemin-mozjpeg';
import pngquant from 'imagemin-pngquant';
import gulpImagemin from 'gulp-imagemin';

const taskName = 'img';

const imagesMask = '**/*.{png,jpg,webp,svg,gif}';

const faviconExtra = '*.{ico,xml,webmanifest}';

const imagemin = () => gulpImagemin([
  mozjpeg({
    quality: 65
  }),
  pngquant({
    quality: 65,
    speed: 1
  }),
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
], {
    verbose: true
  }
);

function getFolders(dir) {
  return fs.readdirSync(dir)
    .filter(function (file) {
      return fs.statSync(path.join(dir, file)).isDirectory();
    });
}

export default (config, browserSync, generateSubTasks) => {

  generateSubTasks(taskName, dir => () => {

    let src = dir.input,
      dest = dir.output;

    // Создание отдельного таска обработки изображений для каждой папки блока
    let tasks = getFolders(src).map(folder => {

      return gulp.src(`${src}/${folder}/img/${imagesMask}`)
        .pipe(gulpIf(config.isBuild, imagemin()))
        .pipe(gulpRename(path => { path.dirname = '/' + folder; }))
        .pipe(gulp.dest(dest + '/img'));
    }) || [];

    let srcLastSlash = src.lastIndexOf('/'),
      srcParent = src.substring(0, srcLastSlash),
      srcDirName = src.substr(srcLastSlash + 1),
      commonDir = srcParent + '/common/img/' + srcDirName;

    // FIXME: Костыль чтобы не допускать оптимизацию файла dot.svg
    let svgFilter = gulpFilter([commonDir + '/' + imagesMask, '!' + commonDir + '/dot.svg'], { restore: true });

    // Таск для вытягивания изображений из папки common
    tasks.push(
      gulp.src(commonDir + '/' + imagesMask)
        .pipe(svgFilter)
        .pipe(gulpIf(config.isBuild, imagemin()))
        .pipe(svgFilter.restore)
        .pipe(gulp.dest(dest + '/img'))
    );

    // Перенос дополнительных файлов favicon
    tasks.push(
      gulp.src(src + '/favicon/img/' + faviconExtra)
        .pipe(gulp.dest(dest + '/img/favicon'))
    );

    // Склеивание полученных тасков в один поток
    return merge(tasks);

  });


}
