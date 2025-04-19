<style>
.row_action a {
	padding: 0px;
}

.under a {
	text-decoration: underline;
	padding: 2px 0px;
}
</style>
<?php
echo $this->Html->script ( array (
		'jquery-ui-1.8.5.custom.min.js',
		'jquery.autocomplete.js',
		'jquery.fancybox-1.3.4.js' 
) );
echo $this->Html->css ( array (
		'jquery.autocomplete.css',
		'jquery.fancybox-1.3.4.css' 
) );
?>

<?php
echo $this->Html->script ( 'jquery.autocomplete' );
echo $this->Html->css ( 'jquery.autocomplete.css' );
?>
<div class="inner_title">
	<h3><?php echo __('Laboratories Dashboard'); ?></h3>
	<span><?php echo $this->Html->link(__('Back'),array('action'=>'index'),array('escape'=>false,'class'=>'blueBtn','id'=>'reset-form'));?></span>

</div>

<!-- form elements start-->
<?php
if (! empty ( $errors )) {
	?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left" class="error">
		   		<?php
	foreach ( $errors as $errorsval ) {
		echo $errorsval [0];
		echo "<br />";
	}
	?>
	  		</td>
	</tr>
</table>
<?php
}

if (isset ( $this->request->query )) {
	$getData = $this->request->query;
	$fromDate = isset ( $getData ['from'] ) ? $getData ['from'] : '';
	$toDate = isset ( $getData ['to'] ) ? $getData ['to'] : '';
	$lookupName = isset ( $getData ['from'] ) ? $getData ['lookup_name'] : '';
	$patientId = isset ( $getData ['patient_id'] ) ? $getData ['patient_id'] : '';
	$admissionId = isset ( $getData ['admission_id'] ) ? $getData ['admission_id'] : '';
	$labTestName = isset ( $getData ['lab_test_name'] ) ? $getData ['lab_test_name'] : '';
	$radiologyTestName = isset ( $getData ['radiology_test_name'] ) ? $getData ['radiology_test_name'] : '';
	$histologyTestName = isset ( $getData ['histology_test_name'] ) ? $getData ['histology_test_name'] : '';
}

?>

<div align="center" id='temp-busy-indicator' style="display: none;">	
		&nbsp; <?php echo $this->Html->image('indicator.gif', array()); ?>
 </div>
<div id="test-order"></div>

<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
<?php if(isset($data) && !empty($data)){  ?>
			
				  
				  <tr class="row_title">
		<td class="table_cell" align="left"><strong><?php echo (__('Patient ID', true)); ?></strong></td>
		<!-- <td class="table_cell" align="left"><strong><?php echo (__('Registration ID', true)); ?></strong></td>
					   <td class="table_cell" align="left"><strong><?php echo (__('Order ID', true)); ?></strong></td>
					   <td class="table_cell" align="left"><strong><?php echo (__('Tests', true)); ?></strong></td>
					   -->
		<td class="table_cell" align="left"><strong><?php echo (__('Patient Name', true)); ?></strong></td>
		<td class="table_cell" align="left"><strong><?php echo (__(Configure::read('doctor'), true)); ?></strong></td>

		<td class="table_cell" align="left"><strong><?php echo (__('Test Name', true)); ?></strong></td>

		<!-- <td class="table_cell" align="left"><strong><?php echo (__('Ordered On', true)); ?></strong></td> -->
		<td class="table_cell" align="left"><strong><?php echo  __('Is Sample Taken?', true); ?></strong></td>
		<!-- <td class="table_cell" align="left"><strong><?php echo  __('Action'); ?></strong></td> -->
	</tr>
				  <?php
	$toggle = 0;
	if (count ( $data ) > 0) {
		foreach ( $data as $patients ) {
			if ($toggle == 0) {
				echo "<tr class='row_gray'>";
				$toggle = 1;
			} else {
				echo "<tr>";
				$toggle = 0;
			}
			?>								  
								   <td class="row_format" align="left"><?php echo $patients['Patient']['patient_id']; ?></td>
	<!--  <td class="row_format" align="left"><?php echo $patients['Patient']['admission_id']; ?> </td>
									<td class="row_format" align="left"><?php echo $patients['LabManager']['order_id']; ?> </td>
								   <td class="row_format" align="left"><?php echo $patients['Laboratory']['name']; ?> </td>-->
	<td class="row_format" align="left"><?php echo $patients['PatientInitial']['name'].' '.$patients['Patient']['lookup_name']; ?> </td>
	<td class="row_format" align="left"><?php echo $patients['Initial']['name']." ".$patients[0]['name']; ?> </td>
	<td class="row_format" align="left"><?php echo $patients['Laboratory']['name']; ?> </td>

	<!--  <td class="row_format" align="left"><?php
			
			echo $this->DateFormat->formatDate2Local ( $patients ['LabManager'] ['start_date'], Configure::read ( 'date_format' ), false );
			?> </td>	   -->
	<td class="under" align="center">
									 <?php
			
			$labManagerID = $patients ['LabManager'] ['id'];
			$labManagerPatientID = $patients ['LabManager'] ['patient_id'];
			
			if (! empty ( $patients ['LaboratoryToken'] ['ac_id'] ) || ! empty ( $patients ['LaboratoryToken'] ['sp_id'] )) {
				echo $this->Html->link ( "Yes", "#", array (
						'escape' => false,
						'onClick' => "edit($labManagerID,$labManagerPatientID)" 
				) );
				?>
										<?php
			} else {
				echo $this->Html->link ( "No", "#", array (
						'escape' => false,
						'onClick' => "edit($labManagerID,$labManagerPatientID)" 
				) );
			}
			?>
									
									 </td>
	<!--   <td class="row_action" align=""><?php
			if ($patients ['LaboratoryResult'] ['confirm_result'] != 1) {
				// echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('controller'=>'Laboratories','action' => 'lab_result',$patients['LabManager']['patient_id'],$patients['Laboratory']['id'],$patients['LabManager']['id']), array('escape'=>false));
				echo $this->Js->link ( $this->Html->image ( 'icons/edit-icon.png', array (
						'title' => 'edit',
						'alt' => 'Edit' 
				) ), array (
						'id' => 'opener',
						'controller' => 'laboratories',
						'action' => 'lab_manager_test_order',
						$patients ['LabManager'] ['id'],
						$patients ['LabManager'] ['patient_id'] 
				), array (
						'escape' => false,
						'update' => '#test-order',
						'method' => 'post',
						'class' => 'view-order-form',
						'complete' => $this->Js->get ( '#temp-busy-indicator' )->effect ( 'fadeOut', array (
								'buffer' => false 
						) ),
						'before' => $this->Js->get ( '#temp-busy-indicator' )->effect ( 'fadeIn', array (
								'buffer' => false 
						) ) 
				) );
			} else {
				// print result
				$publishTime = strtotime ( $patients ['LaboratoryResult'] ['result_publish_date'] );
				$currentTime = time ();
				$diffHours = date ( "H", $currentTime - $publishTime );
				// $dateDiff = $this->DateFormat->dateDiff($publishTime,$currentTime);
				
				if ($patients ['LaboratoryResult'] ['confirm_result'] == 1 && ($diffHours < 25)) {
					echo $this->Html->link ( $this->Html->image ( 'icons/edit-icon.png', array (
							'title' => 'Published Result' 
					) ), array (
							'controller' => 'Laboratories',
							'action' => 'incharge_lab_result',
							$patients ['LabManager'] ['patient_id'],
							$patients ['Laboratory'] ['id'],
							$patients ['LabManager'] ['id'] 
					), array (
							'escape' => false 
					) );
				}
				
				// echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Published Result')),'#',array('escape' => false,
				// 'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'print_preview',$patients['LabManager']['patient_id'],$patients['Laboratory']['id'],$patients['LabManager']['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=850,left=400,top=300,height=700'); return false;"));
			}
			?>
								  </td>	 -->
	</tr>
					  <?php
		}
		
		// set get variables to pagination url
		$this->Paginator->options ( array (
				'url' => array (
						"?" => $this->params->query 
				) 
		) );
		?>
					   <tr>
		<TD colspan="8" align="center">
			<!-- Shows the page numbers -->
					 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
					 <!-- Shows the next and previous links -->
					 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
					 <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
					 <!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
					    
		
		
		
		
		
		</TD>
	</tr>
			<?php
	}
	?> <?php
} else if (! empty ( $this->params->query )) {
	
	?>
			  <tr>
		<TD colspan="8" align="center" class="error"><?php echo __('No record found', true); ?>.</TD>
	</tr>
			  <?php
}

