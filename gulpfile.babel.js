import gulp from 'gulp';

import clean from './gulp/tasks/clean';
import scripts from './gulp/tasks/scripts';
import pug from './gulp/tasks/pug';
import sass from './gulp/tasks/sass';

import img from './gulp/tasks/img';
import svgSprite from './gulp/tasks/svg-sprite';
import responsive from './gulp/tasks/responsive';

import watch from './gulp/tasks/watch';
import serve from './gulp/tasks/serve';

import { create as bsCreate } from 'browser-sync';

const browserSync = bsCreate();

const rTrailingSlash = /\/$/;
/**
 * Объявление глобального объекта конфигурации для тасков
 * @type {Object}
 * @property {boolean} isBuild             - Указывает на выполненение финальной сборки проекта перед деплоем
 * @property {string} mode                 - Режим сборки проекта development/production
 * @property {Object[]} dirs               - Массив с данными для генерирования тасков по заданным папкам input, output (генерируется автоматически в initTasks)
 * @property {string} dirs[].name          - Общее имя для тасков по обработке исходных файлов с папки
 * @property {string} dirs[].input='src'   - Папка с исходными файлами (source files)
 * @property {string} dirs[].output='dist' - Папка для вывода результатов сборки (bundles)
 */
global.config = {
  isBuild: false,
  mode: 'development'
};

// Общие таски для разработки и build
const commonTasks = ['scripts', 'pug', 'sass', 'img', 'svg-sprite'];

// Имя сгенерированного таска для таска default
const defaultTaskName = 'web-site';

// Инициализация импортированных тасков, передача им конфигурации
initTasks([
  {
    name: defaultTaskName,
    input: 'src/web-site',
    output: 'public/web-site'
  },
  {
    input: 'src/admin-panel',
    output: 'public/admin-panel'
  },
  {
    input: 'src/client-email',
    output: 'public/client-email'
  },
  {
    input: 'src/pdf',
    output: 'public/pdf'
  }
],
  [clean, scripts, pug, sass, img, svgSprite, responsive, watch, serve]
);

gulp.task('default', gulp.series(defaultTaskName));

gulp.task('build', gulp.series(done => {
  // Задание параметров конфигурации перед запуском связанных тасков
  config.isBuild = true;
  config.mode = 'production';

  done();
}, 'clean',
  gulp.parallel(...commonTasks)
)
);


function initTasks(data = [], tasks = []) {

  let dirs = sanitizeData(data);

  let generateSubTasks = subTasksGenerator(dirs);

  for (let task of tasks) {

    task(config, browserSync, generateSubTasks);

  }

  generateTasks(dirs);

}

function subTasksGenerator(dirs) {

  return function (taskName, callback) {

    let subTasks = [], subTaskName;

    for (let dir of dirs) {
      subTaskName = taskName + ':' + dir.name;

      gulp.task(subTaskName, callback(dir));

      subTasks.push(subTaskName);
    }

    gulp.task(taskName, (taskName === 'scripts') ? gulp.series(...subTasks) : gulp.parallel(...subTasks));

  }

}

// Нормализация полученных данных с адресами папок
function sanitizeData(data = []) {
  let dirs = [], dir;

  for (let item of data) {
    dir = {};

    if (!item.input || '' === item.input) continue;

    dir.input = item.input.trim().replace(rTrailingSlash, '');
    dir.output = item.output ? item.output.trim().replace(rTrailingSlash, '') : 'dist';
    dir.name = item.name || dir.input.substr(dir.input.lastIndexOf('/') + 1);

    dirs.push(dir);
  }

  return dirs;
}

function generateTasks(dirs) {

  for (let dir of dirs) {

    gulp.task(dir.name, gulp.series(done => {
      // Задание параметров конфигурации перед запуском связанных тасков
      config.isBuild = false;
      config.mode = 'development';

      done();
    },
      'clean:' + dir.name,
      gulp.parallel(...commonTasks.map(task => task + ':' + dir.name)),
      gulp.parallel('watch:' + dir.name, 'serve:' + dir.name)
    )
    );

  }

}
