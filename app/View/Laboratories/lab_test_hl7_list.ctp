<style>
.row_action img {
	float: inherit;
}

.patientHub .patientInfo .heading {
	float: left;
	width: 174px;
}

.inner_title span {
	float: right;
	margin: -15px 0 0 !important;
	padding: 0;
}
</style>
<div class="inner_title">
	<h3>Lab Result</h3>

	<span><?php
	$returnController = $this->Session->read ( 'labResultReturn' );
	$redirectAction = 'patient_information';
	if ($returnController == 'nursings') {
		$btnText = 'Back to Nursing';
	} else if ($returnController == 'laboratories') {
		$btnText = 'Back to Lab Manager';
		$redirectAction = 'labDashBoard';
	} else if ($returnController == 'users') {
		$btnText = 'Back to IPD Dashboard';
		$redirectAction = 'doctor_dashboard';
	} else {
		$btnText = 'Back to Patient Info';
	}
	
	echo $this->Html->link ( $btnText, array (
			'controller' => ! empty ( $returnController ) ? $returnController : 'patients',
			'action' => $redirectAction,
			$patient_id 
	), array (
			'escape' => false,
			'class' => 'blueBtn' 
	) );
	?> </span>
	<!-- <div style="float:right;margin: -15px 6px 0 0;">
	<?php
	// echo $this->Html->link(__('Back to IPD Dashboard'),array("controller" => "Users", "action" => "doctor_dashboard"), array('escape' => false,'class'=>"blueBtn "));
	?>
</div> -->
</div>
<p class="ht5"></p>

<!-- billing activity form start here -->
<div id="search-filter">
	<?php
	echo $this->element ( 'patient_information' );
	?>
</div>
<div align="center" id='temp-busy-indicator' style="display: none;">
	&nbsp;
	<?php echo $this->Html->image('indicator.gif', array()); ?>
</div>
<div id="test-order"></div>
<div class="clr ht5"></div>
<?php 
// debug($testOrdered);exit; 
?>
<?php
// echo $this->Form->create('Laboratories',array('action'=>'labTestHl7List',$patient_id));
echo $this->Form->create ( 'Laboratory', array (
		'url' => array (
				'controller' => 'laboratories',
				'action' => 'labTestHl7List',
				$patient_id 
		),
		'id' => 'labResultfrm',
		'inputDefaults' => array (
				'label' => false,
				'div' => false,
				'error' => false 
		) 
) );
?>
<!-- <table border="0" class=" " cellpadding="0" cellspacing="0" width="100%"
	align="center">
	<tbody>
		<tr class="row_title">
			<td class="table_cell" align="right" width=" " width="30%"><?php echo __('Performed on from date:') ?><font
				color="red">*</font></td>
			<td class=" "><?php
			echo $this->Form->input ( 'from', array (
					'name' => 'from',
					'id' => 'from',
					'label' => false,
					'div' => false,
					'error' => false,
					'readonly' => 'readonly',
					'class' => 'validate[required,custom[mandatory-enter-only]] textBoxExpnd' 
			) );
			?>
			</td>
			<td class="table_cell" align="right"><?php echo __('Performed on to date:') ?><font
				color="red">*</font></td>
			<td class=" " style="width: 55%"><?php
			echo $this->Form->input ( 'to', array (
					'name' => 'to',
					'id' => 'to',
					'label' => false,
					'div' => false,
					'readonly' => 'readonly',
					'error' => false,
					'class' => 'validate[required,custom[mandatory-enter-only]] textBoxExpnd' 
			) );
			?>
			</td>

			<td class=" " align="center"><?php
			echo $this->Form->submit ( __ ( 'Search' ), array (
					'style' => 'margin: 0 10px 0 0;',
					'class' => 'blueBtn',
					'div' => false,
					'label' => false 
			) );
			echo $this->Html->link ( "Reset", array (
					'controller' => 'laboratories',
					'action' => 'labTestHl7List',
					$patient_id 
			), array (
					'escape' => false,
					'class' => 'blueBtn' 
			) );
			?>
			</td>
		</tr>
	</tbody>
</table> -->
<?php echo $this->Form->end();?>
<?php

echo $this->Form->create ( 'Laboratory', array (
		'url' => array (
				'controller' => 'laboratories',
				'action' => 'lab_result',
				$patient_id 
		),
		'id' => 'labResultfrm1',
		'inputDefaults' => array (
				'label' => false,
				'div' => false,
				'error' => false 
		) 
) );
?>

