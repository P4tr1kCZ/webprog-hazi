class Shape {
    constructor(color) {
        this._color = color;
    }
    
    get color() {
        return this._color;
    }

    set color(another_color) {
        this._color = another_color;
    }

    draw(ctx, x, y) {}
}

class Circle extends Shape {
    constructor(color, r) {
        super(color);
        this._r = r;
    }

    get r() {
        return this._r;
    }

    set r(another_r) {
        this._r = another_r;
    }

    draw(ctx, x, y) {
        ctx.beginPath();
        ctx.arc(x, y, this._r, 0, 2 * Math.PI, false);
        ctx.lineWidth = 3;
        ctx.strokeStyle = this.color;
        ctx.stroke();
    }
}

class Rectangle extends Shape {
    constructor(color, a, b) {
        super(color);
        this._a = a;
        this._b = b;
    }

    get a() {
        return this._a;
    }

    set a(another_a) {
        this._a = another_a;
    }

    get b() {
        return this._b;
    }

    set b(another_b) {
        this._b = another_b;
    }

    draw(ctx, x, y) {
        ctx.beginPath();
        ctx.rect(x, y, this._a, this._b);
        ctx.strokeStyle = this.color;
        ctx.stroke();
    }
}

$( "#circlebtn" ).click(function() {
    onCircleAdd();
});

$( "#rectanglebtn" ).click(function() {
    onRectangleAdd();
});

function onCircleAdd() {
    const color = document.getElementById('circle').value;
    const r = randomIntFromInterval(45, 100);
    const circle = new Circle(color, r);
    var canvas = document.getElementById('canvas');
    if (canvas.getContext)
    {
        var ctx = canvas.getContext('2d'); 
        const x = randomIntFromInterval(100, 400);
        const y = randomIntFromInterval(100, 400);
        circle.draw(ctx, x, y);
    }
}

function onRectangleAdd() {
    const color = document.getElementById('rectangle').value;
    const a = randomIntFromInterval(30, 150);
    const b = randomIntFromInterval(30, 150);
    const rect = new Rectangle(color, a, b);
    var canvas = document.getElementById('canvas');
    if (canvas.getContext)
    {
        var ctx = canvas.getContext('2d'); 
        const x = randomIntFromInterval(100, 400);
        const y = randomIntFromInterval(100, 400);
        rect.draw(ctx, x, y);
    }
}

function randomIntFromInterval(min, max) {
    return Math.floor(Math.random() * (max - min + 1) + min);
  }