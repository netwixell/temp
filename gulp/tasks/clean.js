import path from 'path';
import del from 'del';

const taskName = 'clean';


export default (config,  browserSync, generateSubTasks) => {

  generateSubTasks(taskName, dir => () => del(path.join(dir.output, '**')));

};