<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%" style="text-align: center;">
	<?php
	// echo '<pre>';print_r($testOrdered);exit;
	if (isset ( $testOrdered ) && ! empty ( $testOrdered )) {
		?>
	<tr class="row_title">
		<td class="tdLabel" align="left"><?php echo $this->Paginator->sort('LabManager.order_id', __('Lab Order id', true)); ?>
		</strong></td>
		<td class="table_cell" align="center" width="%"><strong><?php echo $this->Paginator->sort('LabManager.test_name', __('Test Name', true)); ?>
		</strong></td>
		<!--  <td class="table_cell" align="center" width="3%"><?php echo  __('Code'); ?>
		</td>-->

		<td class="table_cell" align="center"><?php echo  __('Flag'); ?>
		</td>
		<!--  <td class="table_cell" align="center"><?php echo  __('Performed On'); ?>
		</td>-->
		<td class="table_cell" align="left" width="80px"
			style="text-align: center;"><strong><?php echo $this->Paginator->sort('LabManager.start_date', __('Order Date', true)); ?>
		</strong></td>

		<td class="table_cell" align="center" width=""><?php echo  __('Status'); ?>
		</td>

		<td class="table_cell" align="center" width="6%"><?php echo  __('Action'); ?>
		</td>
	</tr>
	<?php
		$toggle = 0;
		
		if (count ( $testOrdered ) > 0) {
			$toggle ++;
			$isDisplayed = array ();
			// debug($testOrdered);
			// echo count($testOrdered).'--';
			foreach ( $testOrdered as $key => $labs ) { // print_r($labs);exit;
				
				if (in_array ( $labs ['LaboratoryResult'] ['id'], $isDisplayed )) { // echo '<pre>';print_r($isDisplayed);
					continue;
				}
				$abnormalResultsStatus = '';
				foreach ( $labs ['LaboratoryHl7Result'] as $deepKey => $deepRes ) {
					if ($deepRes ['abnormal_flag'] && strtoupper ( $deepRes ['abnormal_flag'] ) != 'N') {
						$abnormalResultsStatus = 'Abnormal';
						break;
					} else {
						$abnormalResultsStatus = 'Normal';
					}
				}
				
				// $leftTimeInMin="";
				
				/*
				 * if($labs['LaboratoryResult']['tqi_start_date_time']!="")
				 * {
				 * $curdatetime=strtotime(date('Y-m-d h:i:s'));
				 * echo "cur".$curdatetime."<br/>";
				 *
				 * $finaltime_after=strtotime($labs['LaboratoryResult']['tqi_start_date_time'])+3600*3;
				 * echo "final".$finaltime_after;
				 * $leftTimeInMin=($finaltime_after-$curdatetime);///60;
				 *
				 *
				 * $ltime=$leftTimeInMin/60;
				 * echo "test".$ltime;
				 * if(round($ltime)<=180)
				 * $rowbgcolor="green";
				 * else
				 * $rowbgcolor="";
				 *
				 * }
				 */
				
				if ($toggle == 0) {
					if ($rowbgcolor != "")
						echo "<tr bgcolor='" . $rowbgcolor . "'>";
					else
						echo "<tr class='row_gray'>";
					$toggle = 1;
				} else {
					echo "<tr bgcolor='" . $rowbgcolor . "'>";
					$toggle = 0;
				}
				// status of the report
				if ($labs ['LaboratoryResult'] ['confirm_result'] == 1) {
					$status = 'Report Delivered';
				}
			 else {
					$status = 'Pending';
				}
				
				?>
	<?php
				/*
				 * $dateIncrease=$this->DateFormat->formatDate2STD($labs['LaboratoryResult']['od_observation_start_date_time'],Configure::read('date_format_us'));
				 * $timeIncreased=date('Y-m-d H:i:s', strtotime("$dateIncrease + 3 hours"));
				 * $tragetDate = date('Y-m-d H:i:s');
				 * if(($tragetDate < $timeIncreased) && ($dateIncrease!='') ){
				 * $color_limit='#80C2F2';
				 * }
				 * else{
				 * //$color_limit='white';
				 * }
				 */
				if (empty ( $labs ['Laboratory'] ['id'] )) {
					$labs ['Laboratory'] = $labs ['LaboratoryAlias'];
				}
				?>
	<tr bgcolor='<?php echo $color_limit?>' class="row_gray">
		<!--  bgcolor='<?php //echo $color_limit?>'-->
		<td class="row_format" align="left" width="12%"><?php echo $labs['LabManager']['order_id']; ?>
		</td>
		<?php
				
				$idLab = $labs [LaboratoryResult] [laboratory_id];
				echo $this->Form->hidden ( '', array (
						'name' => 'labName_' . $key,
						'value' => $labs ['Laboratory'] ['name'] 
				) );
				?>
		<td class="row_format" align="center" width="12%"><?php
				if ($labs ['LaboratoryResult'] ['od_universal_service_text'])
					echo $this->Html->link ( __ ( $labs ['LaboratoryResult'] ['od_universal_service_text'] ), "javascript:void(0)" );
				else
					echo $this->Html->link ( __ ( $labs ['Laboratory'] ['name'] ), "javascript:void(0)" ); // ,
						                                                                                       // array('onclick'=>"displayPanelData('$idLab','$key')")				?></td>
		<!-- 	 <td class="tdLabel" align="center" width="12%" style="text-align:center;"><?php
				
				if (! empty ( $labs ['Laboratory'] ['lonic_code'] )) {
					echo $labs ['Laboratory'] ['lonic_code'];
				} else {
					echo __ ( 'N/A' );
				}
				?>
		</td>-->

		<td class="tdLabel" align="right" color:
			<?php echo $color ?>" width="12%" style="text-align: center;"><?php
				
				if (! empty ( $abnormalResultsStatus )) {
					echo $abnormalResultsStatus;
				} else {
					echo __ ( 'N/A' );
				}
				?>
		</td>

		<!--  	<td class="tdLabel" align="center" width="12%" style="text-align:center;"><?php
				
				if (! empty ( $labs ['LaboratoryResult'] ['od_observation_start_date_time'] )) {
					echo $labs [LaboratoryResult] [od_observation_start_date_time];
				} else {
					echo __ ( 'N/A' );
				}
				?>
		</td>
		-->
		<td class="row_format" align="center" width="12%"><?php echo $this->DateFormat->formatDate2Local($labs['LabManager']['start_date'],Configure::read('date_format'),false); ?>
		</td>

		<td class="tdLabel" align="right" style="text-align: center;"
			width="12%"><?php
				
			if (!empty($abnormalResultsStatus)) {
    if ($labs['LaboratoryResult']['is_whatsapp_sent'] == 1) { 
        echo 'Result Published and Report Sent';
    } else {
        echo 'Result Published';
    }
} else {
    echo __('Pending');
}

				?></td>

		<td class="row_action" align="center" width="12%"><?php
				// if(!empty($labs['LaboratoryResult']['laboratory_test_order_id']))
				// echo $this->Html->link($this->Html->image('icons/view-icon2.png',array('title'=>'Result for Registries','alt'=>'Result for Registries')), array('controller'=>'laboratories','action' => 'viewLabHl7Result',$labs['LabManager']['patient_id'],$labs['LabManager']['id']), array('escape'=>false));
				// else
				// echo $this->Html->link($this->Html->image('edit-icon-back1.png',array('title'=>'Result for Registries','alt'=>'Result for Registries')), array('controller'=>'laboratories','action' => 'labHl7Result',$labs['LabManager']['id'],$labs['LabManager']['patient_id']), array('escape'=>false));
				?> <?php
				if (! empty ( $labs ['LaboratoryResult'] ['laboratory_test_order_id'] ))
					echo $this->Html->link ( $this->Html->image ( 'icons/view-icon.png', array (
							'title' => 'Result for Providers',
							'alt' => 'Result for Providers' 
					) ), array (
							'controller' => 'laboratories',
							'action' => 'viewLabTestResultsHl7',
							$labs ['LabManager'] ['patient_id'],
							$labs ['LabManager'] ['id'],
							$labs ['LaboratoryResult'] ['id'],
							'?' => array (
									'from' => 'list',
									'patientId' => $labs ['LabManager'] ['patient_id'] 
							) 
					), array (
							'escape' => false 
					) );
				else
					echo $this->Html->link ( $this->Html->image ( 'icons/edit-icon.png', array (
							'title' => 'Result for Providers',
							'alt' => 'Result for Providers' 
					) ), array (
							'controller' => 'laboratories',
							'action' => 'labTestResultsHl7',
							$labs ['LabManager'] ['id'],
							$labs ['LabManager'] ['patient_id'],
							$labs ['Laboratory'] ['id'] 
					), array (
							'escape' => false 
					) );
				$labman = $labs ['LabManager'] ['id'];
				$patient_id = $labs ['LabManager'] ['patient_id'];
				$labId = $labs ['Laboratory'] ['id'];
				echo $this->Html->link ( $this->Html->image ( 'icons/cloud_upload.png', array (
						'title' => 'Upload Document',
						'alt' => 'Upload Document' 
				) ), 'javascript:void(0)', array (
						'onclick' => "add_doc('$labman','$patient_id','$labId')",
						'escape' => false 
				) );
				if (! empty ( $labs ['LaboratoryResult'] ['upload'] )) {
					$image = FULL_BASE_URL . Router::url ( "/" ) . "uploads/laboratory/" . $labs ['LaboratoryResult'] ['upload'];
					// $docHtml .='<td><a target="_blank" href="'.$image.'">'.$getDocuments['PatientDocument']['filename'].'</a></td>';
					echo $this->Html->link ( $this->Html->image ( 'icons/doc_view2.png', array (
							'title' => 'View Attached Document',
							'alt' => 'View Attached Document' 
					) ), $image, array (
							'escape' => false,
							'target' => __blank 
					) );
				}
				?>
		</td>
	</tr>
	<?php
				
				$color_limit = '';
				if ($labs ['LaboratoryResult'] ['id'])
					array_push ( $isDisplayed, $labs ['LaboratoryResult'] ['id'] );
			}
			
			// set get variables to pagination url
			// $this->Paginator->options(array('url' =>array("?"=>$this->params->query)));
			?>
	<tr>
		<td class="row_action" align="center" colspan='11'>&nbsp;&nbsp;&nbsp;</td>
	</tr>
	<tr>
		<td class="row_action" align="center" colspan='11'><div
				id='panelDataRecived' style="display: none"></div></td>
	</tr>
	<tr>
		<TD colspan="8" align="center">
			<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('<< Previous', true), null, null, array('class' => 'paginator_links')); ?>
			<?php echo $this->Paginator->next(__('Next >>', true), null, null, array('class' => 'paginator_links')); ?>
			<!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
		</span>
		</TD>
	</tr>
	<?php } ?>
	<?php
	} else {
		?>
	<tr>
		<TD colspan="8" align="center" class="error"><?php echo __('No test assigned to selected patients', true); ?>.</TD>
	</tr>
	<?php
	}
	
	echo $this->Js->writeBuffer ();
	?>
