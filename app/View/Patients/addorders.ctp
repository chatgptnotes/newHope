<?php 
echo $this->Html->script(array('jquery.min.js?ver=3.3','jquery-ui-1.8.5.custom.min.js?ver=3.3'));
echo $this->Html->script(array('jquery.autocomplete'));
echo $this->Html->css(array('jquery.autocomplete.css','internal_style.css'));
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
echo $this->Html->script(array('jquery.fancybox-1.3.4'));
?>
<?php echo $this->Html->charset(); ?>
<title><?php echo __('Hope', true); ?> <?php echo $title_for_layout; ?>
</title>
</head>
<body>

	<?php echo $this->Form->create('NewCropPrescription',array('type' => 'file','id'=>'addOrder','inputDefaults' => array(
			'label' => false,
			'div' => false,
			'error' => false,
			'legend'=>false,
			'fieldset'=>false
	)
	));
?>

<div id='showError', style="display:none;text-align:center">
<h3><font color="red">Find cannot be empty.</font></h3>
</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull" style="padding-top:14px">
		<tr>
			<th colspan="5"><?php echo __("Add Order Details") ; ?></th>
		</tr>
		<tr>
			<td width="5%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Find");?><font color="red">*</font>
			</td>

			<td width="15%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('findrecords',
				 array('type'=>'text','label'=>false,'style'=>'width:250px','id' =>'finddata',true)); ?>
				<?php  echo $this->Form->hidden('patientid',
				 array('type'=>'text','value'=>$patient_id,'label'=>false,'style'=>'width:200px','id' =>'patientid',true)); ?>
			</td>

			<td width="20%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Order Category");?>
			</td>
			<?php $options=$getDataCategory;?>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('category', array('style'=>'width:150px; float:left;',
					'options'=>$options,'id'=>'category','selected'=>$categoryOrderId));?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
			echo  $this->Js->link('<input type="button" value="Search" class="blueBtn" id="search">', array('controller'=>'patients', 'action'=>'orderresults', 'admin' => false),
 array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('hide', array('buffer' => false)),'update'=>'#resultorder', 'data' => '{finddata:$("#finddata").val(),patientid:$("#patientid").val(),category:$("#category").val()}','dataExpression' => true,'htmlAttributes' => array('escape' => false) ));echo $this->Js->writeBuffer();
				?>
			</td>
		</tr>
	</table>
	<div align="center" id='busy-indicator' style="display: none;">
		&nbsp;
		<?php echo $this->Html->image('indicator.gif', array()); ?>
	</div>
	<div id="resultorder"></div>
	<?php 
	echo $this->Form->hidden('patient_id',array('value'=>$patient_id,'id' => 'patient_id'));


	?>
	<!-- <input class="blueBtn" type=submit value="Send" name="Send" id="send" >
<input class="blueBtn" type=button value="cancel" name="cancel" id="cancel" onclick="closeFancyBox()">  -->
	<?php echo $this->Form->end();?>



</body>

</html>
<script>
$(document).ready(function(){
	// set focus
	 $('#finddata').focus();
	
	//----------------------------------------------------------------------------------------
$('#search').click(function(){
	var valueFind= $('#finddata').val();
	if(valueFind==''){
		$('#showError').show();
		return false;
	}

});
	var getData=$("#category option:selected").text();
	//var categoryOrderId=$("#category option:selected").val();	

		$('#category').on('change', function() {
			var getData=$("#category option:selected").text();
			///alert(getData);
			
		if(getData=='Lab'){ 
  			var p_id=$('#patientid').val();
	var categoryOrderId=$("#category option:selected").val();	
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "addorders","admin" => false)); ?>"+"/"+p_id+"/"+categoryOrderId;
         $.ajax({	
        	 beforeSend : function() {
        		// this is where we append a loading image
        		$('#busy-indicator').show('fast');
        		},
        		                           
          type: 'POST',
         url: ajaxUrl,
          dataType: 'html',
          success: function(data){
        	  $('#busy-indicator').hide('fast');
        	  window.location.href = '<?php echo $this->Html->url("/patients/addorders"); ?>'+"/"+p_id+"/"+categoryOrderId;	
	       		$("#resultorder").html(" ");  
          },
			error: function(message){
				alert("Error in Retrieving data");
          }        }); 
    
    return false;
	
		}
		if(getData=='Radiology'){
			
			var p_id=$('#patientid').val(); 
			var categoryOrderId=$("#category option:selected").val();	
			var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "addorders","admin" => false)); ?>"+"/"+p_id+"/"+categoryOrderId;
		         $.ajax({	
		        	 beforeSend : function() {
		        		// this is where we append a loading image
		        		$('#busy-indicator').show('fast');
		        		},
		        		                           
		          type: 'POST',
		         url: ajaxUrl,
		          dataType: 'html',
		          success: function(data){
		        	  $('#busy-indicator').hide('fast');
		        	  window.location.href = '<?php echo $this->Html->url("/patients/addorders"); ?>'+"/"+p_id+"/"+categoryOrderId;	
			       		$("#resultorder").html(" ");  
		          },
					error: function(message){
						alert("Error in Retrieving data");
		          }        }); 
		    
		    return false;
			
				}
if(getData=='Medication'){

	var p_id=$('#patientid').val();
		var categoryOrderId=$("#category option:selected").val();	
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "addorders","admin" => false)); ?>"+"/"+p_id+"/"+categoryOrderId;
	         $.ajax({	
	        	 beforeSend : function() {
	        		// this is where we append a loading image
	        		$('#busy-indicator').show('fast');
	        		},
	        		                           
	          type: 'POST',
	         url: ajaxUrl,
	          dataType: 'html',
	          success: function(data){
	        	  $('#busy-indicator').hide('fast');
	        	  window.location.href = '<?php echo $this->Html->url("/patients/addorders"); ?>'+"/"+p_id+"/"+categoryOrderId;	
		       		$("#resultorder").html(" ");  
	          },
				error: function(message){
					alert("Error in Retrieving data");
	          }        }); 
	    
	    return false;
	
				}
		});
	
	});

function ordersentences(id,category,loinc,lab_id) { 
	var toCheckExistingSenctence="0";
	
	$
			.fancybox({
			

				'width' : '100%',
				'height' : '100%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "patients", "action" => "ordersentence")); ?>"+"/"+id+"/"+category+"/"+loinc+"/"+lab_id+"/"+toCheckExistingSenctence,
				
						
			});

}
</script>
