var Particle = /** @class */ (function() {
  function Particle(x, y, angle, speed) {
    this.angle = 10;
    this.speed = speed;
    this.b = 0;
    this.x = x;
    this.y = y;
    this.angle = angle;
    this.size = Math.random() * 15 + 15;
  }
  Object.defineProperty(Particle.prototype, "speed", {
    get: function() {
      return this._speed;
    },
    set: function(newSpeed) {
      this._speed = newSpeed;
    },
    enumerable: true,
    configurable: true
  });
  Particle.prototype.linear = function(x) {
    return Math.tan((this.angle * Math.PI) / 180) * x + this.b;
  };
  return Particle;
})();
var Particles = /** @class */ (function() {
  /**
   * Create a set of particles
   * @constructor
   *
   * @param path Path to image
   * @param ctx Canvas context
   * @param count Number of particles
   * @param speed Speed of particles in px/second
   */
  function Particles(path, ctx, count, speed) {
    if (speed === void 0) {
      speed = 20;
    }
    this.ctx = ctx;
    this.last = 0;
    ctx.canvas.width = this.ctx.canvas.offsetWidth;
    ctx.canvas.height = this.ctx.canvas.offsetHeight;
    ctx.globalCompositeOperation = "destination-over";
    this.particle = new Array(count);
    for (var i = 0; i < this.particle.length; i++) {
      this.particle[i] = new Particle(
        Math.random() * ctx.canvas.width,
        Math.random() * ctx.canvas.height,
        Math.random() * 360,
        speed
      );
    }
    this.figure = new Image();
    this.figure.src = path;
    this.run = false;
  }
  Particles.prototype.draw = function(diff) {
    this.ctx.clearRect(0, 0, this.ctx.canvas.width, this.ctx.canvas.height);
    for (var i = 0; i < this.particle.length; i++) {
      if (this.particle[i].x + this.particle[i].size > this.ctx.canvas.width) {
        this.particle[i].x = this.ctx.canvas.width - this.particle[i].size;
        this.particle[i].angle *= -1;
        this.particle[i].angle += 180;
      } else if (this.particle[i].x < 0) {
        this.particle[i].x = 0;
        this.particle[i].angle *= -1;
        this.particle[i].angle += 180;
      }
      if (this.particle[i].y + this.particle[i].size > this.ctx.canvas.height) {
        this.particle[i].y = this.ctx.canvas.height - this.particle[i].size;
        this.particle[i].angle *= -1;
      } else if (this.particle[i].y < 0) {
        this.particle[i].y = 0;
        this.particle[i].angle *= -1;
      }
      var x =
        this.particle[i].speed *
        (diff / 1000) *
        Math.cos((this.particle[i].angle * Math.PI) / 180);
      var y = this.particle[i].linear(x);
      this.particle[i].x += x;
      this.particle[i].y += y;
      this.ctx.drawImage(
        this.figure,
        this.particle[i].x,
        this.particle[i].y,
        this.particle[i].size,
        this.particle[i].size
      );
    }
  };
  Particles.prototype.stop = function() {
    this.run = false;
  };
  Particles.prototype.start = function() {
    this.run = true;
    this.last = 0;
    this.animate();
  };
  Particles.prototype.animate = function(time) {
    var _this = this;
    if (time === void 0) {
      time = 0;
    }
    var timeDiff = time - this.last;
    if (this.run) {
      if (timeDiff < 1000) {
        this.draw(timeDiff);
      }
      this.last = performance.now();
      requestAnimationFrame(function(time) {
        return _this.animate(time);
      });
    } else {
      this.ctx.clearRect(0, 0, this.ctx.canvas.width, this.ctx.canvas.height);
    }
  };
  Particles.prototype.update = function() {
    this.ctx.canvas.width = this.ctx.canvas.offsetWidth;
    this.ctx.canvas.height = this.ctx.canvas.offsetHeight;
  };
  return Particles;
})();
//# sourceMappingURL=particles.js.map
