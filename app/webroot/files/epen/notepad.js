// Set URL of your WebSocketMain.swf here:
WEB_SOCKET_SWF_LOCATION = "WebSocketMain.swf";
// Set this to dump debug message from Flash to console.log:
WEB_SOCKET_DEBUG = true;

// Everything below is the same as using standard WebSocket

var inc = document.getElementById('incomming');
// window.ws = window.WebSocket || window.MozWebSocket;

var lastPt = [];
var drawchk = true;
var allPts = "";
var x = "";
var j = 0;
var downVal = 0;
var t = 0;
var chkCanvasEmpty = false;
var imgAry = new Array();
var ws;
var lastPt = new Array();
var tempAry = new Array();
var tempAry1 = new Array();
var x = new Array();
var y = new Array();
var chkIE = false;
var canvas = null, context = null;
var start = function() {

	/*
	 create a new websocket and connect
	window.ws = new wsImpl('ws://localhost:5011/HITECH', 'my-protocol');
	 when data is comming from the server, this metod is called*/

	context.clearRect(0, 0, canvas.width, canvas.height);
	context.fillRect(0, 0, canvas.width, canvas.height);
	context.fillStyle = "#FFFFFF";

	ws = new WebSocket("ws://localhost:444/HITECH");
	
	moomoo();
	 setTimeout(function(){ ws.send("CONNECT"); ws.send("ONLINE");}, 1000);

	ws.onmessage = function(evt) {

		// inc.innerHTML += evt.data + '<br/>';
		//   console.log(evt);

		$("#result").val('' + evt.data);

		// alert(evt.data);

		if (evt.data == "ACK") {

			if (chkCanvasEmpty) {

				var r = confirm("Want clear a note");
				if (r == true) {
					chkIe();
					canvasInitialization();
				}
			}
			ws.send("GETXY");
		} else if (evt.data == "EMPTY") {
			moomoo();
			t = setTimeout(function() {
				ws.send("GETXY");
			}, 0);

		} else if (evt.data == "DISCONNCTED") {
			alert("disconnected");

		} else if (evt.data == "EARSED") {
			alert("Data Cleared");
		} else if (evt.data == "DETECTED") {
			alert("Device Identified");

		} else if (evt.data == "CONNECTED") {
			//alert("Connected");
			$("#displayalert").html("<font color='green'><strong>CONNECTED</strong></font>");

		} else if (evt.data == "NODEVICE") {
			//alert("ERROR:No Device found or Connection Lost.");
			$("#displayalert").html("<font color='red'><strong>ERROR:No Device found or Connection Lost.</strong></font>");

		} else if (evt.data == "HITECH") {
			alert(evt.data);

		} else if (evt.data == "ERR") {
			//alert("ERROR: Check the connection or Device busy.");
			$("#displayalert").html("<font color='red'><strong>ERROR: Check the connection or Device busy.</strong></font>");

		} else if (evt.data == "NODATA") {
			alert("No Offline Data Available");

		} else {

			//		x += evt.data;
			//		alert(evt.data);
			if (drawchk) {

				drawData(evt.data);

			}
		}

	};

	// when the connection is established, this method is called
	ws.onopen = function() {
		$("#result").val('.. connection open<br/>');
		$("#toolsDiv").css("display", "none");
	};

	// when the connection is closed, this method is called
	ws.onclose = function() {
		// inc.innerHTML += '.. connection closed<br/>';
		$("#toolsDiv").css("display", "block");
		alert("Server Colosed or Disconnected.");
		$("#result").val('.. connection closed<br/>');

	};

};

/*function sendPacket(){
 var val = input.value;
 ws.send(val);
 input.value = "";
 }*/

