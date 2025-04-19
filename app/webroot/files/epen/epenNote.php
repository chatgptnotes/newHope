<?php error_reporting(E_ALL ^ E_NOTICE);
require_once('../../../config/database.php');
$dbConfig = new DATABASE_CONFIG();
if($_GET['flag']=="success")
{
	header("location:../../../notes/soapNote/".$_GET['patientid'].'/'.$_GET['noteID']."/?expand=epen"); 
}

?>
<!DOCTYPE HTML>

<html>
<body>
<head>
<!-- <meta http-equiv="X-UA-Compatible" content="IE=9" > -->
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/bootstrap_paint.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet" type="text/css" />
<link href="css/slider.css" rel="stylesheet" type="text/css" />

<link href="css/bootstrap-responsive.css" rel="stylesheet">
<!--js -->
<!--[if IE]><script src="excanvas.js"></script><![endif]-->


<script type="text/javascript" src="js/jquery.js"></script>
<!--<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript" src="js/raphael.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/canvas2image.js"></script>
<script type="text/javascript" src="js/bootstrap-button.js"></script>
<script type="text/javascript" src="js/notepad.js"></script>-->
<!--js -->

 <script type="text/javascript" src="swfobject.js"></script>
  <script type="text/javascript" src="web_socket.js"></script>
  <script type="text/javascript" src="notepad.js"></script>

  <!-- <script type="text/javascript">
    
    // Set URL of your WebSocketMain.swf here:
    WEB_SOCKET_SWF_LOCATION = "WebSocketMain.swf";
    // Set this to dump debug message from Flash to console.log:
    WEB_SOCKET_DEBUG = true;
    
    // Everything below is the same as using standard WebSocket

	
			var inc = document.getElementById('incomming');
           // window.ws = window.WebSocket || window.MozWebSocket;
		   
            var lastPt = [];
			var drawchk =true;
			var allPts="";
			var x = "";
			
			var start = function () {
				var form = document.getElementById('sendForm');
    			var input = document.getElementById('sendText');
				var canvas  = document.getElementById("ex1");
				if(chkIE){
					if (G_vmlCanvasManager != undefined) { // ie IE
						canvas = G_vmlCanvasManager.initElement(canvas);
					}
				}
				var context = canvas.getContext("2d");
				context.clearRect(0, 0,  canvas.width, canvas.height);
				context.fillStyle="#FFFFFF";

				context.fillRect(0,0,canvas.width, canvas.height);

				context.fillStyle="#FFFFFF";
				
								
			// create a new websocket and connect
			//window.ws = new wsImpl('ws://localhost:5011/HITECH', 'my-protocol');
            // when data is comming from the server, this metod is called
			
				ws = new WebSocket("ws://localhost:444/HITECH");
			
				ws.onmessage = function (evt) {
                // inc.innerHTML += evt.data + '<br/>';
				//   console.log(evt);
				 $("#result").val(''+evt.data);
				// alert(evt.data);
				 if(evt.data == "ACK"){
				 
					if(chkCanvasEmpty){
					
					  var r=confirm("Want clear a note");
					if (r==true)
					  {
						var canvas  = document.getElementById("ex1");
						if(navigator.userAgent.toLowerCase().indexOf("msie") > -1){
						var ver = getInternetExplorerVersion();
						   if ( ver> -1 )
						   {
							  if ( ver <= 8.0 ){
								if (G_vmlCanvasManager != undefined) { // ie IE
									canvas = G_vmlCanvasManager.initElement(canvas);
								}
								}
							}
					}

						var context = canvas.getContext("2d");
						context.clearRect(0, 0,  canvas.width, canvas.height);
						context.fillStyle="#FFFFFF";

						context.fillRect(0,0,canvas.width, canvas.height);

						context.fillStyle="#FFFFFF";
					  }
					  }
					 ws.send("GETXY");
				 }else if(evt.data == "EMPTY"){
					moomoo();
					t = setTimeout(function(){ws.send("GETXY");}, 1000);
					
				}else if(evt.data == "DISCONNCTED"){
					//setTimeout('moomoo()', 1000);
					//ws.send("GETXY");
					alert("disconnected");
					
				 }else if(evt.data == "EARSED"){
					//setTimeout('moomoo()', 1000);
					//ws.send("GETXY");
					alert("Data Cleared");
					
				 }else if(evt.data == "DETECTED"){
					//setTimeout('moomoo()', 1000);
					//ws.send("GETXY");
					alert("Device Identified");
					
				 }else if(evt.data == "CONNECTED"){
					//setTimeout('moomoo()', 1000);
					//ws.send("GETXY");
					alert("Connected");
					
				 }else if(evt.data == "NODEVICE"){
					//setTimeout('moomoo()', 1000);
					//ws.send("GETXY");
					alert("ERROR:No Device found or Connection Lost.");
					
				 }else if(evt.data == "HITECH"){
					//setTimeout('moomoo()', 1000);
					//ws.send("GETXY");
					alert(evt.data);
					
				 }else if(evt.data == "ERR"){
					//setTimeout('moomoo()', 1000);
					//ws.send("GETXY");
					alert("ERROR: Check the connection or Device busy.");
					
				 }else if(evt.data == "NODATA"){
					//setTimeout('moomoo()', 1000);
					//ws.send("GETXY");
					alert("No Offline Data Available");
					
				 }else{
					
				//		x += evt.data;
				//		alert(evt.data);
				 if(drawchk){
					
						drawData(evt.data);
			
				}
				}
				 
				
            };

            // when the connection is established, this method is called
            ws.onopen = function () {
                $("#result").val('.. connection open<br/>');
				
            };

            // when the connection is closed, this method is called
            ws.onclose = function () {
					// inc.innerHTML += '.. connection closed<br/>';
					//alert("Server Colosed or Disconnected.");
					$("#result").val('.. connection closed<br/>');
				};
            

            
        }
       
		
		/*function sendPacket(){
			var val = input.value;
				ws.send(val);
				input.value = "";
		}*/
	            	var j =0;
	var downVal = 0;
	var t=0;
	var chkCanvasEmpty =false;
	var imgAry = new Array();
	var ws ;
	var lastPt = new Array();
	var chkIE = false;
		function drawData(data){
		//	alert(navigator.userAgent.toLowerCase());
			var canvas  = document.getElementById("ex1");
			if(chkIE){
			if (G_vmlCanvasManager != undefined) { // ie IE
				canvas = G_vmlCanvasManager.initElement(canvas);
			}
			}
			var context = canvas.getContext("2d");
			context.beginPath();
			var d = data;
			var draw = false;
			//alert(d);
			drawchk=true;
			if(d != "EMPTY"){
				
				if(chkIE){
					var xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
					xmlDoc.loadXML(d);
					d = xmlDoc;
				}
		//	var xmlPnode = xmlDoc.getElementsByTagName("ENTRIES").getChildNodes();;
		//	for(var k=0; k<xmlPnode.length; k++){
			
			$(d).find('FROM').each(function(){
				var p = $(this).text();
				if(p == "GETXY"){
				$(d).find('XY').each(function(i){
				//var $entry = $(this);
				var pic = $(this).text();
					var tempAry = new Array();
				var tempAry1 = new Array();
				var x = new Array();
				var y = new Array();
				
				tempAry = pic.split("#");
				//alert(pic);
				//for(var p=0; p<tempAry.length; p++){
					tempAry1 = tempAry[0].split(":");
					x = tempAry[1].split(":");
					y = tempAry[2].split(":");
					if($.trim(tempAry1[0]) == "ST" && $.trim(tempAry1[1]) == "1"){
						//	alert($.trim(x[1])+":"+$.trim(y[1]));
							//context.moveTo($.trim(x[1]),$.trim(y[1]));
							draw = true;
							lastPt[0] = $.trim(x[1]);
							lastPt[1] = $.trim(y[1]);
					}else if ($.trim(tempAry1[0]) == "ST" && $.trim(tempAry1[1]) == "2"){
						//if(draw){
							//if(lastPt != null && lastPt.length > 0 ){
								
							
						//	console.log($.trim(lastPt[0])+":"+$.trim(lastPt[1]));
							
							context.moveTo($.trim(lastPt[0]),$.trim(lastPt[1]));
							
							context.lineTo($.trim(x[1]),$.trim(y[1]));
							//console.log($.trim(x[1])+":"+$.trim(y[1]));
							lastPt[0] = $.trim(x[1]);
							lastPt[1] = $.trim(y[1]);
							context.stroke();
					
						
						//}
					}else if ($.trim(tempAry1[0]) == "ST" && $.trim(tempAry1[1]) == "3"){
							draw = false;
							//lastPt = [];
					}else if($.trim(tempAry1[0]) == "ST" && $.trim(tempAry1[1]) == "4"){
					
					}

				//}
					}); 
					
					chkCanvasEmpty = true;
					moomoo();
				t = setTimeout(function(){ws.send("GETXY")}, 10);
					//sleep(2000);
					//ws.send("GETXY");

				}else if(p == "DOWNLOAD"){
				context.clearRect(0, 0,  canvas.width, canvas.height);
				 
					context.fillStyle="#FFFFFF";

					context.fillRect(0,0,canvas.width, canvas.height);

					context.fillStyle="#FFFFFF";
							var p = $(d).find('COUNT').text();
							$('#downCount').val(''+p);
							
				context.moveTo($.trim(lastPt[0]),$.trim(lastPt[1]));
				$("#currCount").val(''+j);
					var note = $(d).find('NOTE');
					for(var c =j; c<p; c++){
						$(note[c]).find('XY').each(function(i){
						//var $entry = $(this);
						var pic = $(this).text();
						var tempAry = new Array();
						var tempAry1 = new Array();
						var x = new Array();
						var y = new Array();
						tempAry = pic.split("#");
						//for(var p=0; p<tempAry.length; p++){
						tempAry1 = tempAry[0].split(":");
						x = tempAry[1].split(":");
						y = tempAry[2].split(":");
						if($.trim(tempAry1[0]) == "ST" && $.trim(tempAry1[1]) == "1"){
							//	alert($.trim(x[1])+":"+$.trim(y[1]));
								context.moveTo($.trim(x[1]),$.trim(y[1]));
								draw = true;
								if(lastPt.length>0){
									lastPt[0] = $.trim(x[1]);
									lastPt[1] = $.trim(y[1]);
								}
						}else if ($.trim(tempAry1[0]) == "ST" && $.trim(tempAry1[1]) == "2"){
							if(draw){
								//if(lastPt != null && lastPt.length > 0 ){
									context.lineTo($.trim(lastPt[0]),$.trim(lastPt[1]));
								
								context.lineTo($.trim(x[1]),$.trim(y[1]));
								lastPt[0] = $.trim(x[1]);
								lastPt[1] = $.trim(y[1]);
								context.stroke();
								chkCanvasEmpty=true;
							}
						}else if ($.trim(tempAry1[0]) == "ST" && $.trim(tempAry1[1]) == "3"){
								draw = false;
								//lastPt = [];
						}else if($.trim(tempAry1[0]) == "ST" && $.trim(tempAry1[1]) == "4"){
						
						}

					//}
						}); 
						c = c+p;
					}
				
				}
			});
			//}
			drawchk= true;
			}
			context.closePath();
			
			
			
		}
		function moomoo(){
			clearTimeout(t);
		}
		
		function detectchk(){
			moomoo();
			ws.send("DETECT");
		}
		function connect(){
			moomoo();
			ws.send("CONNECT");
		}
		function online(){
			ws.send("ONLINE");
		}
		function erase(){
			moomoo();
			ws.send("ERASE");
			//ws.close();
		}
		function disconnect(){
			moomoo();
			ws.send("DISCONNECT");
		//	ws.close();
		}
		function datadownload(){
			moomoo();
			ws.send("DOWNLOAD");
		}
		
		function connTest(){
			moomoo();
			ws.send("HITECH");
		}
		
		function imgSave(){
			moomoo();
			var canvas  = document.getElementById("ex1");
			 var dataURL = canvas.toDataURL("image/png");
			 imgAry = new Array();
			 imgAry = dataURL.split(",");
			
			
			$("#resultImg").val(''+imgAry[1]);
			
			document.getElementById('canvasImg').src = dataURL;
			
			checkImg = true;
			
			
			
			document.getElementById("sendForm").submit();
			//loadCanvas(dataURL);
		}
		
		function showPrev(){
			j = j-1;
			if(j >= 0){
				
						var canvas  = document.getElementById("ex1");
						if(navigator.userAgent.toLowerCase().indexOf("msie") > -1){
					var ver = getInternetExplorerVersion();
						   if ( ver> -1 )
						   {
							  if ( ver <= 8.0 ){
								if (G_vmlCanvasManager != undefined) { // ie IE
									canvas = G_vmlCanvasManager.initElement(canvas);
								}
								}
							}
			}

						var context = canvas.getContext("2d");
						context.clearRect(0, 0,  canvas.width, canvas.height);
				drawData($('#result').val());
			}else{
				j = $("#downCount").val() - 1;
					var canvas  = document.getElementById("ex1");
					if(navigator.userAgent.toLowerCase().indexOf("msie") > -1){
			var ver = getInternetExplorerVersion();
						   if ( ver> -1 )
						   {
							  if ( ver <= 8.0 ){
								if (G_vmlCanvasManager != undefined) { // ie IE
									canvas = G_vmlCanvasManager.initElement(canvas);
								}
								}
							}
			}

						var context = canvas.getContext("2d");
						context.clearRect(0, 0,  canvas.width, canvas.height);
				drawData($('#result').val());
			}
		}
		
		function showNext(){
			j = j+1;
			if(j < $("#downCount").val()){
				
						var canvas  = document.getElementById("ex1");
						var context = canvas.getContext("2d");
						context.clearRect(0, 0,  canvas.width, canvas.height);
				drawData($('#result').val());
			}else{
				j = 0;
					var canvas  = document.getElementById("ex1");
						var context = canvas.getContext("2d");
						context.clearRect(0, 0,  canvas.width, canvas.height);
				drawData($('#result').val());
			}
		}
		
		
		var removeBlanks = function (imgWidth, imgHeight,context,canvas) {
    var imageData = context.getImageData(0, 0, imgWidth, imgHeight),
        data = imageData.data,
        getRBG = function(x, y) {
            var offset = imgWidth * y + x;
            return {
                red:     data[offset * 4],
                green:   data[offset * 4 + 1],
                blue:    data[offset * 4 + 2],
                opacity: data[offset * 4 + 3]
            };
        },
        isWhite = function (rgb) {
            // many images contain noise, as the white is not a pure #fff white
            return rgb.red > 200 && rgb.green > 200 && rgb.blue > 200;
        },
        scanY = function (fromTop) {
            var offset = fromTop ? 1 : -1;
            
            // loop through each row
            for(var y = fromTop ? 0 : imgHeight - 1; fromTop ? (y < imgHeight) : (y > -1); y += offset) {
                
                // loop through each column
                for(var x = 0; x < imgWidth; x++) {
                    var rgb = getRBG(x, y);
                    if (!isWhite(rgb)) {
                        return y;                        
                    }      
                }
            }
            return null; // all image is white
        },
        scanX = function (fromLeft) {
            var offset = fromLeft? 1 : -1;
            
            // loop through each column
            for(var x = fromLeft ? 0 : imgWidth - 1; fromLeft ? (x < imgWidth) : (x > -1); x += offset) {
                
                // loop through each row
                for(var y = 0; y < imgHeight; y++) {
                    var rgb = getRBG(x, y);
                    if (!isWhite(rgb)) {
                        return x;                        
                    }      
                }
            }
            return null; // all image is white
        };
    
    var cropTop = scanY(true),
        cropBottom = scanY(false),
        cropLeft = scanX(true),
        cropRight = scanX(false),
        cropWidth = cropRight - cropLeft,
        cropHeight = cropBottom - cropTop;
    
    var $croppedCanvas = $("<canvas>").attr({ width: cropWidth, height: cropHeight });
    
    // finally crop the guy
    $croppedCanvas[0].getContext("2d").drawImage(canvas,
        cropLeft, cropTop, cropWidth, cropHeight,
        0, 0, cropWidth, cropHeight);
    
    $("body").
        append("<p>same image with white spaces cropped:</p>").
        append($croppedCanvas);
    console.log(cropTop, cropBottom, cropLeft, cropRight);
};
		
		
		function getInternetExplorerVersion()
