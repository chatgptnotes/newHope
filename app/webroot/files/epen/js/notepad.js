var canvas = null;
var context = null;
var tool = null;
var cPushArray = new Array();
var cStep = -1;
var lastX,lastY;

$(document).ready(function() {

	init();
	context.lineWidth = 3;
	$('.preview').css('backgroundColor', pixelColor);
	$("#slidervalue").text(3);

	$("#paintslider").slider({
		value : 1
	});

	$("#paintslider").slider({
		orientation : "horizontal",
		range : "min",
		min : 1,
		max : 25,
		value : 3,
		slide : function(event, ui) {
			$("#slidervalue").text(ui.value);
			context.lineWidth = ui.value;
		}
	});

	$("#paint").mouseover(function() {
		$('.colorpicker').hide();
	});
	cPush();
});

function pencil() {

	context.strokeStyle = pixelColor;
	context.lineWidth = 1;

	$("#paintslider").slider({
		value : 1
	});

	$("#slidervalue").text(1);

}

function init() {

	// Get the 2D canvas context.
	canvas = document.getElementById('paint');
	context = canvas.getContext('2d');
	context.strokeStyle = pixelColor;

	// Pencil tool instance.
	tool = new tool_pencil();

	// Attach the mouse_down, mouse_move and mouse_up event listeners.
	canvas.addEventListener('mousedown', ev_canvas, false);
	canvas.addEventListener('mousemove', ev_canvas, false);
	canvas.addEventListener('mouseup', ev_canvas, false);

}

// The general-purpose event handler. This function just determines the mouse
// position relative to the canvas element.

function ev_canvas(ev) {
	if (ev.offsetX || ev.offsetX == 0) {// All Browser
		ev._x = ev.offsetX;
		ev._y = ev.offsetY;
	}else if (ev.layerX || ev.layerX == 0) {// Firefox
		ev._x = ev.layerX - canvas.offsetLeft;
		ev._y = ev.layerY - canvas.offsetTop;
	}

	// Call the event handler of the tool.
	var func = tool[ev.type];
	if (func) {
		func(ev);
	}

}

// This painting tool works like a drawing pencil which tracks the mouse
// movements.
function tool_pencil() {

	tool = this;
	this.started = false;
	
	// This is called when you start holding down the mouse button.
	// This starts the pencil drawing.
	this.mousedown = function(ev) {
		tool.started = true;
		Draw(ev._x, ev._y,false);
	};

	// This function is called every time you move the mouse. Obviously, it only
	// draws if the tool.started state is set to true (when you are holding down
	// the mouse button).
	this.mousemove = function(ev) {
		if (tool.started) {
			Draw(ev._x, ev._y,true);

		}
	};

	// This is called when you release the mouse button.
	this.mouseup = function(ev) {
		if (tool.started) {
			tool.mousemove(ev);
			tool.started = false;
			cPush();
		}
	};

	$('#paint').mouseleave(function(ev) {

		if (tool.started) {
			tool.mousemove(ev);
			tool.started = false;
			cPush();
		}
	});
}

function eraser() {

	/*  $('#container').removeClass('cursorimg');
	 $('#container').addClass('cursorimg1'); */

	//Set the white color to pencil
	context.strokeStyle = "rgba(255,255,255,1)";
	context.lineWidth = 5;

	$("#paintslider").slider({
		value : 5
	});

	$("#slidervalue").text(5);

}

function clearAll() {
	context.clearRect(0, 0, canvas.width, canvas.height);
	 cPushArray =[];
	 cStep = -1;
	 cPush();
}

function download() {
	var oCanvas = document.getElementById('paint');
	Canvas2Image.saveAsPNG(oCanvas);
}

function newPage() {
	var r = confirm("Do you want to save!");
	if (r == true) {
		download();
		context.clearRect(0, 0, canvas.width, canvas.height);
	} else {
		context.clearRect(0, 0, canvas.width, canvas.height);
	}
}

function cPush() {
	cStep++;
	if (cStep < cPushArray.length) {
		cPushArray.length = cStep;
	}
	cPushArray.push(document.getElementById('paint').toDataURL());
}
function cUndo() {
	if (cStep > 0) {
		cStep--;
		var canvasPic = new Image();
		canvasPic.src = cPushArray[cStep];
		canvasPic.onload = function() {
			context.clearRect(0, 0, canvas.width, canvas.height);
			context.drawImage(canvasPic, 0, 0);
		};
	}
}
function cRedo() {
	if (cStep < cPushArray.length - 1) {
		cStep++;
		var canvasPic = new Image();
		canvasPic.src = cPushArray[cStep];
		canvasPic.onload = function() {
			context.clearRect(0, 0, canvas.width, canvas.height);
			context.drawImage(canvasPic, 0, 0);
		};
	}
}

function Draw(x, y, isDown) {
    if (isDown) {
    	context.beginPath();
    	context.lineJoin = "round";
    	context.moveTo(lastX, lastY);
    	context.lineTo(x, y);
    	context.closePath();
    	context.stroke();
    }
    lastX = x;
    lastY = y;
}