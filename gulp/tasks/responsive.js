import gulp from 'gulp';
import gulpResponsive from 'gulp-responsive';
import gulpPlumber from 'gulp-plumber';
import gulpNotify from 'gulp-notify';



export default (config , browserSync) => {


  gulp.task('responsive', function () {
    return gulp.src('resources/assets/static/data-img/**/*.{png,jpg}')
      .pipe(gulpPlumber({
        errorHandler: gulpNotify.onError({
          title: 'responsive',
          message: '<%= error.message %>',
        })
      }))
      .pipe(gulpResponsive({
        '**/*.png': [{
          width: 1080,
          rename: {
            suffix: '_1080',
            extname: '.jpg'
          }
        }, {
          width: 720,
          rename: {
            suffix: '_720',
            extname: '.jpg'
          }
        }, {
          width: 360,
          rename: {
            suffix: '_360',
            extname: '.jpg'
          }
        }],
        '**/*.jpg': [{
          width: 1080,
          rename: {
            suffix: '_1080'
          }
        }, {
          width: 720,
          rename: {
            suffix: '_720'
          }
        }, {
          width: 360,
          rename: {
            suffix: '_360'
          }
        }]
        // '**/*.jpg': [{
        //   width: 2560,
        //   rename: {
        //     suffix: '_2560'
        //   }
        // }, {
        //   width: 1920,
        //   rename: {
        //     suffix: '_1920'
        //   }
        // }, {
        //   width: 1536,
        //   rename: {
        //     suffix: '_1536'
        //   }
        // }, {
        //   width: 1280,
        //   rename: {
        //     suffix: '_1280'
        //   }
        // }, {
        //   width: 960,
        //   rename: {
        //     suffix: '_960'
        //   }
        // }, {
        //   width: 640,
        //   rename: {
        //     suffix: '_640'
        //   }
        // }, {
        //   width: 480,
        //   rename: {
        //     suffix: '_480'
        //   }
        // }, {
        //   width: 320,
        //   rename: {
        //     suffix: '_320'
        //   }
        // }, {
        //   width: 2560,
        //   rename: {
        //     suffix: '_2560',
        //     extname: '.webp'
        //   }
        // }, {
        //   width: 1920,
        //   rename: {
        //     suffix: '_1920',
        //     extname: '.webp'
        //   }
        // }, {
        //   width: 1536,
        //   rename: {
        //     suffix: '_1536',
        //     extname: '.webp'
        //   }
        // }, {
        //   width: 1280,
        //   rename: {
        //     suffix: '_1280',
        //     extname: '.webp'
        //   }
        // }, {
        //   width: 960,
        //   rename: {
        //     suffix: '_960',
        //     extname: '.webp'
        //   }
        // }, {
        //   width: 640,
        //   rename: {
        //     suffix: '_640',
        //     extname: '.webp'
        //   }
        // }, {
        //   width: 480,
        //   rename: {
        //     suffix: '_480',
        //     extname: '.webp'
        //   }
        // }, {
        //   width: 320,
        //   rename: {
        //     suffix: '_320',
        //     extname: '.webp'
        //   }
        // }]
        // '**/*.jpg': [{
        //   width: 450,
        //   rename: {
        //     suffix: '_450'
        //   }
        // }, {
        //   width: 300,
        //   rename: {
        //     suffix: '_300'
        //   }
        // }, {
        //   width: 150,
        //   rename: {
        //     suffix: '_150'
        //   }
        // }, {
        //   width: 450,
        //   rename: {
        //     suffix: '_450',
        //     extname: '.webp'
        //   }
        // }, {
        //   width: 300,
        //   rename: {
        //     suffix: '_300',
        //     extname: '.webp'
        //   }
        // }, {
        //   width: 150,
        //   rename: {
        //     suffix: '_150',
        //     extname: '.webp'
        //   }
        // }]
      }, {
          progressive: true,
          withMetadata: false,
          withoutEnlargement: true,
          errorOnEnlargement: false,
          errorOnUnusedConfig: false,
          errorOnUnusedImage: false
        }))
      .pipe(gulp.dest('resources/assets/static/img/'));
  });

}


