import gulp from 'gulp';

import webpackStream from 'webpack-stream';
import webpack from 'webpack';
import named from 'vinyl-named';

import UglifyJsPlugin from 'uglifyjs-webpack-plugin';

const taskName = 'scripts';

// Параметры конфигурации babel
const CONFIG_BABEL = {
  rules: [
    {
      test: /\.(js|jsx)$/,
      exclude: /node_modules/,
      use: {
        loader: "babel-loader"
      }
    }
  ]
};

// Параметры конфигурации webpack
const CONFIG_WEBPACK = {
  mode: 'development',
  devtool: 'source-map', // 'eval'
  module: {},
  output: {
    filename: '[name].min.js'
  },
  plugins: []
};


export default (config, browserSync, generateSubTasks) => {

  // Генератор тасков под разные папки для исходных файлов и результатов
  // Пример: Заданы папки {input: 'src', output: 'dist'}.
  // Имя сгенерированного таска: 'scripts:src'
  // src путь для галпа: src/*.js
  // dest путь для галпа: dist/js
  // Таск scripts запускает все сгенерированные таски

  // Запуск генератора тасков для скриптов
  generateSubTasks(taskName, dir => () => {

    // Создание объекта с конфигом webpack
    let configWebpack = Object.assign({}, CONFIG_WEBPACK);

    // Изменение параметров конфигурации webpack в зависимости от режима работы галпа development/production
    configWebpack.mode = config.mode;

    configWebpack.module = CONFIG_BABEL;

    // Если выполняется таск build, то подключаем babel, задаем конфигурацию для минификации скриптов, отключаем sourceMap
    if (config.isBuild) {

      configWebpack.devtool = false;

      configWebpack.plugins.push(new UglifyJsPlugin({ sourceMap: false }));

    //   configWebpack.optimization = {
    //     splitChunks:{
    //       cacheGroups: {
    //         react: { test: /[\\/]node_modules[\\/]((react).*)[\\/]/, name: "react", chunks: "all" },
    //         photoswipe: { test: /[\\/]node_modules[\\/]((photoswipe).*)[\\/]/, name: "photoswipe", chunks: "all"}
    //         // commons: { test: /[\\/]node_modules[\\/]((?!react).*)[\\/]/, name: "common", chunks: "all" }
    //       }
    //     }
    //  };

      // configWebpack.optimization = {
      //   splitChunks: {
      //     chunks: 'initial',
      //   },
      // };

    }

    return gulp.src(dir.input + '/*.js', { allowEmpty: true })
      .pipe(named())
      .pipe(webpackStream(configWebpack), webpack)
      .on('error', function handleError(err) {
        this.emit('end'); // Recover from errors
      })
      .pipe(gulp.dest(dir.output + '/js'))
      .pipe(browserSync.stream());

  });

}
