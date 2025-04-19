<p class="ht5"></p> 
 <?php echo $this->Form->create('Note',array('id'=>'patientnotesfrm','default'=>false,'inputDefaults' => array('label' => false,'div' => false,'error'=>false)));?>

	<?php 
		echo $this->Form->hidden('Note.id',array('id'=>'noteidVal'));
		echo $this->Form->input('Note.patient_id', array('type' => 'hidden', 'id'=> 'patient_id', 'value' => $patient_id));
		echo $this->Form->input('Note.note_type', array('type' => 'hidden', 'id'=> 'note_type', 'value'=> 'anaesthesia-operative'));
	?>

	<!-- BOF new HTML -->

	<table class="table_format" id="schedule_form">
		<tr>
			<td  class="tdLabel">
				<b><?php echo __(' Surgery ');?>:</b><font color="red">*</font>
			</td>
			<td class="tdLabel">
				<?php echo $this->Form->input('Note.surgery_id', array('options'=>$surgeries,'empty'=>'Please select','id' => 'surgery','class'=>'validate[required,custom[mandatory-select]]', 'label'=> false,'style'=> 'width:200px'));
				?>
			</td>
			<td class="tdLabel">
				<b><?php echo __(' Date ');?>:</b><font color="red">*</font>
			</td>
			<td class="tdLabel">
				<?php echo $this->Form->input('Note.note_date', array('type'=>'text','id' => 'note_date','class'=>'validate[required,custom[mandatory-date]] textBoxExpnd' , 'label'=> false,'style'=> 'width:170px' ,'value' => isset($this->data['Note']['note_date'])?$this->DateFormat->formatDate2Local($this->data['Note']['note_date'],Configure::read('date_format'), true):''));
				?>
			</td>
		</tr>

		<tr>
			<td class="tdLabel">
				<b><?php echo __('Surgeon');?>:</b>
			</td>
			<td class="tdLabel">
				<?php 
					echo  ucfirst($surgeon['0']['name']);
					echo $this->Form->hidden('Note.sb_consultant', array('id' => 'sb_consultant','class'=>'validate[required,custom[mandatory-select]]', 'label'=> false,'style'=> 'width:200px','value'=>$surgeon['User']['id']));
				?>
			</td>
				<?php if(isset($ansth)&& !empty($ansth)){?> 
			<td class="tdLabel">
				<b><?php echo __('Anaesthetist');?>:</b>
			</td>
			<td class="tdLabel">
				<?php
				echo  ucfirst($ansth['0']['name']);
				echo $this->Form->hidden('Note.sb_registrar', array('id' => 'sb_registrar','class'=>'validate[required,custom[mandatory-select]]' , 'label'=> false,'style'=> 'width:200px','value'=>$ansth['User']['id']));
				?>
			</td>
				<?php }?>
		</tr>
	</table>
	<div id="accordionCust">
		<h4 style="display: block" id="post-opt-link">
			<?php echo "Anaesthesia Note"?><font color="red">*</font>
			<span id="allMsg"></span>
		</h4>
		<div class="section" id="post-opt" style="background-color: #96CDCD !important; border-radius: 5px;	">
			<table width="100%" cellpadding="0" cellspacing="0" border="0"
				class="formFull formFullBorder">
				<tr>
					<td width="35%" class="tdLabel"  valign="top">
						<div align="center" id='temp-busy-indicator'
							style="display: none;">
							&nbsp;
							<?php echo $this->Html->image('indicator.gif', array()); ?>
						</div>
						<div id="templateArea-post-opt"></div>
					</td>
					<td width="65%" class="tdLabel" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td valign="top" class="tdLabel"><?php echo $this->Form->textarea('Note.anaesthesia_note', array('id' => 'post-opt_desc','rows'=>'21','style'=>'width: 488px; height: 304px;', 'class'=>'validate[required,custom[customnotes]]')); ?>
								</td>
							</tr>
							<tr>
								<td align="right" style="padding-right: 40px;">
									<?php  
										echo $this->Form->input(__('Submit'), array('type'=>'button','id'=>'submit','label'=> false,'div' => false,'error' => false,'class'=>'blueBtn' ));

									?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
		<!-- EOF section div -->
	</div>
	<!-- EOF accordion -->
