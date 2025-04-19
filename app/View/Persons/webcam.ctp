<?php echo $this->Html->css(array('internal_style','home-slider.css','ibox.css'));  
	 echo $this->Html->script(array('jquery-1.5.1.min.js','jquery.min.js?ver=3.3','jquery-ui-1.8.5.custom.min.js?ver=3.3','slides.min.jquery.js?ver=1.1.9',
									'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js'));
	echo $this->Html->script(array('jquery.webcam.js','excanvas.js'));
	
	
?>
	 
	<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	 
<style type="text/css">

#webcam, #canvas {
	width: 320px;
	border:20px solid #333;
	background:#eee;
	-webkit-border-radius: 20px;
	-moz-border-radius: 20px;
	border-radius: 20px;
	/*margin-top:32px;*/
	margin-bottom:50px;
}

#webcam {
	position:relative;
	
	float:left;
	width:320px;
	margin-left:20px;
}

#webcam > span {
	z-index:2;
	position:absolute;
	color:#eee;
	font-size:10px;
	bottom: -16px;
	left:152px;
}

#webcam > img {
	z-index:1;
	position:absolute;
	border:0px none;
	padding:0px;
	bottom:-40px;
	left:89px;
}

#webcam > div {
	border:5px solid #333;
	position:absolute;
	right:-90px;
	padding:5px;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	border-radius: 8px;
	cursor:pointer;
}

#webcam a {
	background:#fff;
	font-weight:bold;
}

#webcam a > img {
	border:0px none;
}

#canvas {
	border:20px solid #ccc;
	background:#eee;
	float:left;
}

#flash {
	position:absolute;
	top:0px;
	left:0px;
	z-index:5000;
	width:100%;
	height:500px;
	background-color:#c00;
	display:none;
}

object {
	display:block; /* HTML5 fix */
	position:relative;
	z-index:1000;
}

#status{
	height: 22px; color: rgb(204, 0, 0); font-weight: bold;
	text-align:center;
}
</style>

<html>
	<body style="margin:auto;" > 
		<div style="width:908px; height: 100%; margin:0 auto;position:relative;"> 
			<div style=" position:absolute; top:15%;>
				<h3 style="padding:0px">Available Cameras</h3>
				<ul id="cams"></ul>
				<p  id="status"></p>
				<div id="webcam"></div>
				<div style="width: 500px; text-align: center; float:left;margin-left:10px;">
					<div style="float:left; display:block; padding-right:16px; padding-top:120px; padding-left:7px;">			
					<a href="javascript:webcam.capture();changeFilter();void(0);" class="blueBtn" id="capture-btn">Capture >> </a>
					</div>
					<canvas width="320" height="240" id="canvas" ></canvas> 
				</div>
				<div><input id="take" type="button" value="OK" onclick="javascript:parent.$.fancybox.close();" class="blueBtn" style="float:right;display:none;" ></div>
				<div class="clr"></div>
			</div>
		</div>


<script type="text/javascript">
  
	var pos = 0;
	var ctx = null;
	var p_ctx=null
	var cam = null;
	var image = null;
	var p_image = null;
	
	var filter_on = false;
	var filter_id = 0;
	var swfurl  = '<?php echo $this->Html->url('/img/swf/jscam.swf'); ?>';
	
	function changeFilter() {
		if (filter_on) {
			filter_id = (filter_id + 1) & 7;
		}
	}
	
	function toggleFilter(obj) {
		if (filter_on =!filter_on) {
			obj.parentNode.style.borderColor = "#c00";
		} else {
			obj.parentNode.style.borderColor = "#333";
		}
	}
	
	
	
	function getPageSize() {
	
		var xScroll, yScroll;
	
		if (window.innerHeight && window.scrollMaxY) {
			xScroll = window.innerWidth + window.scrollMaxX;
			yScroll = window.innerHeight + window.scrollMaxY;
		} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
			xScroll = document.body.scrollWidth;
			yScroll = document.body.scrollHeight;
		} else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
			xScroll = document.body.offsetWidth;
			yScroll = document.body.offsetHeight;
		}
	
		var windowWidth, windowHeight;
	
		if (self.innerHeight) { // all except Explorer
			if(document.documentElement.clientWidth){
				windowWidth = document.documentElement.clientWidth;
			} else {
				windowWidth = self.innerWidth;
			}
			windowHeight = self.innerHeight;
		} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
			windowWidth = document.documentElement.clientWidth;
			windowHeight = document.documentElement.clientHeight;
		} else if (document.body) { // other Explorers
			windowWidth = document.body.clientWidth;
			windowHeight = document.body.clientHeight;
		}
	
		// for small pages with total height less then height of the viewport
		if(yScroll < windowHeight){
			pageHeight = windowHeight;
		} else {
			pageHeight = yScroll;
		}
	
		// for small pages with total width less then width of the viewport
		if(xScroll < windowWidth){
			pageWidth = xScroll;
		} else {
			pageWidth = windowWidth;
		}
	
		return [pageWidth, pageHeight];
	}
