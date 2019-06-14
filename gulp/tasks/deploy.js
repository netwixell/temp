module.exports = function () {
  $.gulp.task('deploy:stage', function () {
    return $.gulp.src('/public/**').pipe($.gp.rsync({
      root: 'public/build/',
      hostname: 'molfarfo@molfarfo.ftp.tools',
      destination: '/home/molfarfo/molfarforum.com/stage/public/',
      archive: true,
      silent: false,
      compress: true
    })
    );
  });
};