</form>
<!-- EOF new HTML -->
<?php echo $this->Form->end(); ?>
<div>&nbsp;</div>
<div style="height: 250px;overflow: scroll;">
	<table border="0" class="" cellpadding="0" cellspacing="0" width="100%">
		<tr class="">
			<td class="tdOrders" align="left">
				<strong>
					<?php echo  __('Surgery', true); ?>
				</strong>
			</td>
			<td class="tdOrders" align="left">
				<strong>
					<?php echo __('Anaesthetist', true); ?>
				</strong>
			</td>
			<td class="tdOrders" align="left">
				<strong>
					<?php echo __('Surgeon', true); ?>
				</strong>
			</td>
			<td class="tdOrders" align="left">
				<strong>
					<?php echo __('Created Time', true); ?>
				</strong>
			</td>
			<td class="tdOrders" align="left">
				<strong>
					<?php echo __('Notes', true); ?>
				</strong>
			</td>
			<td class="tdOrders" align="left">
				<strong><?php echo __('Action', true); ?> </strong>
			</td>
		</tr>
		<?php 
		$cnt =0;
		if(count($data) > 0) {
	       foreach($data as $post_operative_checklist):
	       $cnt++;
	  	?>
		<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
			<td class="row_format" align="left" valign="top">
				<?php echo $post_operative_checklist['Surgery']['name']; ?>
			</td>
			<td class="row_format" align="left" valign="top">
				<?php echo $post_operative_checklist['Initial']['name']." ".$post_operative_checklist[0]['doctor_name']; ?>
			</td>
			<td class="row_format" align="left" valign="top">
				<?php echo $post_operative_checklist['PatientInitial']['name']." ".$post_operative_checklist[0]['registrar']; ?>
			</td>
			<td class="row_format" align="left" valign="top">
				<?php if($post_operative_checklist['Note']['note_date'] && $post_operative_checklist['Note']['note_date'] !="0000-00-00 00:00:00") echo $this->DateFormat->formatDate2Local($post_operative_checklist['Note']['note_date'],Configure::read('date_format'), true); ?>
			</td>
			<td class="row_format" align="left" valign="top">
				<?php echo $post_operative_checklist['Note']['anaesthesia_note']; ?>
			</td>
			<td class="row_action" align="left" valign="top">
				<?php 
					echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'view_ot_post_operative_checklist',$patient_id, 'otpcid' => $post_operative_checklist['Note']['id']), array('escape' => false,'title' => __('View', true), 'alt'=>__('View', true)));

					echo $this->Html->link($this->Html->image('icons/edit-icon.png'),'javascript:void(0)', array('escape' => false,'class'=>'editNotesPre','noteID'=>$post_operative_checklist['Note']['id']
						,'note_date'=>date('m/d/Y',strtotime($post_operative_checklist['Note']['note_date']))
						,'post_opt'=>$post_operative_checklist['Note']['anaesthesia_note']
						,'SurgeryName'=>$post_operative_checklist['Surgery']['name']
						,'title' => __('Edit', true), 'alt'=>__('Edit', true)));
					
					echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'delete_ot_post_operative_checklist', $patient_id, 'otpcid' => $post_operative_checklist['Note']['id']), array('escape' => false,'title' => __('Delete', true), 'alt'=>__('Delete', true)),__('Are you sure?', true));
				
				?>
			</td>
		</tr>
			<?php endforeach;  ?>
			<?php
		         } else {
		  ?>
		<tr>
			<TD colspan="10" align="center"><?php echo __('No record found', true); ?>.</TD>
		</tr>
		<?php
	      }
	      ?>
	</table>
</div>
<?php $splitDate = explode(' ',$admissionDate);?>
<script>
	// To sate min date not more than the admission date 
		var admissionDate = <?php echo json_encode($splitDate[0]); ?>;
		var explode = admissionDate.split('-');
		
			jQuery(document).ready(function(){
				$( "#note_date" ).datepicker({
					showOn: "button",
					buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
					buttonImageOnly: true,
					changeMonth: true,
					changeYear: true,
					float:"left",
					yearRange: '1950',			 
					minDate : new Date(explode[0],explode[1] - 1,explode[2]),
					dateFormat:'<?php echo $this->General->GeneralDate();?>',
					onSelect:function(){$(this).focus()}
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


		$("#submit").click(function(){
		var validatePerson = jQuery("#patientnotesfrm").validationEngine('validate');
					if (validatePerson) {
						$(this).css('display', 'none');
					}
			if($('#surgery').val()=='' || $('#note_date').val()=='' || $('#post-opt_desc').val()==''){
				return false;
			}else{
				$('#submit').hide();
			}
			$.ajax({
				type:"POST",
				data: $('#patientnotesfrm').serialize(),
				url: '<?php echo $this->Html->url(array("controller" => "opt_appointments", "action" => "save_ot_post_operative_checklist", "admin" => false,'plugin' => false)); ?>',
				beforeSend:function(data){
					$('#busy-indicator').show();
				},
				success: function(data){
					$('#busy-indicator').hide();
					$('#allMsg').show().html($.trim(data)).css("color", "#42647F"); 
					$('#allMsg').focus();
					$('#aN').trigger("click");
					setTimeout(function(){ 
						$('#allMsg').hide();
					 }, 3000);
			     }
			});
		});

		$(".editNotesPre").click(function(){
			var surgeryname=$(this).attr('surgeryname');
			var post_opt=$(this).attr('post_opt');
			var note_date=$(this).attr('note_date');
			var noteid=$(this).attr('noteid');
			$('#noteidVal').val(noteid);
			$('#note_date').val(note_date);
			$('#surgery selected:option').text(surgeryname);
			$('#post-opt_desc').val(post_opt);
			$('#post-opt_desc').focus();
			var loopData = <?php echo json_encode($surgeries)?>;
			$.each( loopData, function( key, value ) {
				if(value==surgeryname){
					$('#surgery').val(key);
				}
			});
		});
</script>