// Returns the version of Windows Internet Explorer or a -1
// (indicating the use of another browser).
{
   var rv = -1; // Return value assumes failure.
   if (navigator.appName == 'Microsoft Internet Explorer')
   {
      var ua = navigator.userAgent;
      var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
      if (re.exec(ua) != null)
         rv = parseFloat( RegExp.$1 );
   }
   return rv;
}

		
		
		function chkIe(){
			if(navigator.userAgent.toLowerCase().indexOf("msie") > -1){
				var ver = getInternetExplorerVersion();
					if ( ver> -1 ){
						if ( ver <= 8.0 ){
							if (G_vmlCanvasManager != undefined) {
								chkIE = true;
							}
						}
					}
				}
		}
		
		
			 function loadCanvas(dataURL) {
        var img = new Image(),
    $canvas = $("<canvas>"),
    canvas = $canvas[0],
    context;
		img.crossOrigin = "anonymous";
		img.onload = function () {
    $canvas.attr({ width: this.width, height: this.height });
    context = canvas.getContext("2d");
    if (context) {
        context.drawImage(this, 0, 0);
        $("body").append("<p>original image:</p>").append($canvas);
    
        removeBlanks(this.width, this.height,context,canvas);
    } else {
        alert('Get a real browser!');
    }
};

        img.src = dataURL;
      }
	  
	  			$(document).ready(function(){
						chkIe();
						var canvas = document.getElementById("ex1");
						 if(chkIE){
								if (G_vmlCanvasManager != undefined) { // ie IE
									canvas = G_vmlCanvasManager.initElement(canvas);
								}
						}

					if (canvas.getContext) {
					var context = canvas.getContext("2d");
					context.fillStyle = "#FFFFFF";	
					context.fillRect(0,0,canvas.width, canvas.height);
					context.fillStyle = "#FFFFFF";
		
					}
					var hasFlash = false;
					try {
					  var fo = new ActiveXObject('ShockwaveFlash.ShockwaveFlash');
					  if(fo){ hasFlash = true;}else{alert("Please install flash player to continue....")}
					}catch(e){
					  if(navigator.mimeTypes ["application/x-shockwave-flash"] != undefined) hasFlash = true;
					}
					
					
					
				});
	  
			
			
		window.onload = start;	
		
		
		</script>
			 -->
			 
		<script type="text/javascript">