function drawData(data) {

	context.beginPath();
	var d = data;
	var draw = false;
	//alert(d);
	drawchk = true;
	if (d != "EMPTY") {

		if (chkIE) {
			var xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
			xmlDoc.loadXML(d);
			d = xmlDoc;
		}
		//	var xmlPnode = xmlDoc.getElementsByTagName("ENTRIES").getChildNodes();;
		//	for(var k=0; k<xmlPnode.length; k++){

		$(d).find('FROM').each(
				function() {
					var p = $(this).text();
					if (p == "GETXY") {
						$(d).find('XY').each(
								function(i) {
									//var $entry = $(this);
									var pic = $(this).text();
									tempAry = [];
									tempAry1 = [];
									x = [];
									y = [];

									tempAry = pic.split("#");
									//alert(pic);
									//for(var p=0; p<tempAry.length; p++){
									tempAry1 = tempAry[0].split(":");
									x = tempAry[1].split(":");
									y = tempAry[2].split(":");
									if ($.trim(tempAry1[0]) == "ST"
											&& $.trim(tempAry1[1]) == "1") {
										//alert($.trim(x[1])+":"+$.trim(y[1]));
										//context.moveTo($.trim(x[1]),$.trim(y[1]));
										draw = true;
										lastPt[0] = $.trim(x[1]);
										lastPt[1] = $.trim(y[1]);
									} else if ($.trim(tempAry1[0]) == "ST"
											&& $.trim(tempAry1[1]) == "2") {
										//if(draw){
										//if(lastPt != null && lastPt.length > 0 ){

										//	console.log($.trim(lastPt[0])+":"+$.trim(lastPt[1]));
										if (lastPt[0] > 0) {
											context.moveTo($.trim(lastPt[0]), $
													.trim(lastPt[1]));
										} else {
											context.lineTo($.trim(x[1]), $
													.trim(y[1]));
										}
										context.lineTo($.trim(x[1]), $
												.trim(y[1]));
										//console.log($.trim(x[1])+":"+$.trim(y[1]));
										lastPt[0] = $.trim(x[1]);
										lastPt[1] = $.trim(y[1]);
										context.stroke();

										//}
									} else if ($.trim(tempAry1[0]) == "ST"
											&& $.trim(tempAry1[1]) == "3") {
										draw = false;
										lastPt[0] = -1;
										lastPt[1] = -1;
									} else if ($.trim(tempAry1[0]) == "ST"
											&& $.trim(tempAry1[1]) == "4") {

									}

									//}
								});

						chkCanvasEmpty = true;
						moomoo();
						t = setTimeout(function() {
							ws.send("GETXY");
						}, 0);
						//sleep(2000);
						//ws.send("GETXY");

					} else if (p == "DOWNLOAD") {

						context.clearRect(0, 0, canvas.width, canvas.height);
						context.fillRect(0, 0, canvas.width, canvas.height);

						context.fillStyle = "#FFFFFF";
						var p = $(d).find('COUNT').text();
						$('#downCount').val('' + p);

						context.moveTo($.trim(lastPt[0]), $.trim(lastPt[1]));
						$("#currCount").val('' + j);
						var note = $(d).find('NOTE');
						for ( var c = j; c < p; c++) {
							$(note[c]).find('XY').each(
									function(i) {
										//var $entry = $(this);

										tempAry = [];
										tempAry1 = [];
										x = [];
										y = [];
										tempAry = pic.split("#");
										//for(var p=0; p<tempAry.length; p++){
										tempAry1 = tempAry[0].split(":");
										x = tempAry[1].split(":");
										y = tempAry[2].split(":");
										if ($.trim(tempAry1[0]) == "ST"
												&& $.trim(tempAry1[1]) == "1") {
											//	alert($.trim(x[1])+":"+$.trim(y[1]));
											context.moveTo($.trim(x[1]), $
													.trim(y[1]));
											draw = true;
											if (lastPt.length > 0) {
												lastPt[0] = $.trim(x[1]);
												lastPt[1] = $.trim(y[1]);
											}
										} else if ($.trim(tempAry1[0]) == "ST"
												&& $.trim(tempAry1[1]) == "2") {
											if (draw) {
												//if(lastPt != null && lastPt.length > 0 ){
												context.lineTo($
														.trim(lastPt[0]), $
														.trim(lastPt[1]));

												context.lineTo($.trim(x[1]), $
														.trim(y[1]));
												lastPt[0] = $.trim(x[1]);
												lastPt[1] = $.trim(y[1]);
												context.stroke();
												chkCanvasEmpty = true;
											}
										} else if ($.trim(tempAry1[0]) == "ST"
												&& $.trim(tempAry1[1]) == "3") {
											draw = false;
											//lastPt = [];
										} else if ($.trim(tempAry1[0]) == "ST"
												&& $.trim(tempAry1[1]) == "4") {

										}

										//}
									});
							c = c + p;
						}

					}
				});
		//}
		drawchk = true;
	}
	context.closePath();

}
function moomoo() {
	clearTimeout(t);
}