</table>



<?php echo $this->Form->end();	 ?>
<script>
	$(document).ready(function(){

		

		$("#labResultfrm").validationEngine();
		$('.view-order-form').click(function(){
			$('#search-filter').fadeOut('slow');
			$('#flashMessage').remove();
		});

		$( "#from" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			onSelect : function() {
				$(this).focus();
				//foramtEnddate(); //is not defined hence commented
			}
	});
            $( "#to" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			onSelect : function() {
				$(this).focus();
				//foramtEnddate(); //is not defined hence commented
			}
	});
			
                  		
	});
	// Ajax call for the Panel display
    function displayPanelData(labId,key){
 	  	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "getSubLabPanelData","admin" => false)); ?>";
 	    var formData = $('#labResultfrm1').serialize();
          $.ajax({	
         	 beforeSend : function() {
         		// this is where we append a loading image
         		$('#busy-indicator').show('fast');
         	 },	                           
           type: 'POST',
           url: ajaxUrl+"/"+labId+"/"+key,
           dataType: 'html',
           data: formData,
           success: function(data){
         	  	$('#busy-indicator').hide('fast');	
 	        	$("#panelDataRecived").html(data);
 	        	$("#panelDataRecived").show();
           },
 			error: function(message){
 				alert("Error in Retrieving data");
           }        
        });
     return false; 
 	}
 // EOF
 
 function add_doc(lab_manager_id,patient_id,lab_id){			
			$.fancybox({
			'width' : '50%',
			'height' : '50%',
			'autoScale': true,
			'transitionIn': 'fade',
			'transitionOut': 'fade',
			'type': 'iframe',
			'href': "<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "addDoc")); ?>"+'/'+lab_manager_id+'/'+patient_id+'/'+lab_id,
			'onClosed': function () {
							parent.location.reload(true); 
						}
			});
			return false ;
		}
 
 
</script>