echo $this->Js->writeBuffer ();
?>
		  
		 </table>

<script>               

	$(document).ready(function(){
  	 
			$("#lookup_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","lookup_name", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true,
				 
			});			 			 
			$("#patient_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Person","patient_uid", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true,
				 
			});
			$("#admission_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","admission_id", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true,
				 
			});

			/*$('#lookup_name,#patient_id,#admission_id').keyup(function(){
				$("#lab_test_name,#radiology_test_name,#histology_test_name").attr('disabled','disabled');
			}); 
			$('#lab_test_name,#radiology_test_name,#histology_test_name').keyup(function(){
				$("#lookup_name,#patient_id,#admission_id").attr('disabled','disabled');
			});*/
			 	
			$("#lab_test_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Laboratory","name", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});			 			 
			$("#radiology_test_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Radiology","name", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
			$("#histology_test_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Histology","name", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});

			$('#reset-form').click(function(){
				$(':input').each(function(index, value){
					if($(this).val() != 'Search'){
				  		$(this).val('');
					}
				});
								
			});

			$('.view-order-form').click(function(){
					$('#search-filter').fadeOut('slow');
					$('#flashMessage').remove();
			});
				
			
	 	});
	
	//script to include datepicker
		$(function() {	
			$( "#to-date" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,  		
				yearRange: '1950',			 
				dateFormat:'dd/mm/yy'
			});
			$( "#from-date" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,  		
				yearRange: '1950',			 
				dateFormat:'dd/mm/yy'
			});
		});                       
	//function to check search filter
		$('#patient-search').submit(function(){
			var msg = false ; 
			$("form input:text").each(function(){
			       //access to form element via $(this)
			       
			       if($(this).val() !=''){
			       		msg = true  ;
			       }
			    }
			);
			if(!msg){
				alert("Please fill atleast one field .");
				return false ;
			}		
		});
	//EOF check on search filter
	
	

	function edit(labManagerID,labManagerPatientID)
	{
		$.fancybox({
			'width' : '60%',
			'height' : '60%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'onComplete' : function() {
				$("#lab_manager_test_order").css({
					'top' : '20px',
					'bottom' : 'auto',
					
				});
			},
			'href' : "<?php echo $this->Html->url('/laboratories/lab_manager_test_order_dashboard'); ?>"+"/"+labManagerID+"/"+labManagerPatientID
			
		});
	}
</script>