function detectchk() {
	moomoo();
	ws.send("DETECT");
}
function connect() {
	
	moomoo();
	ws.send("CONNECT");
}
function online() {
	ws.send("ONLINE");
}
function erase() {
	moomoo();
	ws.send("ERASE");
	//ws.close();
}
function disconnect() {
	moomoo();
	ws.send("DISCONNECT");
	//	ws.close();
}
function datadownload() {
	moomoo();
	ws.send("DOWNLOAD");
}

function connTest() {
	moomoo();
	ws.send("HITECH");
}

function imgSave() {
	moomoo();
	canvas = document.getElementById("ex1");
	var dataURL = canvas.toDataURL("image/png");
	imgAry = new Array();
	imgAry = dataURL.split(",");

	$("#resultImg").val('' + imgAry[1]);

	document.getElementById('canvasImg').src = dataURL;

	checkImg = true;

	document.getElementById("sendForm").submit();
	//loadCanvas(dataURL);
}

function showPrev() {
	j = j - 1;
	if (j >= 0) {

		canvas = document.getElementById("ex1");
		if (chkIE) {
			if (G_vmlCanvasManager != undefined) { // ie IE
				canvas = G_vmlCanvasManager.initElement(canvas);
			}
		}
		context = canvas.getContext("2d");
		context.clearRect(0, 0, canvas.width, canvas.height);
		drawData($('#result').val());
	} else {
		j = $("#downCount").val() - 1;
		canvas = document.getElementById("ex1");
		if (chkIE) {
			if (G_vmlCanvasManager != undefined) { // ie IE
				canvas = G_vmlCanvasManager.initElement(canvas);
			}
		}

		context = canvas.getContext("2d");
		context.clearRect(0, 0, canvas.width, canvas.height);
		drawData($('#result').val());
	}
}

function showNext() {
	j = j + 1;
	if (j < $("#downCount").val()) {

		canvas = document.getElementById("ex1");
		context = canvas.getContext("2d");
		context.clearRect(0, 0, canvas.width, canvas.height);
		drawData($('#result').val());
	} else {
		j = 0;
		canvas = document.getElementById("ex1");
		context = canvas.getContext("2d");
		context.clearRect(0, 0, canvas.width, canvas.height);
		drawData($('#result').val());
	}
}

