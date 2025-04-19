<?php echo $this->Form->create('Room', array('id'=>'room','url'=>array('controller'=>'rooms','action'=>'edit',$room_id,$ward_id))); ?>


<div class="inner_title">
 
	<h3>	
			<div style="float:left"><?php echo __('Edit Room').' - '.ucfirst($wardName); ?></div>			
			
	</h3>
	<div class="clr"></div>
</div>
   <p class="ht5"></p>
   
   <!-- two column table start here -->
  
                            	
<table width="40%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
	<td width="150" height="35" valign="middle" align="right" id="boxSpace1">Room Name:<font color="red">*</font> </td>
	<td width="" align="left" valign="middle">
		<?php 
			 echo $this->Form->hidden('id',array()) ;
		echo $this->Form->input('',array('value'=>$roomDetails['Room']['name'],'type'=>'text','class' => 'validate[required,custom[mandatory-enter-only]]','name'=>'data[Room][name]','legend'=>false,'label'=>false,'id' => 'name'));?></td>
  </tr>
  <tr>
	<td width="150" height="35" valign="middle" align="right" id="boxSpace1">Room Type:<font color="red">*</font> </td>
	<td width="" align="left" valign="middle">
		<?php 
		echo $this->Form->input('',array('options'=>Configure::read('roomtType'),'type'=>'select' ,'name'=>'data[Room][room_type]','legend'=>false,'label'=>false,'id' => 'room_type','value'=>$roomDetails['Room']['room_type']));?></td>
  </tr>
  <tr>
	<td height="35" valign="middle" align="right" id="boxSpace1">Bed Prefix:<font color="red">*</font></td>
	<td align="left" valign="middle">
	<?php echo $this->Form->input('',array('value'=>$roomDetails['Room']['bed_prefix'],'type'=>'text','class' => 'validate[required,custom[mandatory-enter-only]]','name'=>'data[Room][bed_prefix]','legend'=>false,'label'=>false,'id' => 'bed_prefix'));?></td>
  </tr>
  <tr>
	<td height="35" valign="middle" align="right" id="boxSpace1">No. of Beds:<font color="red">*</font></td>
	<td align="left" valign="middle">
	<?php echo $this->Form->input('',array('value'=>$roomDetails['Room']['no_of_beds'],'type'=>'text','class' => 'validate[required,custom[onlyNumber]]','name'=>'data[Room][no_of_beds]','legend'=>false,'label'=>false,'id' => 'no_of_beds'));?></td>
  </tr>
</table>
<!-- two column table end here -->
<div align="center">
<?php echo $this->Html->link(__('Back'),array('controller'=>'rooms','action' => 'index',$ward_id,'admin'=>false), array('escape' => false,'class'=>'blueBtn'));?>
<input class="blueBtn" type="submit" value="Save" id="save">
</div>    
                    <div class="clr ht5">&nbsp;</div>
 <?php echo $this->Form->end(); ?>                   
<script>
jQuery(document).ready(function(){
	jQuery("#room").validationEngine();
	$("#location_id").change(function(){
		$("#ward_id option").remove();
		$("#ward_id").append( "<option value=''>Please Select</option>" );
		 $.ajax({
			  url: "<?php echo $this->Html->url(array("controller" => 'wards', "action" => "getWardsByLocation", "admin" => false)); ?>"+"/"+$('#location_id').val(),
			  context: document.body,				  		  
			  success: function(data){//alert(data);
			  	data= $.parseJSON(data);
			  	$("#ward_id option").remove();
			  	$("#ward_id").append( "<option value=''>Please Select</option>" );
				$.each(data, function(val, text) {
				    $("#ward_id").append( "<option value='"+val+"'>"+text+"</option>" );
				});
									  			
			    		
			  }
		});
   });

	$("#ward_id").change(function(){
		 $.ajax({
			  url: "<?php echo $this->Html->url(array("controller" => 'wards', "action" => "getWardDetailsById", "admin" => false)); ?>"+"/"+$('#ward_id').val(),
			  context: document.body,				  		  
			  success: function(data){//alert(data);
			  	data= $.parseJSON(data);
			  	$.each(data, function(val, text) {
			  		//alert(val+'--'+text);
			  		if(val == 'wardid'){
			  			$("#wardid").val(text);			
			  		}
			  		if(val == 'no_of_rooms'){
			  			$("#no_of_rooms").val(text);			
			  		} 
				});
									  			
			    		
			  }
		});
   });

});
</script>	
