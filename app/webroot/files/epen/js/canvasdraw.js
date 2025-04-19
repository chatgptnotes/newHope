﻿// by Chtiwi Malek ===> CODICODE.COM
var cPushArray = new Array();
var cStep = -1;
var mousePressed = false;
var lastX, lastY;
var ctx;
$(document).ready(function() {
	//InitThis();
});

function InitThis() {
    var canvas=document.getElementById('myCanvas');
	ctx = canvas.getContext("2d");
    $('#myCanvas').mousedown(function (e) {
        mousePressed = true;
        Draw(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, false);
    });

    $('#myCanvas').mousemove(function (e) {
        if (mousePressed) {
            Draw(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, true);
        }
    });

    $('#myCanvas').mouseup(function (e) {
        if (mousePressed) {
            mousePressed = false;
            cPush();
        }
    });

    $('#myCanvas').mouseleave(function (e) {
        if (mousePressed) {
            mousePressed = false;
            cPush();
        }
    });
    drawImage();
}

function drawImage() {
	ctx.clearRect(0, 0, 500,200);
        cPush();
       
}

function Draw(x, y, isDown) {
    if (isDown) {
        ctx.beginPath();
        ctx.strokeStyle = $('#selColor').val();
        ctx.lineWidth = $('#selWidth').val();
        ctx.lineJoin = "round";
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(x, y);
        ctx.closePath();
        ctx.stroke();
    }
    lastX = x;
    lastY = y;
}
function cPush() {
    cStep++;
    if (cStep < cPushArray.length) {
    	
    	cPushArray.length = cStep; 
    
    }
    
    cPushArray.push(document.getElementById('myCanvas').toDataURL());
    document.title = cStep + ":" + cPushArray.length;
}
function cUndo() {
    if (cStep > 0) {
        cStep--;
        var canvasPic = new Image();
        canvasPic.src = cPushArray[cStep];
        canvasPic.onload = function () { 
        	ctx.drawImage(canvasPic, 0, 0); 
        	};
        document.title = cStep + ":" + cPushArray.length;
    }
}
function cRedo() {
    if (cStep < cPushArray.length-1) {
        cStep++;
        var canvasPic = new Image();
        canvasPic.src = cPushArray[cStep];
        canvasPic.onload = function () {
        	ctx.drawImage(canvasPic, 0, 0);
        	};
        document.title = cStep + ":" + cPushArray.length;
    }
}