


export default class Timer{

  constructor(timeEnd = 0, interval){

    this.timeEnd = timeEnd;
    this.interval = interval || timeEnd;


    this.id = null;
    this._events = {};
    this.enabled=false;

    this.time = 0;

    this.init();
  }

  init(){

    this.start();
  }

  start(){

    if(this.enabled) return;

    this.id = setInterval(()=>{

      this.time += this.interval;

      this.tick(this.time);

      if(this.time >= this.timeEnd) this.finish();

    }, this.interval);

    this.enabled = true;

  }

  restart(){

    this.time = 0;

    if(!this.enabled) this.start();

  }

  finish(){
    this.trigger('finish');
    this.stop();
  }

  tick(time){
    this.trigger('tick', time);
  }

  stop(){
    this.enabled = false;

    this.time = 0;

    clearInterval(this.id);

    this.trigger('stop');
  }

  on(type, listener){

    if(!this._events[type]){
      this._events[type] = [];
    }

    this._events[type].push(listener);

  }

  trigger(type, ...params){

    if(this._events[type]){
      let listeners = this._events[type];

      for(let listener of listeners){

        listener.apply(this, params);

      }

    }

  }

}
