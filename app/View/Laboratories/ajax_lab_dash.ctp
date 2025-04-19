<style>
.row_action a {
	padding: 0px;
}

.table_format td {
	padding-right: 0px !important;
}

img {
	text-align: center;
}

.row_action img {
	float: none !important;
	text-align: center;
}
</style>
<!-- form elements start-->
<?php
if (! empty ( $errors )) {
	?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left" class="error"><?php
	foreach ( $errors as $errorsval ) {
		echo $errorsval [0];
		echo "<br />";
	}
	?>
		</td>
	</tr>
</table>
<?php } ?>
<div id="content-list1"></div>
<div style="text-align: right;" class="clr inner_title"></div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
	<?php if(isset($testOrdered) && !empty($testOrdered)){  ?>

	<tr class="row_title">
		<td class="table_cell" align="center"><strong><?php echo __('Status'); ?>
		</strong></td>
		<td class="table_cell" align="center"><?php echo __('Date'); ?> </strong>
		</td>
		<td class="table_cell" align="left"><strong><?php echo __(''); ?> </strong>
		</td>
		<td class="table_cell" align="left"><strong><?php echo __('Patient Name'); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo __("Primary care provider");?>
		</strong></td>
		<td class="table_cell" align="center"><strong><?php  echo __("DOB");?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo __("Ordering Date");?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo __("Ordered Test");?>
		</strong></td>
		<td class="table_cell" align="center"><strong><?php echo __("Action");?>
		</strong></td>
		<td class="table_cell" align="center"><strong><?php echo __("Enter Lab Result");?>
		</strong></td>
		<td class="table_cell" align="Center"><strong><?php echo __("Payment");?>
		</strong></td>
	</tr>
	<?php
		$toggle = 0;
		if (count ( $testOrdered ) > 0) {
			foreach ( $testOrdered as $key => $patients ) {
				if ($toggle == 0) {
					echo "<tr class='row_gray'>";
					$toggle = 1;
				} else {
					echo "<tr>";
					$toggle = 0;
				}
				
				?>
	<td class="row_format" align="left"><?php echo $this->Form->input('',array('options'=>Configure::read('labStatusLab'),'selected'=>trim($patients['LabManager']['labDash_status']),'id'=>"status_$key",'label'=>false,'class'=>'statusAjax')); ?>
	</td>

	<td class="row_format" align="left" style="width: 14%"><?php echo$this->Form->input('',array('type'=>'text','name'=>'Laboratory[to]','id'=>"dateLab_$key",'value'=>$this->DateFormat->formatDate2Local(trim($patients['LabManager']['labDash_date']),Configure::read('date_format'),true),'class'=>'dateLab textBoxExpnd statusAjax','readonly'=>'readonly','label'=>false))?>
	</td>
	<?php if($patients['Patient']['sex']=='male'){ ?>
	<td class="row_format" align="left"><?php echo $this->Html->image('/img/icons/male.png', array('alt' => 'Male')); ?>
	</td>
	<?php }else{?>
	<td class="row_format" align="left"><?php echo $this->Html->image('/img/icons/female.png', array('alt' => 'Female')); ?>
	</td>
	<?php }?>
	<td class="row_format" align="left"><?php
				echo $this->Html->link ( $patients ['Patient'] ['lookup_name'], array (
						'controller' => 'PatientsTrackReports',
						'action' => 'sbar',
						$patients ['LabManager'] ['patient_id'],
						'admin' => false 
				), array (
						'escape' => false,
						'title' => 'Clinical Summery' 
				) );
				?> <?php $patientId=$patients['Patient']['id'];?>
	</td>
	<td class="row_format" align="center"><?php echo $patients['Initial']['name']." ".$patients[0]['name']; ?>
	</td>

	<td class="row_format" align="center"><?php
				
				echo $this->DateFormat->formatDate2Local ( $patients ['Person'] ['dob'], Configure::read ( 'date_format' ), true );
				?>
	</td>

	<?php echo $this->Form->hidden('',array('id'=>"labId_$key",'value'=>$patients['LabManager']['order_id']))?>

	<td class="row_format" align="center"><?php echo $this->DateFormat->formatDate2Local(trim($patients['LabManager']['start_date']),Configure::read('date_format'),false); ?>
	</td>
	<td><?php
				echo $this->Html->link ( 'View Details', 'javascript:void(0)', array (
						'onclick' => 'lab("' . $patientId . '")',
						'title' => 'test' 
				) )?>
		<?php  //debug($patientId); exit; ?>
	</td>
	<td class="row_format" align="left" style="width: 12%"><?php
				// $patientId=$patients['LabManager']['patient_id'];
				echo $this->Html->link ( 'Submit And Print', 'javascript:void(0)', array (
						'onClick' => 'barcodeSpecific("' . $patientId . '","' . $key . '")',
						'title' => 'Bar Code',
						'class' => 'blueBtn statusAjax',
						'id' => "print_$key",
						'label' => false,
						'disabled' => true 
				) );
				?>
	</td>
	<td class="row_action" align="center"><?php
				
				if ($patients ['LabManager'] ['showEdit'] == '1') {
					$blue = 'block';
					$red = 'none';
				} else {
					$blue = 'none';
					$red = 'block';
				}
				?> <span style="display:<?php echo $blue?>" id='blue_<?php echo $key?>'><?php
				
				echo $this->Html->link ( $this->Html->image ( 'icons/edit-icon.png', array (
						'title' => 'Enter Lab',
						'alt' => 'Enter Lab Result' 
				) ), array (
						'action' => 'labTestHl7List',
						$patients ['Patient'] ['id'],
						'?' => array (
								'return' => 'laboratories' 
						) 
				), array (
						'escape' => false 
				) );
				?>
	</span> <span style="display:<?php echo $red?>" id='red_<?php echo $key?>'><?php
				
				echo $this->Html->link ( $this->Html->image ( 'icons/edit-grey.png', array (
						'title' => 'InActive',
						'alt' => 'Enter Lab Result' 
				) ), 'javascript:void(0)', array (
						'escape' => false 
				) );
				?></span></td>
	<td style="text-align: left;" class="tdLabel" id="boxSpace"><?php
				// payament
				if (! $billingData [$patientId] ['paidAmount'] || $patients ['0'] ['totalAmount'] == null) {
					echo $this->Html->link ( $this->Html->image ( 'icons/red.png', array () ), array (
							'controller' => 'Billings',
							'action' => 'multiplePaymentModeIpd',
							$patientId 
					), array (
							'escape' => false,
							'title' => 'Laboratory Payment' 
					) );
				} else if ($billingData [$patientId] ['paidAmount'] < $patients ['0'] ['totalAmount']) {
					echo $this->Html->link ( $this->Html->image ( 'icons/orange_new.png', array () ), array (
							'controller' => 'Billings',
							'action' => 'multiplePaymentModeIpd',
							$patientId 
					), array (
							'escape' => false,
							'title' => 'Laboratory Payment' 
					) );
				} else if ($billingData [$patientId] ['paidAmount'] >= $patients ['0'] ['totalAmount']) {
					echo $this->Html->link ( $this->Html->image ( 'icons/green.png', array () ), array (
							'controller' => 'Billings',
							'action' => 'multiplePaymentModeIpd',
							$patientId 
					), array (
							'escape' => false,
							'title' => 'Laboratory Payment' 
					) );
				}
				?>
						</td>
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
			<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
			<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
			<!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
		
		
		
		
		
		
		
		</TD>
	</tr>
	<?php
		}
		?>
	<?php
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
<div id="formdisplayid1" colspan="5" style="margin-top: 10px">
	</td>
	<script>               
	 function lab($patientId) { 
		 //alert($patientId);	
		$.fancybox({
		'width' : '60%',
		'height' : '60%',
		'autoScale': true,
		'transitionIn': 'fade',
		'transitionOut': 'fade',
		'type': 'iframe',
		'href': "<?php echo $this->Html->url(array("controller" =>"Laboratories","action" =>"labdash"));?>"+'/'+$patientId,
		});
		}
	//script to include datepicker
		$(function() {	
			$( ".dateLab" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,  		
				yearRange: '1950',			 
				dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
			});
			
		});                       
		//script to include datepicker
		$(function() {	
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
		$('.statusAjax').on('change',function(){
			var statusId=$(this).attr('id');
			var keyValue =statusId.split('_');
			if(keyValue[0]=='status'){
				var labId=$("#labId_"+keyValue[1]).val();
				var dateLab=$("#dateLab_"+keyValue[1]).val();
				var dateID="dateLab_"+keyValue[1];
				if(dateLab==''){
					  inlineMsg(dateID,'Please fill');
					  return false;
				}
				var statusValue=$('#'+statusId).val()
			}else{
				var labId=$("#labId_"+keyValue[1]).val();
				var dateLab=$("#dateLab_"+keyValue[1]).val();
				var statusValue=$('#status_'+keyValue[1]).val()
			}
			 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "labDashBoardUpdate","admin" => false)); ?>";
			 var formData = $("#dateLab_"+keyValue[1]).serialize();
		         $.ajax({	
		        	 beforeSend : function() {
		        		// this is where we append a loading image
		        		 loading();
		        		},
		        		                           
		          type: 'POST',
		         url: ajaxUrl+"/"+labId+"/"+statusValue,
		         data: formData,
		          success: function(data){ 
		        	  if(statusValue=="Sample Collected"){
		        		  inlineMsg(statusId,'Status Updated');
		        	  }else{
		        		  inlineMsg(statusId,'Appointment Scheduled');
		        	  }
		        	  
		        	  onCompleteRequest();
			        
		          },
					error: function(message){
						alert("Error in Retrieving data");
		          }        });
		    
		    return false; 
			
		}); 
		
</script>