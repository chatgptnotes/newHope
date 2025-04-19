<style>
.row_action a {
	padding: 0px;
}
</style>

<!-- form elements start-->
<?php
if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left" class="error"><?php 
		foreach($errors as $errorsval){
		         		echo $errorsval[0];
		         		echo "<br />";
		     		}
		     		?>
		</td>
	</tr>
</table>
<?php } ?>
<div id="content-list1"></div>
<div
	style="text-align: right;" class="clr inner_title"></div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
	<?php if(isset($data) && !empty($data)){  ?>


	<tr class="row_title">
		<td class="table_cell" align="left"><strong><?php echo __('Status'); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo __('Date'); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo __(''); ?> </strong>
		</td>
		<td class="table_cell" align="left"><strong><?php echo __('Patient Name'); ?>
		</strong></td>
		 <td class="table_cell" align="Center"> <strong><?php echo __("Primary care provider");?>
		</strong></td>
		<td class="table_cell" align="left" style="text-align: center;"><strong><?php  echo __("DOB");?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo __("Order Date");?>
		</strong></td>
			<td class="table_cell" align="left"><strong><?php echo __("Test Names");?>
		</strong></td>
		
		<td class="table_cell" align="left"><strong><?php echo __("Payment");?>
		</strong></td>
	</tr>
	<?php //debug($testOrdered);
				  	  $toggle =0;
				  	  if(count($data) > 0) {
				      		foreach($data as $key=>$patients){

							       if($toggle == 0) {
								       	echo "<tr class='row_gray'>";
								       	$toggle = 1;
							       }else{
								       	echo "<tr>";
								       	$toggle = 0;
							       }

							       ?>
	<td class="row_format" align="left"><?php echo $this->Form->input('',array('options'=>Configure::read('labStatusRad'),'selected'=>trim($patients['RadiologyTestOrder']['status']),'id'=>"status_$key",'label'=>false,'class'=>'statusAjax')); ?>
	</td>

	<td class="row_format" align="left" style="width:5%"><?php echo$this->Form->input('',array('type'=>'text','name'=>'Laboratory[to]','id'=>"dateLab_$key",'value'=>$this->DateFormat->formatDate2Local(trim($patients['RadiologyTestOrder']['radDash_date']),Configure::read('date_format'),true),'class'=>'dateLab textBoxExpnd statusAjax','readonly'=>'readonly','label'=>false)) ?>
	</td>
	<?php if($patients['Patient']['sex']=='male'){ ?>
	<td class="row_format" align="left"><?php echo $this->Html->image('/img/icons/male.png', array('alt' => 'Male')); ?>
	</td>
	<?php }else{?>
	<td class="row_format" align="left"><?php echo $this->Html->image('/img/icons/female.png', array('alt' => 'Female')); ?>
	</td>
	<?php }?>
	<td class="row_format" align="left"><?php 
	
	echo $this->Html->link($patients['Patient']['lookup_name'],array('controller'=>'PatientsTrackReports','action'=>'sbar',$patients['Patient']['id'],'admin'=>false),array('escape'=>false,'title'=>'Clinical Summery'));
	
	//echo $patients['Patient']['lookup_name']; ?>
	</td>
	 <td class="row_format" align="center"><?php echo $patients['Initial']['name']." ".$patients[0]['name']; ?> </td>	
	<td class="row_format" align="center"><?php echo $this->DateFormat->formatDate2Local($patients['Person']['dob'],Configure::read('date_format'),true);  
	?>
	</td> 
	<td class="row_format" align="left"><?php echo $this->DateFormat->formatDate2Local(trim($patients['RadiologyTestOrder']['radiology_order_date']),Configure::read('date_format'),false); ?>
	</td>
<!--  	<?php echo $this->Form->hidden('',array('id'=>"labId_$key",'value'=>$patients['RadiologyTestOrder']['order_id']))?>
	<td class="row_format" align="left"><?php //echo $patients['RadiologyTestOrder']['order_id']; ?>
	</td>
	<td class="row_format" align="left"><?php// echo $patients['Radiology']['name']; ?>
	
	</td>--> <?php $patientId=$patients['Patient']['id']; ?> 
	<td ><?php echo $this->Html->link('Test Names','javascript:void(0)', array('onclick'=>'rad_test("'.$patientId.'")','title'=>'test')) ?>
	</td>
	<td style="text-align: left;" class="tdLabel" id="boxSpace"><?php //payament
		if(!$billingData[$patientId]['paidAmount'] || $patients['0']['totalAmount'] == null){
			echo $this->Html->link($this->Html->image('icons/red.png',array()),array('controller'=>'Billings','action' => 'multiplePaymentModeIpd',$patientId), array('escape' => false,'title'=>'Laboratory Payment'));
				}else if($billingData[$patientId]['paidAmount'] < $patients['0']['totalAmount']){
			echo $this->Html->link($this->Html->image('icons/orange_new.png',array()),array('controller'=>'Billings','action' => 'multiplePaymentModeIpd',$patientId), array('escape' => false,'title'=>'Laboratory Payment'));
			   }else if($billingData[$patientId]['paidAmount'] >= $patients['0']['totalAmount']){
				echo $this->Html->link($this->Html->image('icons/green.png',array()),array('controller'=>'Billings','action' => 'multiplePaymentModeIpd',$patientId), array('escape' => false,'title'=>'Laboratory Payment'));
		} 
		?>
	 </td>
	</tr>
	<?php } 

	//set get variables to pagination url
	$this->Paginator->options(array('url' =>array("?"=>$this->params->query)));
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
				      } ?>
	<?php
			      } else if(!empty($this->params->query)) {

			 ?>
	<tr>
		<TD colspan="8" align="center" class="error"><?php echo __('No record found', true); ?>.</TD>
	</tr>
	<?php
			      }

			      echo $this->Js->writeBuffer();
			      ?>

</table>
<div id="formdisplayid1" colspan="5" style="margin-top: 10px">
	</td>
	<script>               
	
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
		 function rad_test($patientId) { 	
				$.fancybox({
				'width' : '70%',
				'height' : '70%',
				'autoScale': true,
				'transitionIn': 'fade',
				'transitionOut': 'fade',
				'type': 'iframe',
				'href': "<?php echo $this->Html->url(array("controller" => "Radiologies","action" => "raddash")); ?>"+'/'+$patientId,
				});
				};                  
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
		 
		
</script>