//check for IE
/*$(function() {  
	eventFunction = function() {
		
		jQuery("body").append("<div id=\"flash\"></div>");	
		var canvas = document.getElementById("canvas");
		var p_canvas = parent.document.getElementById("parent_canvas");
	
		if (canvas.getContext) {
			ctx = document.getElementById("canvas").getContext("2d");
			ctx.clearRect(0, 0, 320, 240);

			p_ctx = p_canvas.getContext("2d");
			p_ctx.clearRect(0, 0, 320, 120);
	
			var img = new Image();
			img.src = "/static/logo.gif";
			img.onload = function() {
				ctx.drawImage(img, 129, 89);
				p_ctx.drawImage(img, 129, 89);
			}
			image = ctx.getImageData(0, 0, 320, 240);
			//p_image = p_ctx.getImageData(0, 0, 320, 120);
		}
		
		var pageSize = getPageSize();
		jQuery("#flash").css({ height: pageSize[1] + "px" });
	
	};

	eventResize = function() {
	
		var pageSize = getPageSize();
		jQuery("#flash").css({ height: pageSize[1] + "px" });
	
	};
	if (window.addEventListener){
		window.addEventListener("load",eventFunction, false);
		window.addEventListener("resize",eventResize, false);
	} else if (window.attachEvent){
		window.attachEvent("load",eventFunction, false);
		window.attachEvent("resize",eventResize, false); 
	}
});*/
//EOF cehck for IE

	 
	
//canvas 
$(function() {

        var pos = 0, ctx = null, p_ctx = null,saveCB, image = [];
        var canvas = document.getElementById("canvas");
        var p_canvas = parent.document.getElementById("parent_canvas");
        
         
        if (canvas.toDataURL) {
				 
                ctx = canvas.getContext("2d");
                p_ctx = p_canvas.getContext("2d"); 
                
                image = ctx.getImageData(0, 0, 320, 240);
                
                
                saveCB = function(data) { 
                        var col = data.split(";");
                        var img = image;
						var tt ='';
                        for(var i = 0; i < 320; i++) {
                                var tmp = parseInt(col[i]);
                                
                                img.data[pos + 0] = (tmp >> 16) & 0xff;
                                img.data[pos + 1] = (tmp >> 8) & 0xff;
                                img.data[pos + 2] = tmp & 0xff;
                                img.data[pos + 3] = 0xff;
                                pos+= 4;
                        }
                        
                        if (pos >= 4 * 320 * 240) {
								 
								$('#take').show("slow"); 
                        		$('#canvas').show("fast");
                                ctx.putImageData(img, 0, 0);
                                p_ctx.putImageData(img, 0, 0);
                                parent.document.getElementById('parent_canvas').style.display = "block";
                                parent.document.getElementById('web_cam').value= canvas.toDataURL("image/png");
								
                                //uncomment to fire ajax request to upload captured image                                
                                //$.post("webcam", {type: "data", image: canvas.toDataURL("image/png")});
                                pos = 0;
                        }
                };

        } else { 
                saveCB = function(data) {
                        image.push(data); 
                        pos+= 4 * 320; 
                        if (pos >= 4 * 320 * 240) {
                                $.post("webcam", {type: "pixel", image: image.join('|')});
                                pos = 0;
                        }
                };
        }

        $("#webcam").webcam({ 
                width: 320,
                height: 240,
                mode: "callback",
                swffile: '<?php echo $this->Html->image('/img/swf/jscam_canvas_only.swf') ?>',
                onTick: function(remain) { 
                   
                    if (0 == remain) {
                        jQuery("#status").html("Cheese!");
                    } else {
                        jQuery("#status").html(remain + " seconds remaining...");
                    }
                   
                },
                onSave: saveCB,

                onCapture: function () { 
        			webcam.save('<?php echo $this->Html->url(array('controller'=>'persons','action'=>'webcam')); ?>'); 
        			jQuery("#flash").css("display", "block");
        			jQuery("#flash").fadeOut(100, function () {
        				jQuery("#flash").css("opacity", 1);
        			});
        		}, 
        		debug: function (type, string) {
        			 if(string=='Camera started') $('#capture-btn').show();
        			jQuery("#status").html(type + ": " + string);
        		}, 
        		onLoad: function () { 
        			var cams = webcam.getCameraList();   
        			for(var i in cams) {
        				jQuery("#cams").append("<li>" + cams[i] + "</li>");
        			}
        			 
        		}
        });

});


//eof canvas
</script>

	</body>
</html>