<!--
connect();
//-->
</script>	
	
</head>

	<!--header starts-->
	<!--<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<h2>HiTech paint</h2>

			</div>
		</div>
	</div>-->
	<!--header ends-->

	<!--container starts-->
	<form id="sendForm" action="epenNote.php?patientid=<?php echo $_GET['patientid']?>&noteId=<?php echo $_GET['noteID']?>&flag=success" method="post" target="_top">
	<input type="hidden" name="patientid" value="<?php echo $_GET['patientid']?>">
	
		
	<div>
		

			<div class="span2" style="display:none;">
				
			</div>
			<div class="span7">

				<div class="span7" style="margin: 0px;">
					<!--sapn 5 starts -->

					
					<div class="span6" data-toggle="buttons-radio" style="width:672px;margin: 0px;margin-bottom: 5px;">
					
						<button class="btn btn-success btn-small" 
							style="height: 28px; margin-top: 1px;display:none;" onclick="detectchk();"type="button">

							DETECT
						</button>
						
						<button class="btn btn-success btn-small"
							style="height: 28px; margin-top: 1px;margin-right:5px" onclick="connect();"  type="button">
							<!-- <a href="#about"><i class="icon-pencil" title="pencil"></i></a> -->
							CONNECT

						</button>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<button class="btn btn-success btn-small"
							style="height: 28px; margin-top: 1px;margin-right:5px" onclick="online();" type="button">
							<!-- <a href="#about"><i class="icon-adjust" title="eraser"></i></a> -->
							ONLINE
						</button>
						<button class="btn btn-success btn-small"
							style="height: 28px; margin-top: 1px;display:none;"  onclick="erase();" type="button">
							<!-- <a href="#about"><i class="icon-refresh" title="refresh"></i></a> -->
							ERASE
						</button>
						<button class="btn btn-success btn-small"
							style="height: 28px; margin-top: 1px;display:none;"onclick="datadownload();" type="button">
							<!-- <a href="#about"><i class="icon-download" title="download"></i></a> -->
							DOWNLOAD
						</button>

						<button class="btn btn-success btn-small"
							style="height: 28px; margin-top: 1px;margin-right:5px" onclick="disconnect();" type="button">
							<!-- <a href="#about"><i class="icon-download" title="new"></i></a> -->
							DISCONNECT
						</button>
						
						<button class="btn btn-success btn-small"
							style="height: 28px; margin-top: 1px;display:none;" onclick="showPrev();">

							<img src="img/glyphicons_221_unshare.png" title="Prev">
						</button>
						
						<input	type="text"  id="currCount" name="currCount" style="width:20px; float:left;display:none;" value=""/>
						<button class="btn btn-success btn-small"
							style="height: 28px; margin-top: 1px;display:none;" onclick="showNext()">

							<img src="img/glyphicons_222_share.png" title="Next">
						</button>
						
						
						<button class="btn btn-success btn-small"
							style="height: 28px; margin-top: 1px;"onclick="imgSave();" type="submit">
							<!-- <a href="#about"><i class="icon-download" title="new"></i></a> -->
							SAVE  
						</button><span id="displayalert" style="padding-left:10px;padding-top:10px;"></span>
						<!-- <button class="btn btn-success btn-small"  style="height:28px; margin-top: 1px;">
								
								<img src="img/glyphicons_236_zoom_in.png"title="zoom-in">
							</button>

							<button class="btn btn-success btn-small" style="height:28px; margin-top: 1px;">
								
								<img src="img/glyphicons_237_zoom_out.png" title="zoom-out">
							</button> -->
						

						<button class="btn btn-success btn-small"
							style="height: 28px; margin-top: 1px; display:none;" onclick="javascript:cRedo();">

							<img src="img/glyphicons_222_share.png" title="redo">
						</button>


						

						
					</div>

					
					<div class="span6" data-toggle="buttons-radio" style="margin: 0px;margin-bottom: 5px;display:none;">
						<button class="btn btn-success btn-small"
							style="height: 28px; margin-top: 1px;" onclick="pencil();">
							<!-- <a href="#about"><i class="icon-pencil" title="pencil"></i></a> -->
							<img src="img/glyphicons_234_brush.png" title="pencil"
								>

						</button>
						<button class="btn btn-success btn-small"
							style="height: 28px; margin-top: 1px;" onclick="eraser();">
							<!-- <a href="#about"><i class="icon-adjust" title="eraser"></i></a> -->

							<img src="img/glyphicons_161_macbook.png" title="eraser"
								>
						</button>
						<button class="btn btn-success btn-small"
							style="height: 28px; margin-top: 1px;"  onclick="clearAll();">
							<!-- <a href="#about"><i class="icon-refresh" title="refresh"></i></a> -->
							<img src="img/glyphicons_081_refresh.png" title="refresh"
								style="margin-top: -2px;">
						</button>
						<button class="btn btn-success btn-small"
							style="height: 28px; margin-top: 1px;"onclick="download();">
							<!-- <a href="#about"><i class="icon-download" title="download"></i></a> -->
							<img src="img/glyphicons_181_download_alt.png" title="download"
								>
						</button>

						<button class="btn btn-success btn-small"
							style="height: 28px; margin-top: 1px;"onclick="newPage();">
							<!-- <a href="#about"><i class="icon-download" title="new"></i></a> -->
							<img src="img/glyphicons_248_asterisk.png" title="new"
								>
						</button>

						<!-- <button class="btn btn-success btn-small"  style="height:28px; margin-top: 1px;">
								
								<img src="img/glyphicons_236_zoom_in.png"title="zoom-in">
							</button>

							<button class="btn btn-success btn-small" style="height:28px; margin-top: 1px;">
								
								<img src="img/glyphicons_237_zoom_out.png" title="zoom-out">
							</button> -->
						<button class="btn btn-success btn-small"
							style="height: 28px; margin-top: 1px;" onclick="javascript:cUndo();">

							<img src="img/glyphicons_221_unshare.png" title="undo">
						</button>


						<button class="btn btn-success btn-small"
							style="height: 28px; margin-top: 1px;" onclick="javascript:cRedo();">

							<img src="img/glyphicons_222_share.png" title="redo">
						</button>


						<div class="btn btn-success btn-small"
							style="height: 22px; margin-top: 1px;">
							<!-- 	<div class="span1"> -->
							<div class="preview" title="Choose a color"></div>
								<!-- colorpicker element -->
						<div class="colorpicker" style="z-index:0; display: none;">
							<canvas id="picker" var="1" width="200" height="200"></canvas>

							<div class="controls">
								<div>
									<label>R</label> <input type="text" id="rVal" />
								</div>
								<div>
									<label>G</label> <input type="text" id="gVal" />
								</div>
								<div>
									<label>B</label> <input type="text" id="bVal" />
								</div>
								<div>
									<label>RGB</label> <input type="text" id="rgbVal" />
								</div>
								<div>
									<label>HEX</label> <input type="text" id="hexVal" />
								</div>
							</div>
						</div>
							<!-- </div> -->
						</div>

						<div class="btn btn-success btn-small" title="brush size"
							style="width: 85px;height: 22px; margin-top: 1px;">
							<div id="paintslider"
						class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"
						style="width: 77%;margin-top: 7px;height: 6px;">
						<div class="ui-slider-range ui-widget-header ui-slider-range-min"
							style="width: 0%;"></div>
						<a class="ui-slider-handle ui-state-default ui-corner-all"
							href="#" data-original-title="" style="width: 7px; height: 12px;"></a><span class="size"
							id="slidervalue"></span>
						<div class="ui-slider-range ui-widget-header ui-slider-range-min"></div>
					</div>

						</div>
					</div>

					<div class="span1"></div>

				</div>
				<!--sapn 5 ends -->
		

		
	
		
		<canvas id="ex1" width="1030" height="2000" > </canvas>
			<!-- 	<canvas id="paint" width="800" height="1000" class="canvo"></canvas>
				<input type="input" id="sendText"  value="" />
				<textarea id="result" style="width:800; height:1000;" ></textarea> 
				
				<input id="sendText" placeholder="Text to send" /> <input type="button" id="onlineBtn" name="onlineBtn" onclick="online();" value="Online" />
				-->
				
		<input id="downCount" name="downCount"  value="" style="display:none;" />
		<textarea rows="10" column="100" id="result" style="display:none;"></textarea>
		<!--<img id="canvasImg" alt="Right click to save me!">-->
		<input type="hidden"  id="resultImg" name="resultImg" style="display:none;" value="" />
		<input type="hidden"  id="checkImg" name="checkImg" style="display:none;" value="false" />
		<br /><br /><br /> 
		
			</div>
		
	</div>
</form>
<?php
if(isset($_POST['checkImg']) && $_POST['checkImg'] == true){

	define('UPLOAD_DIR', 'epenImg/');
	$image_base64 = $_POST['resultImg'];
	$image_base64 = base64_decode($image_base64);
	$img = imagecreatefromstring($image_base64);

    $file = UPLOAD_DIR . $_POST['patientid']."_".uniqid() . '.jpg';
	file_put_contents($file,$image_base64);
echo "<pre>";print_r($dbConfig);
   $dblink = mysqli_connect($dbConfig->default['host'], $dbConfig->default['login'], $dbConfig->default['password'], $dbConfig->defaultHospital['database']);
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
   //update patient table with image name
   $result=  mysqli_query($dblink, "select epenImages from patients where id='".$_POST['patientid']."'") or die(mysqli_error($dblink)." Q=".$q);;
   $row = mysqli_fetch_array($result, MYSQLI_NUM);

  if(!empty($row['0']))
    $imagename=$row['0']."|".$file;
else
   $imagename=$file;
   
   mysqli_query($dblink, "update patients set epenImages='".$imagename."' where id='".$_POST['patientid']."'");
   mysqli_free_result($result);
	//print $success ? $file : 'Unable to save the file.';

 }
?>


</body>

</html>