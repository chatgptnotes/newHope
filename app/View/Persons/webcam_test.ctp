<style>

#webcam, #canvas {
    -moz-border-radius: 20px 20px 20px 20px;
    background: none repeat scroll 0 0 #EEEEEE;
    border: -3px solid #333333;
    width: 320px;
}
#webcam {
    margin-bottom: 50px;
    margin-top: 50px;
    position: relative;
}
#webcam > span {
    bottom: -16px;
    color: #EEEEEE;
    font-size: 10px;
    left: 152px;
    position: absolute;
    z-index: 2;
}
#webcam > img {
    border: 0 none;
    bottom: -40px;
    left: 89px;
    padding: 0;
    position: absolute;
    z-index: 1;
}
#webcam > div {
    -moz-border-radius: 8px 8px 8px 8px;
    border: 5px solid #333333;
    cursor: pointer;
    padding: 5px;
    position: absolute;
    right: -90px;
}
#webcam a {
    background: none repeat scroll 0 0 #FFFFFF;
    font-weight: bold;
}
#webcam a > img {
    border: 0 none;
}
#canvas {
    background: none repeat scroll 0 0 #EEEEEE;
    border: 20px solid #CCCCCC;
}
#flash {
    background-color: #CC0000;
    display: none;
    height: 500px;
    left: 0;
    position: absolute;
    top: 0;
    width: 100%;
    z-index: 5000;
}
object {
    display: block;
    position: relative;
    z-index: 1000;
}
 
</style>
<script>
var pos = 0;
var ctx = null;
var cam = null;
var image = null;

var filter_on = false;
var filter_id = 0;

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
</script>
<?php

	echo $this->Html->script(array('jquery.webcam','jquery.ui.widget.js','jquery.ui.mouse.js','jquery.ui.core.js','jquery.ui.slider.js','jquery-ui-timepicker-addon.js'));
	
?>
<div class="inner_title">
	<h3>&nbsp; <?php echo __('UIDPatient details', true); ?></h3>
	<span> <?php echo $this->Html->link(__('Search UIDpatient'),array('action' => 'search'), array('escape' => false,'class'=>'blueBtn')); ?></span>
</div>
<?php echo $this->Form->create('Person',array('type' => 'file','id'=>'personfrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false
																								    )
			)); ?>
		<?php 
		  if(!empty($errors)) {
		?>
		<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
		 <tr>
		  <td colspan="2" align="left" class="error">
		   <?php 
		     foreach($errors as $errorsval){
		         echo $errorsval[0];
		         echo "<br />";
		     }
		   ?>
		  </td>
		 </tr>
		</table>
		<?php } ?>
	  <div class="inner_left"> 
			<?php //BOF new form design ?>
			<!-- form start here -->
                   <div class="btns">
                          <input class="grayBtn" type="button" value="Cancel" onclick="window.location='<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "search"));?>'">
						  <input class="blueBtn" type="submit" value="Submit">
                   </div>
                   <div class="clr"></div>
                   <!-- Patient Information start here -->
                   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
                   	                   
                     <tr>
                       <td class="tdLabel" id="boxSpace">Patient's Photo</td>
                       <td><?php echo $this->Form->input('upload_image', array('type'=>'file','id' => 'patient_photo', 'label'=> false,
					 	'div' => false, 'error' => false));
						
						
						?>
						<p style="height: 22px; color: rgb(204, 0, 0); font-weight: bold;" id="status"></p>
						<div id="webcam"></div>
						<p style="width: 360px; text-align: center;"><a href="javascript:webcam.capture(3);changeFilter();void(0);">Take a picture after 3 seconds</a> | <a href="javascript:webcam.capture();changeFilter();void(0);">Take a picture instantly</a></p>
						<p><canvas id="canvas" height="240" width="320"></canvas></p>

						<h3>Available Cameras</h3>

						<ul id="cams"></ul> 
						</td>
                       <td>&nbsp;</td>
                  
                     </tr>
                     
</table>
</div>
<script>
		jQuery(document).ready(function(){
			// binds form submission and fields to the validation engine
			jQuery("#personfrm").validationEngine();
			//on realtion select
			$('#relation_to_employee').change(function(){
				$('#esi_suffix').val($(this).val());
			});		
		});
	 
		//script to include datepicker
		$(function() {
			
		$( "#uiddate" ).datetimepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
		});

