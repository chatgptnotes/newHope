<?php 
    echo $this->Html->script(array('jquery.autocomplete'));
    echo $this->Html->css('jquery.autocomplete.css'); 
    echo $this->Html->css(array('jquery.timepicker')); 
    echo $this->Html->script(array('jquery.timepicker'));  
    
?>
<div class="inner_title">
 <h3><?php echo __('Add Surgery Note'); ?></h3>
  <span>
		<?php echo $this->Html->link(__('Back'),array("controller" => "opt_appointments", "action" => "surgery_notes", $patient_id),array('escape' => false,'class'=>"blueBtn Back"));
		?>
	</span>
</div>
<div class="patient_info">
 <?php //echo $this->element('patient_information');?>
</div> 
<div class="clr"></div>

<p class="ht5"></p>  
<form name="surgerynotesfrm" id="surgerynotesfrm" action="<?php echo $this->Html->url(array("action" => "save_surgery_notes", "admin" => false)); ?>" method="post" >

	<?php 
			echo $this->Form->hidden('Note.id');
                        echo $this->Form->input('Note.patient_id', array('type' => 'hidden', 'id'=> 'patient_id', 'value' => $patient_id)); 
                        echo $this->Form->input('Note.note_type', array('type' => 'hidden', 'id'=> 'note_type', 'value'=> 'OT')); 
	?>  
        
	<!-- BOF new HTML -->	 
	 	 	 
			 <table class="table_format"  id="schedule_form">	
			   <tr>
			    <td><label><?php echo __('Surgery');?><font color="red">*</font>:</label></td>
			    <td>
			    	 
			    	<?php
			    		echo $this->Form->input('Note.surgery_id', array('empty'=>'Please select','options'=>$getSurgery,'id' => 'surgery_id','class'=>'validate[required,custom[mandatory-select]]', 'label'=> false,'style'=> 'width:200px')); 
			    	?>
			     	
			    </td>
			   </tr>			    			    
			   <tr>
			    <td><label><?php echo __('S/B Registrar');?><font color="red">*</font>:</label></td>
			    <td>
			    	 
			    	<?php
			    		
			    		echo $this->Form->input('Note.sb_consultant', array('options'=>$consultant,'empty'=>'Please select','id' => 'sb_consultant','class'=>'validate[required,custom[mandatory-select]]', 'label'=> false,'style'=> 'width:200px')); 
			    	?>
			     	
			    </td>
			   </tr>				   
			   <tr>
			    <td><label><?php echo __('S/B  Consultant');?><font color="red">*</font>:</label></td>
			    <td>
			    	<?php
			    		
			    		echo $this->Form->input('Note.sb_registrar', array('options'=>$registrar,'empty'=>'Please select','id' => 'sb_registrar','class'=>'validate[required,custom[mandatory-select]]' , 'label'=> false,'style'=> 'width:200px')); 
			    	?>
			     	
			    </td>
			   </tr>
                           <tr>
			    <td><label><?php echo __('Type');?><font color="red">*</font>:</label></td>
			    <td>
			    	<?php
			    		$surgery_type = array('pre-operative' => 'Pre Operative', 'post-operative' => 'Post Operative', 'intra-operative' => 'Intra Operative');
			    		echo $this->Form->input('Note.surgery_note_type', array('options'=>$surgery_type,'empty'=>'Please select','id' => 'surgery_note_type','class'=>'validate[required,custom[mandatory-select]]' , 'label'=> false,'style'=> 'width:200px')); 
			    	?>
			     	
			    </td>
			   </tr>
			    <tr>
			    <td><label><?php echo __('Date');?><font color="red">*</font>:</label></td>
			    <td>
			    	<?php
			    		 
			    		echo $this->Form->input('Note.note_date', array('type'=>'text','id' => 'note_date','class'=>'validate[required,custom[mandatory-date]]' , 'label'=> false,'style'=> 'width:170px', 'value' => isset($this->data['Note']['note_date'])?$this->DateFormat->formatDate2Local($this->data['Note']['note_date'],Configure::read('date_format'), true):'')); 
			    	?>
			     	
			    </td>
			   </tr>
			  </table>	  
		 
		 
		 <div id="accordionCust">
		  <h3 style="display:block" id="post-opt-link"><a href="#" style="text-decoration:none;cursor:auto;">Surgery Note<font color="red">*</font></a></h3>
		 <div class="section" id="post-opt">
		 		<table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull formFullBorder">			 
			 	<tr>            
    	    		<td width="27%" align="left" valign="top">
    	    			<div align="center" id = 'temp-busy-indicator' style="display:none;">	
							&nbsp; <?php echo $this->Html->image('indicator.gif', array()); ?>
						</div>	
    	    			<div id="templateArea-post-opt">
    	    				    	    			 	 
    	    			</div>	    	    		 
    	    		</td>	    	    		
		              <td width="70%" align="left" valign="top">
		              	<table width="100%" border="0" cellspacing="0" cellpadding="0" >	              	 
			                  <tr>
			                  	<td width="20">&nbsp;</td>	
			                  	<td valign="top" colspan="4">
	        							 <?php echo $this->Form->textarea('Note.surgery', array('id' => 'post-opt_desc','rows'=>'21','style'=>'width:90%', 'class'=>'validate[required,custom[customnotes]]')); ?>   
	        					</td>			                    
			                 </tr>
			              </table>
			          </td>
			      </tr>			      			    
			  </table> 					 
		 </div><!-- EOF section div -->
	
		 
		 
	</div><!-- EOF accordion -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
	   	  	<td >
	   	  		<div class="btns">
	   	  				 <?php  
	   	  				 	//echo $this->Html->link(__('Cancel'), array('action' => 'surgery_notes', $patient_id), array('escape' => false,'class'=>'grayBtn'));	
					     echo $this->Html->link(__('Cancel'), 'javascript:void(0);', array('escape' => false,'class'=>'grayBtn Back'));   
	   	  				 echo $this->Form->submit(__('Submit'), array('label'=> false,'div' => false,'error' => false,'class'=>'blueBtn' ));
					        
					     ?>     
				</div>   	  		
	   	  	</td>
	   	 </tr>
   </table>
  </form>
	<!-- EOF new HTML -->
