<!-- CodeCreatives -->
<?php 
	/*$patient      = $_SESSION['pateintDetails'];
	$summary      = $_SESSION['notesRec'];
	$oprNotes     = $_SESSION['oprNotes'];
	$name         = isset($patient[0]['lookup_name']) ? $patient[0]['lookup_name'] : '';
	$sex          = isset($patient['Patient']['sex']) ? $patient['Patient']['sex'] : '';
	$admission_id = isset($patient['Patient']['admission_id']) ? $patient['Patient']['admission_id'] : '';
	$patient_uid  = isset($patient['Person']['patient_uid']) ? $patient['Person']['patient_uid'] : '';
	$dob          = isset($patient['Person']['dob']) ? $patient['Person']['dob'] : '';*/
?>
<!-- End -->
<style>
.padding_bottom{ padding-bottom:15px;}
</style>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
		<td width="374" align="left" valign="top">
	        <table width="100%" border="0" cellspacing="0" cellpadding="0">
	          <tr>
	          	
	            <td width="100%" align="left" valign="top" class="tempSearch"> 
	                <?php //BOF dialog form 
					 		if(!empty($this->data['NoteTemplate']['id']) || $emptyTemplateText){
					 			$template_form  = "block";
					 			$search_template ='none';
					 		}else{
					 			$template_form  = "none";
					 			$search_template = 'block';
					 		}
					 	?>
	                <div id="search_template" style="margin:0px 3px;display:<?php echo $search_template ;?>">
	               			
						 <p> <br>
						<?php						
								 echo 	$this->Form->input('',array('name'=>$template_type,'id'=>'search','autocomplete'=>'off','type'=>'text', 'label'=>false,'div'=>false,'value'=>'Search Template Title',
										"style"=>"margin-right:3px;","onfocus"=>"javascript:if(this.value=='Search Template Title'){this.value='';  }",
										"onblur"=>"javascript:if(this.value==''){this.value='Search Template Title';} "));
								  
								 echo $this->Js->link($this->Html->image('icons/refresh-icon.png'), array('alt'=>'Reset search','title'=>'Reset search','action' => 'add',$template_type), 
								 array('escape' => false,'update'=>"#$updateID",
								 'method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
								  'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));

								   			
								 
								 echo $this->Html->image('icons/plus-icon.png',array('alt'=>'Add Template text ','title'=>'Add Template text','id'=>'add-template','style'=>'padding-left:5px;cursor:pointer'));
								 echo $this->Js->link($this->Html->image('/img/icons/order_set/lookup.png'),array(),array('escape'=>false,'id'=>'icon_search','title'=>'Search','alt'=>'Search'));
							?>
						</p>
					</div>	
	                <?php echo $this->Form->create('NoteTemplate',array('action'=>'add_doctor_template','id'=>'doctortemplatefrm','default'=>false,'inputDefaults' => array('label' => false,'div' => false,'error'=>false)));?>
						 						 
					 	 
					 	<div id="add-template-form" style="display:<?php echo $template_form ;?>;">
							<?php
 
							  if(!empty($errors)) {
							?>
								<table border="0" cellpadding="0" cellspacing="0" width=""  align="center" id="error">
									<tr>
								  		<td colspan="2" align="left" class="error" style="color:#8C0000">
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
							<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" >
								<tr>
									<td style="text-align:center;"><?php echo __('Add Template Title');?>:</td>
									<td><?php 
											echo $this->Form->hidden('id');
											echo $this->Form->input('template_name',array('type'=>'text'));
											echo $this->Form->hidden('template_type',array('value'=>$template_type));
									 ?>	</td>
								</tr>
								
								<tr>
									<td colspan="2" align="right">		
								   		<?php echo $this->Html->link(__('Cancel'),"#",array('id'=>'close-template-form','class'=>'grayBtn')); ?>			     	 
										<?php echo $this->Js->submit('Submit', array('class' => 'blueBtn','div'=>false,'update'=>"#$updateID",'method'=>'post','url'=>array('controller'=>'notes','action'=>'add',$template_type)	)); ?>
										<?php //echo $this->Js->link(__('Submit'),array('controller'=>'doctor_templates','action'=>'doctor_template'),array('class'=>'blueBtn','div'=>false,'update'=>'#templateArea','method'=>'post')); ?>
				 
									</td>
								</tr>
							</table>						 
						</div>
					 <?php echo $this->Form->end(); ?>
	            </td>
	          </tr>
	          <tr>
	            <td width="100%" align="left" valign="top" height="10"></td>
	          </tr>
	          <tr>
	            <td width="100%" align="left" valign="top" class="tempDataBorder">
	            	<p class="tempHead">Favorite Templates:</p>
	            	<div class="tempData" id="template-list-<?php echo $template_type ;?>">
	                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
	                    	 
	                        <?php 
							      $cnt =0;
							      if(count($data) > 0) {
							       foreach($data as $doctortemp):
							       $cnt++;
							  ?>
								   <tr >		
								  
									    <td align="right" style="padding-bottom:15px; padding-left:10px">
									   <?php
									   		if($doctortemp['NoteTemplate']['user_id']=='0'){
									   			echo  $this->Html->image('icons/favourite-icon.png', array('title'=> __('Admin Template', true), 'alt'=> __('Doctor Template Edit', true)));
									   		}else{
									   			echo "&nbsp;";
									   		}  
									   ?>
									   </td>  
								   <td class="row_format leftPad10" style="padding-bottom:10px">
								   		<?php 
								   		 
								   		 	echo $this->Js->link(ucwords($doctortemp['NoteTemplate']['template_name']), array('action' => 'add_template_text', $doctortemp['NoteTemplate']['id']), array('style'=>'font-size:14px;','escape' => false,'update'=>"#$updateID",'method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
								    	 											'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));
								   			 
								   		?>
								   </td>
								   <td style="padding-bottom:15px">
								   <?php
										   if($doctortemp['NoteTemplate']['user_id']=='0'){
										   			echo "&nbsp;";
										   }else{
								   					echo $this->Js->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Doctor Template Edit', true), 'alt'=> __('Doctor Template Edit', true))),
								   								 array('action' => 'add',$template_type, $doctortemp['NoteTemplate']['id']), array('escape' => false,'update'=>"#$updateID",'method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
								    							'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));
										
								   			}	  
								 
								   ?>
								   </td>
								   <td style="padding-bottom:15px">
								   <?php
										   if($doctortemp['NoteTemplate']['user_id']=='0'){
										   			echo "&nbsp;";
										   }else{
								   					echo $this->Js->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Doctor Template delete', true), 'alt'=> __('Doctor Template delete', true))),
								   								 array('action' => 'deleteTitle',$template_type, $doctortemp['NoteTemplate']['id']), array('escape' => false,'update'=>"#$updateID",'method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
								    							'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));
										
								   			}	  
								 
								   ?>
								   <!-- <button type="button" class="ques1" data-question="<?php echo $doctortemp['NoteTemplate']['template_name']; ?>"> -->
								   	<?php //echo $this->Html->image('icons/search_icon.png', array('title'=> __('Search', true), 'alt'=> __('Search', true), 'height'=> __('12px', true))); ?>
								   </td>
								  </tr>
							  <?php endforeach;  ?>				   
					  <?php		  
					      } else {
					  ?>
						  <tr>
						   		<TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
						  </tr>
					  <?php
					      }	
					      ?>
	                    </table>
	                </div>
	            </td>
	          </tr>
	      </table>
    	</td>
    </tr>
</table>

<!-- <textarea class="gpt_input" name="gpt_input" placeholder="Choose from above or type here.." style=" min-width: 499px;"></textarea>
<br>
<button type="button" class="blueBtn btn btn-default get_gpt_reply_1">Search</button>
<button type="button" class="blueBtn btn btn-default fetch_data">Fetch Data</button> -->
			<?php
		      echo $this->Js->writeBuffer(); 	//please do not remove 
		  ?>		  
	 
<script>
// CodeCreatives
/*var name         = "<?php echo $name ?>";
var sex          = "<?php echo $sex ?>";
var admission_id = "<?php echo $admission_id ?>";
var patient_uid  = "<?php echo $patient_uid ?>";
var dob          = "<?php echo $dob ?>";
var diagnosis    = "<?php echo isset($oprNotes['OperativeNote']) && isset($oprNotes['OperativeNote']['diagnosis']) ? $oprNotes['OperativeNote']['diagnosis'] : ''; ?>";
var procedure    = "<?php echo isset($oprNotes['OperativeNote']) && isset($oprNotes['OperativeNote']['procedure_name']) ? $oprNotes['OperativeNote']['procedure_name'] : '' ?>";
// Discharge Summary Data..
var examine       = "<?php echo isset($summary['DischargeSummary']) && isset($summary['DischargeSummary']['general_examine']) ? preg_replace( "/\r|\n/", "", $summary['DischargeSummary']['general_examine']) : '' ?>";
var complaints    = "<?php echo isset($summary['DischargeSummary']) && isset($summary['DischargeSummary']['complaints']) ? preg_replace( "/\r|\n/", "", $summary['DischargeSummary']['complaints']) : '' ?>";
var investigation = "<?php echo isset($summary['DischargeSummary']) && isset($summary['DischargeSummary']['investigation']) ? preg_replace( "/\r|\n/", "", $summary['DischargeSummary']['investigation']) : '' ?>";

$('.fetch_data').click(function() {
	var param = 'Diagnosis: ' + diagnosis + ', ';
	param += 'Procedure: ' + procedure + ',';
	param += 'Presenting Complaints: ' + complaints + ',';
	param += 'Examination: ' + examine + ',';
	param += 'Investigations: ' + investigation;
	$('.gpt_input').val(param);
});*/

/*$('.get_gpt_reply_1').click(function() {

	var input = $('.gpt_input').val();
	// $('.gpt_input').val(input);

	if (input != '') {
		$.ajax({
        	beforeSend : function() {
        		$("#busy-indicator").show();
        	},
        	complete: function() {
        		$("#busy-indicator").hide();
        	},
        	type: 'POST',
        	url: "/hope/notes/chatGPT",
        	data: {'gpt_input' : input},
        	success: function(response) {
        		var content = $('#optText').text();
	        	content += (content != '') ? '&#13;&#13;' : '';
        		content += `Name: ` + name + `&#13;Gender: ` + sex + ` &#13;Admission ID: ` + admission_id + `&#13;MRN ID: ` + patient_uid + '&#13;Date Of Birth: ' + dob + '&#13;' + response;
        		if (response) {
        			$('#present-cond_desc').html(content);
        		}
        	},
        });
	}
});*/

/*$('.ques1').click(function() {
	var question = $(this).attr('data-question');
	var prevVal = $('.gpt_input').val();
	$('.gpt_input').val(prevVal + ', ' + question);
});*/
// End
			jQuery(document).ready(function(){
				$('#selection').click(function(){		 	 
			 	    var  icd_text='' ;
					var icd_ids = $( '#diagnosis', window.opener.document ).val();		 				 	 
			 		$("input:checked").each(function(index) {
			 			 if($(this).attr('name') != 'undefined'){    	
					        $( '#diagnosis', window.opener.document ).val($( '#diagnosis', window.opener.document ).val()+"\r\n"+$(this).val());
					    }
					});		 	
			 		window.close();
		 	     });
		 		$('#add-template').click(function(){
		 			$('#search_template').fadeOut('slow');
		 			$('#add-template-form').delay(800).fadeIn('slow');		 			
		 			return false ;
		 		});
			 
				$('#close-template-form').click(function(){
					$('#error').html('');
		 			$('#add-template-form').fadeOut('slow');
		 			$('#search_template').delay(800).fadeIn('slow');
		 			return false ;
		 		});
				$('#search').keypress(function(e) {
				    if(e.which == 13) {
				        return false;
				    }
				});
	 			//BOF template search
	 			$('#icon_search').click(function(){
		 			//collect name of search ele	
		 			var searchName = $('#search').attr('name');
		 			var replacedID = "templateArea-"+searchName ;	
		 			var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "template_search",$template_type,"admin" => false)); ?>";
		 			//check if the request is for current text
		 			var template_type ='<?php echo $template_type; ?>' ; 
		 			if(template_type !='' && template_type==searchName){
	 					$.ajax({  
				 			  type: "POST",						 		  	  	    		
							  url: ajaxUrl,
							  data: "searchStr="+$('#search').val(),
							  context: document.body,
							  beforeSend:function(){
						    		// this is where we append a loading image
						    		$('#busy-indicator').show('fast');
							  },					  		  
							  success: function(data){	
								 
								    $('#busy-indicator').hide('fast');				 					 				 								  		
							   		$("#template-list-"+searchName).html(data);								   		
							   		$("#template-list-"+searchName).fadeIn();
							   		
							  }
						});
		 			}else{
			 			return false ;
		 			}
	 			});
	 			//EOF tempalte search
						
			});	
</script>
				