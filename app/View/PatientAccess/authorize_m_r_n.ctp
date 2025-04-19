<?php echo $this->Html->charset(); ?>
<?php 
echo $this->Html->script(array('jquery-1.5.1.min','jquery-ui-1.8.16.custom.min'));
echo $this->Html->css(array('jquery-ui-1.8.16.custom','jquery.ui.all.css','internal_style.css','jquery.fancybox-1.3.4.css'));
?>
</head>
<style>
#head {
	text-align: center;
	color: white;
	padding-top: 20px;
	background-color: #363F42;
}
</style>
<?php echo $this->Form->create('',array('action'=>'authorizeMRN','type'=>'post','id'=>'authorizefrm'));?>
<body>
	<?php if(empty($showUpdate)){
		$display='none';
	}
	else{
$display='block';
}?>
	<div id='msgMY' style="display:<?php echo $display;?>;text-align: center;color: #27B056;">
		<strong>Changes Reverted Successfully.</strong>
	</div>
	<div id='head'>
		<strong>Authorize the changes made by the patients</strong>
	</div>
</body>
<table align="center">
<tr><td>
<div style="text-align: right; float: left; width: 50%">
	<?php echo $this->Form->submit('Cancel Changes',array("type"=>"submit","label"=>false,"class"=>'blueBtn')); ?>
</div></td><td>
<div style="text-align: center; float: left">
	<?php  echo $this->Html->link('Confirm Changes',"#",array("label"=>false,"class"=>'blueBtn','id'=>'confrim')); ?>
</div></td></tr>
</table>
<?php echo $this->Form->hidden('PatientAccess.fname',array('type'=>'text','value'=>$fileName));?>

<?php echo $this->Form->end(); ?>
</body>
<script>
$('#confrim').click(function(){
	confirm("You Really want to allow changes");
	
		  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "PatientAccess", "action" => "confrimChangeMRI","admin" => false)); ?>";
		   var formData = $('#authorizefrm').serialize();
	         $.ajax({	
	        	 beforeSend : function() {
	        		// this is where we append a loading image
	        		$('#busy-indicator').show('fast');
	        		},
	        		                           
	          type: 'POST',
	         url: ajaxUrl,
	          data: formData,
	          dataType: 'html',
	          success: function(data){
	        	  $('#busy-indicator').hide('fast');
	        	  if(!data==""){	
	        		  $("#msgMY").show();
		        	$("#msgMY").html('Authentication Done Successfully');
		        	parent.$.fancybox.close();
	        	  }
		        else{
	        		  $("#msgMY").show();
	        		  $("#msgMY").html('Not Confrim');
	        		  parent.$.fancybox.close();
		        }
	          },
				error: function(message){
					alert("Error in Retrieving data");
	          }        });
	    
	    return false; 
	
	
});


</script>