<?php echo $this->Form->end(); ?>
<?php $splitDate = explode(' ',$admissionDate);?>
<script>
	// To sate min date not more than the admission date 
		var admissionDate = <?php echo json_encode($splitDate[0]); ?>;
		var explode = admissionDate.split('-');
		
			jQuery(document).ready(function(){
				jQuery("#surgerynotesfrm").validationEngine();	
				$( "#note_date" ).datepicker({
					showOn: "button",
					buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
					buttonImageOnly: true,
					changeMonth: true,
					changeYear: true,
					yearRange: '1950',			 
					minDate : new Date(explode[0],explode[1] - 1,explode[2]),
					dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>'
				});
                                
                                // to show by default post operative template //
                                var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "add","admin" => false)); ?>";
										 		$("#post-opt").css('height','auto');	 							 
										 		$.ajax({  
										 			  type: "POST",						 		  	  	    		
													  url: ajaxUrl+"/post-opt",
													  data: "updateID=templateArea-post-opt",
													  context: document.body,								   					  		  
													  success: function(data){											 									 					 				 								  		
													   	 	$("#templateArea-post-opt").html(data);								   		
													   	 	$("#templateArea-post-opt").fadeIn();
													  }
													});

	
			});	

		$(".Back").click(function(){
			$.ajax({
				url: '<?php echo $this->Html->url(array("controller" => "opt_appointments", "action" => "surgery_notes", "admin" => false,'plugin' => false, $patient_id)); ?>',
				beforeSend:function(data){
					$('#busy-indicator').show();
				},
				success: function(data){
					$('#busy-indicator').hide();
					$("#render-ajax").html(data);
			     }
			});
		 });
	</script>

