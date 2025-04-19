<?php  /* echo $this->Html->css(array('jquery.fancybox-1.3.4.css','jquery.autocomplete.css'));    
echo $this->Html->script(array('jquery-ui-1.8.5.custom.min.js','slides.min.jquery.js',
		'jquery.isotope.min.js','jquery.custom.js','ibox.js','jquery.selection.js','jquery.autocomplete','ui.datetimepicker.3.js','jquery.fancybox-1.3.4'));

*/?>

<div class="inner_left" id="list_content">
	

	<!-- 	<div class="inner_title">

 	<div style="float: left">
			<h3>
				<?php echo __('SOAP Notes'); ?>
			</h3>
		</div> -->
		<div style="text-align: right;padding-right:20px">
			&nbsp;


			<?php 
			if($patient['Patient']['admission_type']=='OPD'){
					$backBtnUrl =  array('controller'=>'PatientsTrackReports','action'=>'sbar',$patientid);
					echo $this->Html->link(__('Back to Clinical Summry'),$backBtnUrl,array('class'=>'blueBtn','div'=>false));
			}?>
			<?php  
			echo $this->Html->link(__('Add Note'), array('controller'=>'notes','action' => 'soapNoteIpd', $patientid), array( 'onclick'=>"return confirm('Adding a new progress note will close previous note.Do you wish to continue?');", 'escape' => false,
			'update'=>'#list_content','method'=>'post','class'=>'blueBtn','before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
		 	 			'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false))));
		 	 	//echo $this->Html->link(__('Add Note'), array('controller'=>'patients','action' => 'sampleadd', $patientid), array('escape' => false));
    		echo $this->Js->writeBuffer();
    		?>
		</div>
<!-- 	</div>-->
	
<?php //echo $this->element('patient_information');?>
<div class="clr">&nbsp;</div>
<!-- 	<table border="0" class=" " cellpadding="0" cellspacing="0"
		width="500px" align="left">
		<tbody>
			<?php     //echo $this->Form->hidden('Patientid',array('id'=>'Patientid','value'=>$patientid,'autocomplete'=>"off")); ?>
			<tr class="">

				<!-- <td class=" " align="right"><label style="width: 145px"> <?php echo __('Search By Description :') ?>
				</label></td>

				<td class=" " style="margin-right: 5px;"><?php  if($search == "#list_patient" || $search == "list_patient") { 
					$search = "";
				}
				echo    $this->Form->input('soaptext', array('type'=>'text','value'=>$search,'id' => 'soaptext', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:150px'));
				?>
				</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>

				<td class="blueBtn" align="center"
					style="color: '#00000'; margin-left: 5px; width: 200px cursor='pointer'"><a
					href="javascript:ref('<?php echo $patientid;  ?>') "
					style="color: #000; text-decoration: none;">Search</a>
				</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><?php 
				$pat_uid = $patient['Patient']['id'];
				echo $this->Html->link(__('Temp Chart'),'#',array('escape'=>false,'id'=>'pres_temp','onClick'=>"pres_temp('$pat_uid')"));
				//echo $this->Html->link(__('Add UID Patient'), array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
				?>
				</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><?php 
				$pat_uid = $patient['Patient']['id'];
				echo $this->Html->link(__('P.R Chart'),'#',array('escape'=>false,'id'=>'pres_pr','onClick'=>"pres_pr('$pat_uid')"));
				//echo $this->Html->link(__('Add UID Patient'), array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
				?>
				</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><?php 
				$pat_uid = $patient['Patient']['id'];
				echo $this->Html->link(__('R.R Chart'),'#',array('escape'=>false,'id'=>'pres_rr','onClick'=>"pres_rr('$pat_uid')"));
				//echo $this->Html->link(__('Add UID Patient'), array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
				?>
				</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><?php 
				$pat_uid = $patient['Patient']['id'];
				echo $this->Html->link(__('B.P Chart'),'#',array('escape'=>false,'id'=>'pres_bp','onClick'=>"pres_bp('$pat_uid')"));
				//echo $this->Html->link(__('Add UID Patient'), array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
				?>
				</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><?php 
				$pat_uid = $patient['Patient']['id'];
				echo $this->Html->link(__('SPO2 Chart'),'#',array('escape'=>false,'id'=>'pres_spo','onClick'=>"pres_spo('$pat_uid')"));
				//echo $this->Html->link(__('Add UID Patient'), array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
				?>
				</td>
			</tr>
		</tbody>
	</table> -->
	<?php	 if(isset($result) && empty($result) && ($search != "")) {

		?>

	<table border="0" class="" cellpadding="0" cellspacing="0"
		align="center" style="margin-left: 50x;">
		<tr class="">
			<TD colspan="8" style="width: 120px"><?php echo __('No record found', true); ?>.
			</TD>
		</tr>

	</table>

	<?php
	}
	?>
	<div class="patient_info" id="addNote">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">


						<tr class="row_title">
							<td class="table_cell"><strong> <?php echo __('Created Time', true); ?>
							</strong></td>
							<td class="table_cell"><strong> <?php echo __('Action', true); ?>
							</strong></td>
						</tr>
						<?php 

						if(!empty($noteData)) { 

  	  $toggle =0;
  	  $i=0 ;
  	  foreach($noteData as $key=>$data){

			       if($toggle == 0) {
				       	echo "<tr class='row_gray'>";
				       	$toggle = 1;
			       }else{
				       	echo "<tr>";
				       	$toggle = 0;
			       }
			       ?>

						<td class="row_format" style="font-color:black !important">
							<?php 	$splitDate = explode(' ',$data['Note']['note_date']);
									echo $this->DateFormat->formatDate2Local($data['Note']['create_time'],Configure::read('date_format'),true);
							?>
						</td>
						<td><?php  if($data[Note][sign_note]== '1'){ 
										$dispSign = 'block';$dispUnSign = 'none'; 
									}
									else{
										 $dispSign = 'none';$dispUnSign = 'block'; 
							}?> 
						<span class="signTrue<?php echo $data['Note']['id'];?>" style="display: <?php echo $dispSign;?>">
								<?php 	echo $this->Js->link($this->Html->image('icons/view-icon.png', array('title' => 'View Note', 'alt'=> 'Note View')), array('controller'=>'patientForms','action' => 'power_note',
										$data['Note']['id'],$patientid), array('update' => '#list_content','method'=>'post' ,'escape'=>false,
												'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));?> 
												<a
								href="javascript:sign('<?php echo $patientid;  ?>','<?php echo '0'; ?>','<?php echo $data['Note']['id']; ?>','<?php echo $patientuid; ?>') "
								onclick="return confirm('Do you want to unsign note?');"
								style="color: #000; text-decoration: none;"><?php echo $this->Html->image('icons/sign-icon.png', array('title' => 'UnSign Note', 'alt'=> 'UnSign Note')); ?>
							</a>
						</span> <?php  ?>
						 <span class="signFalse<?php echo $data['Note']['id'];?>" style="display: <?php echo $dispUnSign;?>"> <?php 	echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title' => 'Edit Note', 'alt'=> 'View')),
									array('controller'=>'notes','action' => 'soapNoteIpd',$patientid,$data['Note']['id']),
									array('update' => '#list_content','method'=>'post','escape'=>false,
													'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
													'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));
							  ?> <?php $role = $this->Session->read('role');
							  ?> <a
								href="javascript:sign('<?php echo $patientid;  ?>','<?php echo '1'; ?>','<?php echo $data['Note']['id']; ?>','<?php echo $patientuid; ?>') "
								onclick="return confirm('Notes once get signed will not be edited further..');"
								style="color: #000; text-decoration: none;"> <?php echo $this->Html->image('icons/unlock.png', array('title' => 'Sign Note', 'alt'=> 'Sign Note')); ?>
							</a>

						</span> 
						<?php if($data['Note']['compelete_note']=='0'){?>
						<span id='red_<?php echo $key;?>'>
							<?php echo $this->Html->image('icons/red_small.png', array('onclick'=>'completeNew("'.$key.'","'.$data['Note']['id'].'")','title' => 'Incomplete Note', 'alt'=> 'Incomplete Note')); ?>
						</span>
						<span id='green_<?php echo $key;?>' style="display:none;">
							<?php echo $this->Html->image('icons/green_small.png', array('title' => 'Complete Note', 'alt'=> 'Complete Note')); ?>
						</span>
						<?php }else{?>
						<span>
							<?php echo $this->Html->image('icons/green_small.png', array('title' => 'Complete Note', 'alt'=> 'Complete Note')); ?>
						</span>
						<?php }?>
						</td>
						</tr>

						<?php		$i++ ;  
}    ?>
						<tr>
							<TD colspan="8" align="center">
								<!-- Shows the page numbers --> <!-- Shows the next and previous links -->
								<?php  echo $this->Paginator->prev(__('« Previous', true), array('update'=>'#list_content',    												
										'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
    											'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>
								<?php  echo $this->Paginator->next(__('Next »', true), array('update'=>'#list_content',    												
										'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
    											'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>
								<!-- prints X of Y, where X is current page and Y is number of pages -->
								<span class="paginator_links"> <?php  echo $this->Paginator->counter(array('class' => 'paginator_links'));?>
							</span>
							</TD>
						</tr>
						<?php
						echo $this->Js->writeBuffer();
      } else {
  ?>
						<tr>
							<TD colspan="8" align="center"><?php echo __('No record found', true); ?>.
							</TD>
						</tr>
						<?php
      }
      ?>
					</table>
				</td>
				<?php	 if(isset($result) && !empty($result)) { ?>
				<td>
					<table border="0" class="table_format" cellpadding="0"
						cellspacing="0" width="100%" style="margin-bottom: 24px;">
						<tr class="row_title">
							<td class="table_cell" style: align="centre"><strong>Search
									Results </strong></td>
						</tr>
						<?php  foreach($result as $result){ ?>
						<tr>
							<td class="row_format" style: align="centre"><b><span
									style="text-decoration: underline;"> <?php 
									echo $this->Js->link(__($search, true), array('action' => 'notes_view', $result[Note][id],$patientid,$search), array('update' => '#list_content','method'=>'post' ,'escape'=>false,'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
				    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)))); ?>
								</span> </b> found in note created on&nbsp;<?php $splitDate = explode(' ',$result['Note']['note_date']);
																								echo $this->DateFormat->formatDate2Local($result['Note']['note_date'],Configure::read('date_format'),true);?>
							</td>
						</tr>
						<?php }?>
					</table>
				</td>
				<?php } 	 echo $this->Js->writeBuffer(); ?>

			</tr>
		</table>
	</div>
</div>
<script>
	function ref(patient_id) {
		var soaptext = $('#soaptext').val();
		if (soaptext == '') {
			alert("Please enter text to search");
			exit;
		}
		location.href = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "patient_notes")); ?>"
				+ '/' + patient_id + '/' + soaptext

	}
	
	function sign(patientId, signNote, noteId) {
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "signNote")); ?>"
				+ '/' +  signNote + '/' + noteId;
		$.ajax({
			type: 'POST',
			url: ajaxUrl,
			dataType: 'html',
			 beforeSend:function(){
				   loading('wrapper','class'); 
				  },
     		success: function(data){
     			onCompleteRequest('wrapper','class'); 
         		if(signNote == 1){
         			$('.signFalse'+noteId).hide();
         			$('.signTrue'+noteId).show();
         			window.location.href = "<?php echo $this->Html->url(array("controller" => "Users", "action" => "doctor_dashboard")); ?>";
         		}else{
         			$('.signTrue'+noteId).hide();
         			$('.signFalse'+noteId).show();
         		}
         	}
		});
				
	}
//---------view ccda-----
	
			function viewccda(patient_id,patient_uid,note_id) {

		
				$.fancybox({

				'width' : '70%',
				'height' : '100%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "ccda", "action" => "viewccda")); ?>"
				+ '/' + patient_id + '/' + patient_uid + '/'+note_id
				});

				}
	/*  
	$("#soaptext").autocomplete("<?php echo $this->Html->url(array("controller" => "Patient", "action" => "search_notes", "admin" => false,"plugin"=>false)); ?>", {
	width: 250,
	selectFirst: true
	});
	}); */

	function pres_temp(patientid){//alert(patientid);

	$
	.fancybox({
		'width' : '70%',
		'height' : '90%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'onComplete' : function() {
			$("#allergies").css({
				top : '20px',
				bottom : auto,
				position : absolute
			});
		},
		'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "temp_chart",$patientid)); ?>"

	});
		 
	}

	function pres_pr(patientid){

		$
		.fancybox({
			'width' : '70%',
			'height' : '90%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'onComplete' : function() {
				$("#allergies").css({
					top : '20px',
					bottom : auto,
					position : absolute
				});
			},
			'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "pr_chart",$patientid)); ?>"

		});
			 
		}

	function pres_rr(patientid){

		$
		.fancybox({
			'width' : '70%',
			'height' : '90%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'onComplete' : function() {
				$("#allergies").css({
					top : '20px',
					bottom : auto,
					position : absolute
				});
			},
			'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "rr_chart",$patientid)); ?>"

		});
			 
		}

	function pres_bp(patientid){

		$
		.fancybox({
			'width' : '70%',
			'height' : '90%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'onComplete' : function() {
				$("#allergies").css({
					top : '20px',
					bottom : auto,
					position : absolute
				});
			},
			'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "bp_chart",$patientid)); ?>"

		});
			 
		}

	function pres_spo(patientid){

		$
		.fancybox({
			'width' : '70%',
			'height' : '90%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'onComplete' : function() {
				$("#allergies").css({
					top : '20px',
					bottom : auto,
					position : absolute
				});
			},
			'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "spo2_chart",$patientid)); ?>"

		});
			 
		}
	function completeNew(key, noteId) {
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "complete")); ?>"
				+ '/' +  '1' + '/' + noteId;
		$.ajax({
			type: 'POST',
			url: ajaxUrl,
			dataType: 'html',
			 beforeSend:function(){
				   loading('wrapper','class'); 
				  },
     		success: function(data){
         		$('#red_'+key).hide();
         		$('#green_'+key).show();
         		
     			onCompleteRequest('wrapper','class'); 
         		
         	}
		});
				
	}
</script>