var removeBlanks = function(imgWidth, imgHeight, context, canvas) {
	var imageData = context.getImageData(0, 0, imgWidth, imgHeight), data = imageData.data, getRBG = function(
			x, y) {
		var offset = imgWidth * y + x;
		return {
			red : data[offset * 4],
			green : data[offset * 4 + 1],
			blue : data[offset * 4 + 2],
			opacity : data[offset * 4 + 3]
		};
	}, isWhite = function(rgb) {
		// many images contain noise, as the white is not a pure #fff white
		return rgb.red > 200 && rgb.green > 200 && rgb.blue > 200;
	}, scanY = function(fromTop) {
		var offset = fromTop ? 1 : -1;

		// loop through each row
		for ( var y = fromTop ? 0 : imgHeight - 1; fromTop ? (y < imgHeight)
				: (y > -1); y += offset) {

			// loop through each column
			for ( var x = 0; x < imgWidth; x++) {
				var rgb = getRBG(x, y);
				if (!isWhite(rgb)) {
					return y;
				}
			}
		}
		return null; // all image is white
	}, scanX = function(fromLeft) {
		var offset = fromLeft ? 1 : -1;

		// loop through each column
		for ( var x = fromLeft ? 0 : imgWidth - 1; fromLeft ? (x < imgWidth)
				: (x > -1); x += offset) {

			// loop through each row
			for ( var y = 0; y < imgHeight; y++) {
				var rgb = getRBG(x, y);
				if (!isWhite(rgb)) {
					return x;
				}
			}
		}
		return null; // all image is white
	};

	var cropTop = scanY(true), cropBottom = scanY(false), cropLeft = scanX(true), cropRight = scanX(false), cropWidth = cropRight
			- cropLeft, cropHeight = cropBottom - cropTop;

	var $croppedCanvas = $("<canvas>").attr({
		width : cropWidth,
		height : cropHeight
	});

	// finally crop the guy
	$croppedCanvas[0].getContext("2d").drawImage(canvas, cropLeft, cropTop,
			cropWidth, cropHeight, 0, 0, cropWidth, cropHeight);

	$("body").append("<p>same image with white spaces cropped:</p>").append(
			$croppedCanvas);
	console.log(cropTop, cropBottom, cropLeft, cropRight);
};

function getInternetExplorerVersion()
// Returns the version of Windows Internet Explorer or a -1
// (indicating the use of another browser).
{
	var rv = -1; // Return value assumes failure.
	if (navigator.appName == 'Microsoft Internet Explorer') {
		var ua = navigator.userAgent;
		var re = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
		if (re.exec(ua) != null)
			rv = parseFloat(RegExp.$1);
	}
	return rv;
}

function chkIe() {
	if (navigator.userAgent.toLowerCase().indexOf("msie") > -1) {
		var ver = getInternetExplorerVersion();
		if (ver > -1) {
			if (ver <= 8.0) {
				if (G_vmlCanvasManager != undefined) {
					chkIE = true;
				}
			}
		}
	}
}

function loadCanvas(dataURL) {
	var img = new Image(), $canvas = $("<canvas>"), canvas = $canvas[0], context;
	img.crossOrigin = "anonymous";
	img.onload = function() {
		$canvas.attr({
			width : this.width,
			height : this.height
		});
		context = canvas.getContext("2d");
		if (context) {
			context.drawImage(this, 0, 0);
			$("body").append("<p>original image:</p>").append($canvas);

			removeBlanks(this.width, this.height, context, canvas);
		} else {
			alert('Get a real browser!');
		}
	};

	img.src = dataURL;
}
var hasFlash = false;
$(document).ready(function() {
	chkIe();
	canvasInitialization();
	try {
		var fo = new ActiveXObject('ShockwaveFlash.ShockwaveFlash');
		if (fo) {
			hasFlash = true;
		} else {
			alert("Please install flash player to continue....");
		}
	} catch (e) {
		if (navigator.mimeTypes["application/x-shockwave-flash"] != undefined)
			hasFlash = true;
	}

});

window.onload = start;

function canvasInitialization() {
	canvas = null;
	context = null;
	canvas = document.getElementById("ex1");
	if (chkIE) {
		if (G_vmlCanvasManager != undefined) { // ie IE
			canvas = G_vmlCanvasManager.initElement(canvas);
		}
	}

	if (canvas.getContext) {
		context = canvas.getContext("2d");
		context.clearRect(0, 0, canvas.width, canvas.height);
		context.fillStyle = "#FFFFFF";

		context.fillRect(0, 0, canvas.width, canvas.height);
		context.fillStyle = "#FFFFFF";
	}
}