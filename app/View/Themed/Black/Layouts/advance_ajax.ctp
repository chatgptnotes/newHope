<style>
	.error {
		background: #d7c487;
		padding: 7px 5px;
		border: 1px solid #e8d495;
		font-size: 13px;
		color: #8c0000;
		font-weight: bold;
		text-shadow: 1px 1px 1px #ecdca8;
		margin: 5px 0;
		display: block;
		text-align: center;
	}
	
	.message {
		background: #acc586;
		padding: 7px 13px;
		border: 1px solid #c0dc96;
		font-size: 13px;
		color: #2e4c00;
		font-weight: bold;
		text-shadow: 1px 1px 1px #c3dba0;
		margin: 5px 0;
		display: block;
		text-align: center;
	}
	
	#busy-indicator {
		display: none;
		position: fixed;
		left: 50%;
		top: 50%;
		z-index: 2000;
	}
	
	#model-alert{color:#000 !important ;display:none;}
	
</style>
<title><?php echo __('Hope', true); ?> <?php echo $title_for_layout;?>
</title>
<?php 
echo $this->Html->meta('icon');
echo $this->Html->script(array('jquery-1.9.1.js','jquery-ui-1.10.2.js',
		'jquery.validationEngine2','/js/languages/jquery.validationEngine-en','ui.datetimepicker.3.js'));
echo $this->Html->css(array('internal_style.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','jquery-ui.css')) ;

?>


<script>

window.alert = function(message) {
	 
	var modal = $("#model-alert").text(message).dialog({ 
    	hide: { /*effect: "explode",*/ duration: 1000 },
    	modal:true,
        title:'<?php //echo $this->Session->read('username');?>',
        buttons: {
            'OK':function(){ 
            	$(this).dialog( "close" );
            	$(this).dialog( "destroy" ); 
            }
        }, 
        dialogClass: "no-close",
    });
};


var matched, browser;

jQuery.uaMatch = function( ua ) {
    ua = ua.toLowerCase();

    var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
        /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
        /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
        /(msie) ([\w.]+)/.exec( ua ) ||
        ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
        [];

    return {
        browser: match[ 1 ] || "",
        version: match[ 2 ] || "0"
    };
};

matched = jQuery.uaMatch( navigator.userAgent );
browser = {};

if ( matched.browser ) {
    browser[ matched.browser ] = true;
    browser.version = matched.version;
}

// Chrome is Webkit, but Webkit is also Safari.
if ( browser.chrome ) {
    browser.webkit = true;
} else if ( browser.webkit ) {
    browser.safari = true;
}

jQuery.browser = browser;
</script>
<?php echo $this->Session->flash(); ?>
	 
	<div align="center" id = 'busy-indicator'>	
		&nbsp; <?php echo $this->Html->image('indicator.gif', array()); ?>
	</div>
<div id="model-alert" class="clr"></div>
<?php echo $content_for_layout; ?>   

<script>
$(document).ready(function (){
	timer ='' ; 
	setIntervalForSessionMsgHide();
	$("#flashMsgClose").click(function(){
		hideSessionMsg();//hide and clear timeing
	});
});

function setIntervalForSessionMsgHide(){ 
	//$("#flashMessage").append('<?php //echo $this->Html->image('/icons/cross.png',array("id"=>'flashMsgClose')); ?> ') ;
	window.setTimeout("hideSessionMsg()", (5000));
}

function hideSessionMsg(){  
	$("#flashMessage").fadeOut("slow");
	clearInterval(timer);
} 
</script>