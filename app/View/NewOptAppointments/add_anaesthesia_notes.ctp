<?php 
    echo $this->Html->script(array('jquery.autocomplete'));
    echo $this->Html->css('jquery.autocomplete.css'); 
    echo $this->Html->css(array('jquery.timepicker')); 
    echo $this->Html->script(array('jquery.timepicker'));  
    
?>
<div class="inner_title">
 <h3><?php echo __('Add Anaesthesia Note'); ?></h3>
  <span>
		<?php 
			echo $this->Html->link(__('Back'),'javascript:void(0);', array('escape' => false,'class'=>"blueBtn Back"));
		?>
	</span>
</div>
<div class="patient_info">
 <?php //echo $this->element('patient_information');?>
</div> 
<div class="clr"></div>
<p class="ht5"></p>  
<form name="anaesthesianotesfrm" id="anaesthesianotesfrm" action="<?php echo $this->Html->url(array("action" => "save_anaesthesia_notes", "admin" => false)); ?>" method="post" >

	<?php 
			echo $this->Form->hidden('Note.id');
                        echo $this->Form->input('Note.patient_id', array('type' => 'hidden', 'id'=> 'patient_id', 'value' => $patient_id)); 
                        echo $this->Form->input('Note.note_type', array('type' => 'hidden', 'id'=> 'note_type', 'value'=> 'anaesthesia')); 
	?>  
        
	<!-- BOF new HTML -->	 
	 	 	 
			 <table class="table_format"  id="schedule_form">	
			  <tr>
			    <td><font color="red">*</font><?php echo __(' Surgery ');?>:</td>
			    <td>
			    	 
			    	<?php
			    		
			    		echo $this->Form->input('Note.surgery_id', array('options'=>$surgeries,'empty'=>'Please select','id' => 'surgery_id','class'=>'validate[required,custom[mandatory-select]]', 'label'=> false,'style'=> 'width:200px')); 
			    	?>
			     	
			    </td>
			   </tr>			    			    
			   <tr>
			    <td><font color="red">*</font><?php echo __(' S/B Registrar ');?>:</td>
			    <td>
			    	 
			    	<?php
			    		
			    		echo $this->Form->input('Note.sb_consultant', array('options'=>$consultant,'empty'=>'Please select','id' => 'sb_consultant','class'=>'validate[required,custom[mandatory-select]]', 'label'=> false,'style'=> 'width:200px')); 
			    	?>
			     	
			    </td>
			   </tr>				   
			   <tr>
			    <td><font color="red">*</font><?php echo __(' S/B  Consultant ');?>:</td>
			    <td>
			    	<?php
			    		
			    		echo $this->Form->input('Note.sb_registrar', array('options'=>$registrar,'empty'=>'Please select','id' => 'sb_registrar','class'=>'validate[required,custom[mandatory-select]]' , 'label'=> false,'style'=> 'width:200px')); 
			    	?>
			     	
			    </td>
			   </tr>
                           <tr>
			    <td><font color="red">*</font><?php echo __(' Type ');?>:</td>
			    <td>
			    	<?php
			    		$anaesthesia_type = array('pre-operative' => 'Pre Operative', 'post-operative' => 'Post Operative', 'intra-operative' => 'Intra Operative');
			    		echo $this->Form->input('Note.anaesthesia_note_type', array('options'=>$anaesthesia_type,'empty'=>'Please select','id' => 'anaesthesia_note_type','class'=>'validate[required,custom[mandatory-select]]' , 'label'=> false,'style'=> 'width:200px')); 
			    	?>
			     	
			    </td>
			   </tr>
			    <tr>
			    <td><font color="red">*</font><?php echo __(' Date ');?>:</td>
			    <td>
			    	<?php
			    		 
			    		echo $this->Form->input('Note.note_date', array('type'=>'text','id' => 'note_date','class'=>'validate[required,custom[mandatory-date]]' , 'label'=> false,'style'=> 'width:170px', 'value' => isset($this->data['Note']['note_date'])?$this->DateFormat->formatDate2Local($this->data['Note']['note_date'],Configure::read('date_format'), true):'')); 
			    	?>
			     	
			    </td>
			   </tr>
			  </table>	  
		 
		 
		 <div id="accordionCust">
		  <h3 style="display:block" id="post-opt-link"><a href="#" style="text-decoration:none;cursor:auto;">Anaesthesia Note<font color="red">*</font></a></h3>
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
	        							 <?php echo $this->Form->textarea('Note.anaesthesia_note', array('id' => 'post-opt_desc','rows'=>'21','style'=>'width:90%', 'class'=>'validate[required,custom[customnotes]]')); ?>   
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
	   	  		<div class="btns" style="padding-right: 80px">
	   	  				 <?php  
	   	  				 	//echo $this->Html->link(__('Cancel'), array('action' => 'anaesthesia_notes', $patient_id), array('escape' => false,'class'=>'grayBtn'));	
					        echo $this->Html->link(__('Cancel'),'javascript:void(0);', array('escape' => false,'class'=>'grayBtn Back'));
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
                               jQuery("#anaesthesianotesfrm").validationEngine();
					
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
				url: '<?php echo $this->Html->url(array("controller" => "opt_appointments", "action" => "anaesthesia_notes", "admin" => false,'plugin' => false, $patient_id)); ?>',
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