// module.exports = function () {
//   $.gulp.task('responsive', function () {
//     return $.gulp.src('resources/assets/static/data-img/**/*.{png,jpg}')
//       .pipe($.gp.plumber({
//         errorHandler: $.gp.notify.onError({
//           title: 'responsive',
//           message: '<%= error.message %>',
//         })
//       }))
//       .pipe($.gp.responsive({
//         '**/*.png': [{
//           width: 1080,
//           rename: {
//             suffix: '_1080',
//             extname: '.jpg'
//           }
//         }, {
//           width: 720,
//           rename: {
//             suffix: '_720',
//             extname: '.jpg'
//           }
//         }, {
//           width: 360,
//           rename: {
//             suffix: '_360',
//             extname: '.jpg'
//           }
//         }],
//         '**/*.jpg': [{
//           width: 1080,
//           rename: {
//             suffix: '_1080'
//           }
//         }, {
//           width: 720,
//           rename: {
//             suffix: '_720'
//           }
//         }, {
//           width: 360,
//           rename: {
//             suffix: '_360'
//           }
//         }]
//         // '**/*.jpg': [{
//         //   width: 2560,
//         //   rename: {
//         //     suffix: '_2560'
//         //   }
//         // }, {
//         //   width: 1920,
//         //   rename: {
//         //     suffix: '_1920'
//         //   }
//         // }, {
//         //   width: 1536,
//         //   rename: {
//         //     suffix: '_1536'
//         //   }
//         // }, {
//         //   width: 1280,
//         //   rename: {
//         //     suffix: '_1280'
//         //   }
//         // }, {
//         //   width: 960,
//         //   rename: {
//         //     suffix: '_960'
//         //   }
//         // }, {
//         //   width: 640,
//         //   rename: {
//         //     suffix: '_640'
//         //   }
//         // }, {
//         //   width: 480,
//         //   rename: {
//         //     suffix: '_480'
//         //   }
//         // }, {
//         //   width: 320,
//         //   rename: {
//         //     suffix: '_320'
//         //   }
//         // }, {
//         //   width: 2560,
//         //   rename: {
//         //     suffix: '_2560',
//         //     extname: '.webp'
//         //   }
//         // }, {
//         //   width: 1920,
//         //   rename: {
//         //     suffix: '_1920',
//         //     extname: '.webp'
//         //   }
//         // }, {
//         //   width: 1536,
//         //   rename: {
//         //     suffix: '_1536',
//         //     extname: '.webp'
//         //   }
//         // }, {
//         //   width: 1280,
//         //   rename: {
//         //     suffix: '_1280',
//         //     extname: '.webp'
//         //   }
//         // }, {
//         //   width: 960,
//         //   rename: {
//         //     suffix: '_960',
//         //     extname: '.webp'
//         //   }
//         // }, {
//         //   width: 640,
//         //   rename: {
//         //     suffix: '_640',
//         //     extname: '.webp'
//         //   }
//         // }, {
//         //   width: 480,
//         //   rename: {
//         //     suffix: '_480',
//         //     extname: '.webp'
//         //   }
//         // }, {
//         //   width: 320,
//         //   rename: {
//         //     suffix: '_320',
//         //     extname: '.webp'
//         //   }
//         // }]
//         // '**/*.jpg': [{
//         //   width: 450,
//         //   rename: {
//         //     suffix: '_450'
//         //   }
//         // }, {
//         //   width: 300,
//         //   rename: {
//         //     suffix: '_300'
//         //   }
//         // }, {
//         //   width: 150,
//         //   rename: {
//         //     suffix: '_150'
//         //   }
//         // }, {
//         //   width: 450,
//         //   rename: {
//         //     suffix: '_450',
//         //     extname: '.webp'
//         //   }
//         // }, {
//         //   width: 300,
//         //   rename: {
//         //     suffix: '_300',
//         //     extname: '.webp'
//         //   }
//         // }, {
//         //   width: 150,
//         //   rename: {
//         //     suffix: '_150',
//         //     extname: '.webp'
//         //   }
//         // }]
//       }, {
//           progressive: true,
//           withMetadata: false,
//           withoutEnlargement: true,
//           errorOnEnlargement: false,
//           errorOnUnusedConfig: false,
//           errorOnUnusedImage: false
//         }))
//       .pipe($.gulp.dest('resources/assets/static/img/'));
//   });
// }
