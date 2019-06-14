const taskName = 'serve';

export default (config, browserSync, generateSubTasks) => {

  generateSubTasks(taskName, dir => () => {

    let dest = dir.output;

    browserSync.init({
      server: {
        baseDir: dest
      },
      notify: false,
      ghostMode: false,
      open: false, // см. в http://localhost:3000
      // open: 'tunnel',
      // tunnel: 'molfar'
    });

    browserSync.watch([dest, '!'+dest+'/**/*.css'], browserSync.reload);

  });

}
