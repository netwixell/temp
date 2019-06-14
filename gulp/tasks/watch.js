import gulp from 'gulp';

const taskName = 'watch';

export default (config, browserSync, generateSubTasks) => {

  generateSubTasks(taskName, dir => () => {

    let src = dir.input,
        srcLastSlash = src.lastIndexOf('/'),
        srcParent = src.substring( 0, srcLastSlash ),
        srcDirName = src.substr( srcLastSlash + 1 ),
        commonDir = srcParent+'/common';

    gulp.watch([src+'/**/*.pug', commonDir+'/pug/**/*.pug'], gulp.series('pug:'+dir.name));

    gulp.watch(src+'/**/*.json', gulp.series('pug:'+dir.name));
    // .on('change', browserSync.reload);

    gulp.watch([src+'/**/*.sass', commonDir+'/sass/**/*.sass'], gulp.series('sass:'+dir.name));

    gulp.watch([src+'/**/*.js', commonDir+'/js/**/*.js'], gulp.series('scripts:'+dir.name));

    gulp.watch(src+'/svg-sprite/svg/*.svg', gulp.series('svg-sprite:'+dir.name));

    gulp.watch([src+'/**/img/*.{png,jpg,webp,svg}', commonDir+'/img/'+srcDirName+'/**/*.{png,jpg,webp,svg}'], gulp.series('img:'+dir.name));


  });


}