$(function() {

        var pos = 0, ctx = null, saveCB, image = [];

        var canvas = document.createElement("canvas");
    canvas.setAttribute('width', 320);
        canvas.setAttribute('height', 240);
        
        if (canvas.toDataURL) {

                ctx = canvas.getContext("2d");
                
                image = ctx.getImageData(0, 0, 320, 240);
        
                saveCB = function(data) {
                        
                        var col = data.split(";");
                        var img = image;

                        for(var i = 0; i < 320; i++) {
                                var tmp = parseInt(col[i]);
                                img.data[pos + 0] = (tmp >> 16) & 0xff;
                                img.data[pos + 1] = (tmp >> 8) & 0xff;
                                img.data[pos + 2] = tmp & 0xff;
                                img.data[pos + 3] = 0xff;
                                pos+= 4;
                        }

                        if (pos >= 4 * 320 * 240) {
                                ctx.putImageData(img, 0, 0);
                                $.post("/upload.php", {type: "data", image: canvas.toDataURL("image/png")});
                                pos = 0;
                        }
                };

        } else {

                saveCB = function(data) {
                        image.push(data);
                        
                        pos+= 4 * 320;
                        
                        if (pos >= 4 * 320 * 240) {
                                $.post("/upload.php", {type: "pixel", image: image.join('|')});
                                pos = 0;
                        }
                };
        }

         

}); 
		
		
 /*$("#camera").webcam({
        width: 320,
        height: 240,
        mode: "callback",
        swffile: '<?php echo $this->Html->image("/img/swf/jscam_canvas_only.swf");?>',
        onTick: function() {},
        onSave: function() {},
        onCapture: function() {},
        debug: function() {},
        onLoad: function() {}
});*/
 
 


jQuery("#webcam").webcam({

	width: 320,
	height: 240,
	mode: "callback",
    swffile: "/img/swf/jscam_canvas_only.swf",

	onTick: function(remain) {

		if (0 == remain) {
			jQuery("#status").text("Cheese!");
		} else {
			jQuery("#status").text(remain + " seconds remaining...");
		}
	},

	onSave: function(data) {
		 
		var col = data.split(";");
		var img = image;

		if (false == filter_on) {

			for(var i = 0; i < 320; i++) {
				var tmp = parseInt(col[i]);
				img.data[pos + 0] = (tmp >> 16) & 0xff;
				img.data[pos + 1] = (tmp >> 8) & 0xff;
				img.data[pos + 2] = tmp & 0xff;
				img.data[pos + 3] = 0xff;
				pos+= 4;
			}

		} else {

			var id = filter_id;
			var r,g,b;
			var r1 = Math.floor(Math.random() * 255);
			var r2 = Math.floor(Math.random() * 255);
			var r3 = Math.floor(Math.random() * 255);

			for(var i = 0; i < 320; i++) {
				var tmp = parseInt(col[i]);

			 
				if (id == 0) {
					r = (tmp >> 16) & 0xff;
					g = 0xff;
					b = 0xff;
				} else if (id == 1) {
					r = 0xff;
					g = (tmp >> 8) & 0xff;
					b = 0xff;
				} else if (id == 2) {
					r = 0xff;
					g = 0xff;
					b = tmp & 0xff;
				} else if (id == 3) {
					r = 0xff ^ ((tmp >> 16) & 0xff);
					g = 0xff ^ ((tmp >> 8) & 0xff);
					b = 0xff ^ (tmp & 0xff);
				} else if (id == 4) {

					r = (tmp >> 16) & 0xff;
					g = (tmp >> 8) & 0xff;
					b = tmp & 0xff;
					var v = Math.min(Math.floor(.35 + 13 * (r + g + b) / 60), 255);
					r = v;
					g = v;
					b = v;
				} else if (id == 5) {
					r = (tmp >> 16) & 0xff;
					g = (tmp >> 8) & 0xff;
					b = tmp & 0xff;
					if ((r+= 32) < 0) r = 0;
					if ((g+= 32) < 0) g = 0;
					if ((b+= 32) < 0) b = 0;
				} else if (id == 6) {
					r = (tmp >> 16) & 0xff;
					g = (tmp >> 8) & 0xff;
					b = tmp & 0xff;
					if ((r-= 32) < 0) r = 0;
					if ((g-= 32) < 0) g = 0;
					if ((b-= 32) < 0) b = 0;
				} else if (id == 7) {
					r = (tmp >> 16) & 0xff;
					g = (tmp >> 8) & 0xff;
					b = tmp & 0xff;
					r = Math.floor(r / 255 * r1);
					g = Math.floor(g / 255 * r2);
					b = Math.floor(b / 255 * r3);
				}

				img.data[pos + 0] = r;
				img.data[pos + 1] = g;
				img.data[pos + 2] = b;
				img.data[pos + 3] = 0xff;
				pos+= 4;
			}
		}

		if (pos >= 0x4B000) {
			ctx.putImageData(img, 0, 0);
			pos = 0;
		}
	},

	onCapture: function () {
		webcam.save();

		jQuery("#flash").css("display", "block");
		jQuery("#flash").fadeOut(100, function () {
			jQuery("#flash").css("opacity", 1);
		});
	},

	debug: function (type, string) {
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

window.addEventListener("load", function() {

	jQuery("body").append("<div id=\"flash\"></div>");

	var canvas = document.getElementById("canvas");

	if (canvas.getContext) {
		ctx = document.getElementById("canvas").getContext("2d");
		ctx.clearRect(0, 0, 320, 240);

		var img = new Image();
		img.src = "/static/logo.gif";
		img.onload = function() {
			ctx.drawImage(img, 129, 89);
		}
		image = ctx.getImageData(0, 0, 320, 240);
	}
	
	var pageSize = getPageSize();
	jQuery("#flash").css({ height: pageSize[1] + "px" });

}, false);

window.addEventListener("resize", function() {

	var pageSize = getPageSize();
	jQuery("#flash").css({ height: pageSize[1] + "px" });

}, false);



 
</script>